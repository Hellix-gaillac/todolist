<?php

class Session implements SessionHandlerInterface, ORM
{
    public $sid; //PHPSESSID
    public $data; //Données de session(sérialisées et déssérialisées automatiquement par php.)
    public $date_maj; //Date MySQL de dernière mise à jour.
    public $delai; // Temps écoulé depuis la dernière mise à jour.PUBLIC sinon FETCH_INTO impossible
    private $timeout; // Temps écoulé depuis la dernière mise à jour.
    private static $instance; // instance de session unique;

    private function __construct()
    { }

    public static function getInstance($timeout = null) // Single tone
    {
        if (!self::$instance) {
            self::$instance = new Session();
            self::$instance->timeout = $timeout; //car $this->timeout pas possible car on est dans une méthode static.
            // avant session_start, regarder si la session qui arrive avec un cookie, il faut vérifier si le cookie n'est pas expiré, alors session destroy().
            self::$instance->checkTimeout();
            session_set_save_handler(self::$instance); // php gèrera les session grâce à cette instance.
            session_start(); //déclenche la session
        }
        return self::$instance;
    }
    private function checkTimeout() //SECURITE pour un unlog de l'user aprés le delai de session.
    {
        //A appeler impérativement Avant session_start.
        $session_name = session_name(); //recupère le nom de la session.
        if (isset($_COOKIE[$session_name])) { // si cookie, on récupère le sid
            $this->sid = $_COOKIE[$session_name];
            $this->charger();
            if ($this->timeout && $this->delai && $this->delai > $this->timeout) {
                $this->destroy($this->sid);
            }
        }
    }
    public function get($cle)
    {
        return isset($_SESSION[$cle]) ? $_SESSION[$cle] : null; //isset si $_SESSION[$cle] existe
    }
    public function set($cle, $val)
    {
        $_SESSION[$cle] = $val;
    }
    public function charger()
    {
        $db = DBMySQL::getInstance();
        $req = "SELECT *, TIMESTAMPDIFF(SECOND,date_maj,NOW()) delai FROM session WHERE sid={$db->esc($this->sid)}"; // implémente le delai dans $delai grâce au fetch_into de DBMySQL.php.
        return $db->xeq($req)->ins($this);
    }
    public function sauver()
    {
        //Persister $this en se basant sur sa PK.
        $db = DBMySQL::getInstance();
        $req = "INSERT INTO session VALUES({$db->esc($this->sid)}, {$db->esc($this->data)}, DEFAULT) ON DUPLICATE KEY UPDATE data={$db->esc($this->data)}, date_maj=DEFAULT"; //DEFAULT pour la date automatique;
        return $db->xeq($req);
    }
    public function supprimer()
    {
        $db = DBMySQL::getInstance();
        $req = "DELETE FROM session WHERE sid={$db->esc($this->sid)}";
        return (bool)$db->xeq($req)->nb();
    }
    public static function tab($where = 1, $orderBy = 1, $limit = null)
    {
        $req = "SELECT * FROM sesion WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
        return DBMySQL::getInstance()->xeq($req)->tab(self::class);
    }
    function open($save_path, $session_name) //lié au fichier que l'on utilise pas.
    {
        return true;
    }
    function close()
    {
        return true;
    }
    function read($session_id)
    {
        $this->sid = $session_id; // renseigne le session id dans mon id
        return $this->charger() ? $this->data : ''; // si this charger retourn true alors je retourne data de l'objet sinon on retourne une chaine vide 
    }
    function write($session_id, $session_data)
    {
        $this->sid = $session_id; // renseigne le session id dans mon id
        $this->data = $session_data;
        $this->sauver(); // envoie tout l'objet sur la base de données
        return true;
    }
    function destroy($session_id)
    {
        $this->sid = $session_id; // renseigne le session id dans mon id      
        //supprimer cookie du navigateur,setcookie 
        $session_name = session_name(); //nom de la session actuelle
        setcookie($session_name, '', time() - 3600, '/');
        //supprimer la clé du tableau des cookies dans le serveur Apache.
        unset($_COOKIE[$session_name]); // unset supprime la clé!
        //supprimer la session de la BDD
        $this->supprimer();
        //RAZ $this
        $this->sid = null;
        $this->data = null;
        return true;
    }
    function gc($maxlifetime)
    {
        //Voir php.ini
        //session.gc_probaility
        //session.gc_divisor
        //session.gc_maxlifetime (inutilisé ici);
        if (!$this->timeout) { // si pas de timeout, les sessions sont permanantes donc pas de gc à faire
            return true; //arret de gc
        }

        $req = "DELETE FROM session WHERE TIMESTAMPDIFF(SECOND,date_maj,NOW()) > {$this->timeout}";
        return (bool)DBMySQL::getInstance()->xeq($req)->nb(); // si 0 (return false) de supprimer , si 1(return true) des suppressions ont eu lieux.
    }
}
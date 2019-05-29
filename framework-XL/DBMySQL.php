<?php
class DBMySQL implements DB
{
    // tout est privé pour ne passer que par des instances pour tout vérifier.
    private static $instance; // (instance unique)
    private static $DSN; //(DSN)
    private static $log; //(identifiant utilisateur)
    private static $mdp; //(mot de passe)
    private static $opt = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; //(options de connexion)

    private $db; // (instance de PDO)
    private $jeu; // (recordset après une requête SELECT)
    private $nb; // (nombre de lignes affectées par la dernière requête)

    private function __construct()
    {   //créer la connexion PDO
        if (!self::$DSN) {
            exit("DSN non définit!.");
        }
        try {
            $this->db = new PDO(self::$DSN, self::$log, self::$mdp, self::$opt);
        } catch (PDOException $e) {
            echo "{$e->getMessage()}<br/>";
            exit("Connexion DB impossible.");
        }
    }
    public static function getInstance()
    {   //retourne une instance de DBMySQL
        // Design Pattern Singleton : garanti une unisue instanciation de DBMySQL donc une unisue connexion PDO
        if (!self::$instance) {
            self::$instance = new DBMySQL();
        }
        return self::$instance;
    }
    public static function setDSN($dbName, $log, $mdp, $host = "localhost")
    {   // setDSN doit etre effectuer qu'une seule fois;
        //définir définitivement le DSN
        if (self::$DSN) {
            exit("DSN, impossible à redéfinir!");
        }
        self::$DSN = "mysql:dbname={$dbName};host={$host};charset=utf8mb4";
        self::$log = $log;
        self::$mdp = $mdp;
    }
    public function esc($exp)
    {   //échappe(protéger) $exp pour l'utiliser dans une requête SQL
        //return 'NULL' si $exp == null(pour que la requete sql ne soit jamais' ' ;)   
        return $exp === null  ? 'NULL' : $this->db->quote($exp);
    }
    public function xeq($req)
    {   //éxecuter rêquete $req SQL selon son type exec 
        //si Select retourne le nombre d'enregistrements.
        //si pas SELECT, retourne le nombre de lignes affectées.
        try {
            if (mb_stripos(trim($req), 'select') === 0) { // preg_match ou stripos(retourne la position du mot trouver)
                $this->jeu = $this->db->query($req); // manque gestion erreur
                $this->nb = $this->jeu->rowCount();
            } else {
                $this->jeu = null; //securité
                $this->nb = $this->db->exec($req);
            }
            return $this; // (retourne l'instance de la classe sur laquelle on à appeler la méthode)
            // au final $tab=DBMySQL::getInstance()->xep($req)->tab('Produit');
        } catch (PDOException $e) {
            exit("{$req}<br />{$e->getMessage()}");
        }
    }
    public function nb()
    {
        return $this->nb;
    }
    public function tab($class = 'stdClass')
    {   // à n'utiliser aprés l'execution d'une requête SELECT ne selectionnant, à priori qu'un unique enregistrement
        // return le premier des enregistrements sélectionnés sous la forme d'une instance.
        if (!$this->jeu) {
            return [];
        }
        $this->jeu->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        return $this->jeu->fetchAll();
    }
    public function prem($class = 'stdClass')
    {   //a n'utiliser qu'après l'exec d'une requête SELECT
        //ne sélectionnant à priori qu'un unique enregistrement
        //retourne le premier des enregistrements sélectionnés sous la forme d'une instance de $class
        if (!$this->jeu) {
            return null;
        }
        $this->jeu->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        return $this->jeu->fetch() ?: null;
        //comme ->tab()avantage si ->prem() retourne null en cas d'erreur, ->tab()[0] fait une erreur si pas de valeur.
    }
    public function ins($obj)
    { //Hydrate $objt à partir du premier enregistrement present dans le jeu en cours. (fetch_into)
        if (!$this->jeu) {
            return false;
        }
        $this->jeu->setFetchMode(PDO::FETCH_INTO, $obj);
        return (bool)$this->jeu->fetch(); //retourne true ou false selon la réussite de l'hydratation.
    }
    public function pk()
    {    //return la derniere PK auto-incrémentée.
        return $this->db->lastInsertId(); //revoir le test  
    }
    public function start()
    {   //Debute une transaction.
        return $this->db->beginTransaction();
    }
    public function savepoint($label)
    {   //créer un point de restauration nommé $label.
        $req = "SAVEPOINT {$label}";
        return $this->xep($req);
    }
    public function rollback($label = null)
    {   //Restaurer la DB à son état en debut de transaction ou au point de restauration $label.
        $req = $label ? "ROLLBACK TO {$label}"  : "ROLLBACK";
        return $this->xeq($req);
    }
    public function commit()
    {   //Valider la transaction.
        return $this->db->commit();
    }
}
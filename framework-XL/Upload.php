<?php

class Upload
{

    public $nomChamp; // (Nom du champ INPUT)
    public $tabMIME = []; // (types MIME autorisés, ex : ['image/jpeg'])
    public $nomClient; // (Nom du fichier côté client)
    public $extension; // (Extension du fichier sans le point)
    public $cheminServeur; // (Chemin du fichier temporaire cÃ´tÃ© serveur)
    public $codeErreur; // (Eventuel code d'erreur)
    public $octets; // (Nombre d'octets téchargés)
    public $typeMIME; // (Type MIME du fichier)
    public $tabErreur = []; // (Complété si problème)

    public function __construct($nomChamp, $tabMIME = [])
    {
        $this->nomChamp = $nomChamp;
        $this->tabMIME = $tabMIME;
        if (!isset($_FILES[$this->nomChamp])) {
            $this->tabError[] = "aucun upload";
            return;
        }
        $file = $_FILES[$this->nomChamp]; //recupération du fichier à partir du nomChamp
        //mets les propriétés du fichier reçus dans les propriètes de l'objet Upload
        $this->nomClient = $file['name'];
        $this->extension = (new SplFileInfo($this->nomClient))->getExtension();
        $this->cheminServeur = $file['tmp_name'];
        $this->codeErreur = $file['error'];
        $this->octets = $file['size'];
        $this->typeMIME = $file['type'];

        if ($this->codeErreur === UPLOAD_ERR_INI_SIZE || $this->codeErreur === UPLOAD_ERR_FORM_SIZE) {
            $this->tabErreur[] = "Fichier trop Gros.";
        } elseif ($this->codeErreur === UPLOAD_ERR_NO_FILE) {
            $this->tabErreur[] = "Aucun fichier.";
        } elseif ($this->codeErreur) {
            $this->tabErreur[] = "Upload incorrect.";
        }
        if (!$this->codeErreur && !$this->octets) {
            $this->tabErreur[] = "Fichier vide";
        } elseif (!in_array($this->typeMIME, $this->tabMIME) && $this->tabMIME && !$this->codeErreur) {
            $this->tabErreur[] = "Type MIME incorrect.";
        }
    }
    public function sauver($chemin)
    {
        if (!move_uploaded_file($this->cheminServeur, $chemin)) {
            $this->tabErreur[] = "Enregistrement impossible.";
        }
    }

    public static function maxFileSize($enOctets = true)
    {
        $kmg = ini_get('upload_max_filesize');
        if (!$enOctets) {
            return $kmg;
        }
        $kmg = str_ireplace('G', '*1024**3+', $kmg); // convertit les Go en octets
        $kmg = str_ireplace('M', '*1024**2+', $kmg); // convertit les Mo en octets
        $kmg = str_ireplace('K', '*1024+', $kmg); // convertit les Ko en octets
        $kmg .= '0';
        eval("\$octets = {$kmg};");
        return $octets;
    }
}

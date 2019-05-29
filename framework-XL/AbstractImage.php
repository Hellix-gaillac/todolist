<?php
abstract class AbstractImage
{
    public $tabErreur = []; //renseigné si erreur
    protected $chemin; // chemin du fichier
    protected $largeur; // (largeur en px)
    protected $hauteur; // (hauteur en px)
    const CONTAIN = 'CONTAIN'; // constante pour eviter les fautes de frappe, car ide peux voir faute;
    const COVER = 'COVER';
    public function copier($largeurCadre, $hauteurCadre, $cheminCible, $mode = self::CONTAIN)
    {
        if ($this->largeur <= $largeurCadre && $this->hauteur <= $hauteurCadre) {
            if (!copy($this->chemin, $cheminCible)) {  // si erreur copy retourne une erreur
                $this->tabErreur[] = "Copie image impossible.";
            };
            return; //AVOIR si dans ou hors du if
        }
        $ratioSource = $this->largeur / $this->hauteur;
        $ratioCadre =  $largeurCadre / $hauteurCadre;
        if ($mode === self::CONTAIN) {
            if ($ratioSource > $ratioCadre) {
                $largeurCible = $largeurCadre;
                $hauteurCible = $largeurCible / $ratioSource;
            } elseif ($ratioSource <= $ratioCadre) {
                $hauteurCible = $hauteurCadre;
                $largeurCible = $hauteurCible * $ratioSource;
            }
        } elseif ($mode === self::COVER) {
            if ($ratioSource < $ratioCadre) {
                $largeurCible = $largeurCadre;
                $hauteurCible = $largeurCible / $ratioSource;
            } elseif ($ratioSource >= $ratioCadre) {
                $hauteurCible = $hauteurCadre;
                $largeurCible = $hauteurCible * $ratioSource;
            }
        }
        if (!$ressource = $this->from()) {
            return $this->tabErreur[] = "Lecture image source impossible";
        };
        if (!$cible = imagecreatetruecolor($largeurCible, $hauteurCible)) {
            return $this->tabErreur[] = "Mémoire Insuffisante.";
        };
        if (!imagecopyresampled($cible, $ressource, 0, 0, 0, 0, $largeurCible, $hauteurCible, $this->largeur, $this->hauteur)) {
            return $this->tabErreur[] = "Mémoire Insuffisante.";
        };
        imageDestroy($ressource);
        if (!$this->to($cible, $cheminCible)) {
            return $this->tabErreur[] = "Ecriture image cible impossible.";
        };
        imageDestroy($cible);
    }
    protected abstract function from();
    protected abstract function to($cible, $cheminDestination);
}
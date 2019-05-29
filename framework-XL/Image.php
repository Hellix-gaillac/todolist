<?php
abstract class Image
{
    public $tabErreur = []; //renseigné si erreur
    protected $chemin; // chemin du fichier
    protected $largeur; // (largeur en px)
    protected $hauteur; // (hauteur en px)

    public function copier($largeurCible, $hauteurCible, $cheminCible)
    {
        $xCible = $yCible = $xSource = $ySource = 0;
        // redimenssionnement de la cible
        // 1 imageCreateFromJPEG();
        // 2 imageCreateTrueColor()
        // 3 imageCopyResampled()
        // 3b delete
        //4 imageJPEG
        //4b delete
        $ratioSource = $this->largeur / $this->hauteur; //1200/800=1.5   //600/1400=0.42
        $ratioCible =  $largeurCible / $hauteurCible; //300/300=1       //300/300=1
        if ($ratioSource < $ratioCible) {
            $ratiolargeurCible = $largeurCible; //300
            $ratiohauteurCible = $this->hauteur * $largeurCible / $this->largeur;
        } elseif ($ratioSource > $ratioCible) {
            $ratiolargeurCible = $this->largeur * $hauteurCible / $this->hauteur;
            $ratiohauteurCible = $hauteurCible;
        } elseif ($ratioCible == $ratioSource) {
            $ratiolargeurCible = $largeurCible;
            $ratiohauteurCible = $hauteurCible;
        }
        $newfile = imagecreatefromjpeg($this->chemin);
        $truecolor = imagecreatetruecolor($largeurCible, $hauteurCible);
        imagecopyresampled($truecolor, $newfile, $xCible, $yCible, $xSource, $ySource, $ratiolargeurCible, $ratiohauteurCible, $this->largeurSource, $this->hauteurSource);
        imageDestroy($newfile);
        imagejpeg($truecolor, $cheminCible, 60);
        imageDestroy($truecolor);
    }
    abstract public function imagecreateform()
    { }
    abstract public function image()
    { }
}
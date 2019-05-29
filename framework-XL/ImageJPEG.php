<?php
class ImageJPEG extends AbstractImage
{
    private $qualite;
    public function __construct($chemin, $qualite = 60)
    {
        list($this->largeur, $this->hauteur, $type) = getimagesize($chemin);
        if (!$this->largeur) {
            return $this->tabErreur[] = "Image non disponnible.";
        }
        if ($type !== IMAGETYPE_JPEG) {
            return $this->tabErreur[] = "Image non JPEG.";
        }
        $this->chemin = $chemin;
        $this->qualite = $qualite;
    }
    protected function from()
    {
        return imagecreatefromjpeg($this->chemin);
    }
    protected function to($cible,$cheminDestination)
    {
        return imagejpeg($cible,$cheminDestination,$this->qualite);
    }
}
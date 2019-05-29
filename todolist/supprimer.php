<?php
require_once 'class/Cfg.php';
$id_produit = filter_input(INPUT_GET, 'id_produit', FILTER_VALIDATE_INT);
$id_produit = $id_produit ?: 0;
if ($id_produit) {
    (new Produit($id_produit))->supprimer(); // je crée un produit pour le supprimer
}
$imgSupprimerV = "img/prod_{$id_produit}_v.jpg";
$imgSupprimerP = "img/prod_{$id_produit}_p.jpg";
@unlink($imgSupprimerV);
@unlink($imgSupprimerP);
//@ opperateur de suppression d'erreur
<?php
require_once 'class/Cfg.php';
$tabCategorie = Categorie::tab(1, "nom");
Session::getInstance()->set('toto', 'lulu');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= Cfg::APP_TITRE ?></title>
    <link href="css/commerce.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header></header>
    <div id="container">
        <?php
        foreach ($tabCategorie as $categorie) {
            ?>
        <div class="categorie">
            <img src="img/ico_add.svg" class="ico" onclick="ajouter(<?= $categorie->id_categorie ?>)" />
            <?= $categorie->nom ?>
        </div>
        <?php
            foreach ($categorie->getTabProduit() as $produit) {

                $id = file_exists("img/prod_{$produit->id_produit}_v.jpg") ? $produit->id_produit : 0;
                $maj = !$id ?: (new SplFileInfo("img/prod_{$id}_v.jpg"))->getMTime();
                ?>
        <div class="blocProduit" onclick="detail(<?= $produit->id_produit ?>)">
            <img src="img/prod_<?= $id ?>_v.jpg?maj=<?= $maj ?>" alt="" />
            <div class="nom"><?= $produit->nom ?></div>
            <img class="ico editer" src="img/ico_edit.svg" onclick="modifier(event, <?= $produit->id_produit ?>)" />
            <img class="ico supprimer" src="img/ico_cancel.svg"
                onclick="supprimer(event, <?= $produit->id_produit ?>)" />
        </div>
        <?php
        }
    }
    ?>
    </div>
    <footer></footer>
    <script src="js/index.js" type="text/javascript"></script>
</body>

</html>
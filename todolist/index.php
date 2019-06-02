<?php
require_once 'class/Cfg.php';
$tabUsager = Usager::tab(1, "nom");
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
        foreach ($tabUsager as $usager) {
            ?>
        <div class="categorie">
            <img src="img/ico_add.svg" class="ico" onclick="ajouter(<?= $usager->id_usager ?>)" />
            <?= $usager->nom . " " . $usager->prenom ?>
        </div>
        <?php
            foreach ($usager->getTabListe() as $liste) {

                ?>
        <div class="blocProduit" onclick="detail(<?= $liste->id_liste ?>)">
            <div class="nom"><?= $liste->titre ?></div>
            <img class="ico editer" src="img/ico_edit.svg" onclick="modifier(event, <?= $liste->id_liste ?>)" />
            <img class="ico supprimer" src="img/ico_cancel.svg" onclick="supprimer(event, <?= $liste->id_liste ?>)" />
            <ul>
                <?php
                        foreach ($liste->getTabTodo() as $todo) {
                            ?>
                <li><?= $todo->titre ?></li>
                <?php
                    }
                    ?>
            </ul>

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
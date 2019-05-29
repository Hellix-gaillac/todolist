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

                $id = file_exists("img/prod_{$liste->id_usager}_v.jpg") ? $liste->id_usager : 0;
                $maj = !$id ?: (new SplFileInfo("img/prod_{$id}_v.jpg"))->getMTime();
                ?>
        <div class="blocProduit" onclick="detail(<?= $liste->id_usager ?>)">
            <!--<img src="img/prod_<?= $id ?>_v.jpg?maj=<?= $maj ?>" alt="" /> -->
            <div class="nom"><?= $liste->titre ?></div>
            <img class="ico editer" src="img/ico_edit.svg" onclick="modifier(event, <?= $liste->id_usager ?>)" />
            <img class="ico supprimer" src="img/ico_cancel.svg" onclick="supprimer(event, <?= $liste->id_usager ?>)" />
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
<?php
require_once 'class/Cfg.php';
$opt = ['options' => ['min_range' => 1]];
$id_liste = filter_input(INPUT_GET, 'id_liste', FILTER_VALIDATE_INT, $opt);
if (!$id_liste) {
    header('Location:indispo.php');
    exit;
}
$liste = new Liste($id_liste);
if (!$liste->charger()) {
    header('Location:indispo.php');
    exit;
}

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
        <div class="categorie">
            <a href="index.php"><?= $liste->usager->nom . " " . $liste->usager->prenom ?></a> &gt;
            <?= $liste->titre ?>
        </div>
        <div id="detailProduit">
            <div>
                <ul>
                    <?php
                    foreach ($liste->getTabTodo() as $todo) {
                        ?>
                    <li><?= $todo->titre ?> : <?= $todo->detail ?></li>

                    <?php
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
    <footer></footer>
</body>

</html>
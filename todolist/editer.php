<?php
require_once 'class/Cfg.php';
$db = DBMySQL::getInstance();
$opt = ['options' => ['min_range' => 1]];
$tabErreur = [];
$liste = new Liste();
$todo = new Todo();
if (filter_input(INPUT_POST, 'submit')) {
    $liste->id_liste = filter_input(INPUT_POST, 'id_liste', FILTER_VALIDATE_INT, $opt);
    $liste->titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if (!$liste->id_usager || !$liste->usager)
        $tabErreur[] = "Le nom usager est absente ou invalide.";
    if (!$liste->titre || mb_strlen($liste->titre) > 50) // mb_strlen recupère chaine de caractère
        $tabErreur[] = "Le nom est absent ou invalide.";
} else {
    $liste->id_liste = filter_input(INPUT_GET, 'id_liste', FILTER_VALIDATE_INT, $opt);
    $todo->id_todo = filter_input(INPUT_GET, 'todo', FILTER_VALIDATE_INT, $opt);

    if (!$liste->id_liste) {
        $liste->id_liste = filter_input(INPUT_GET, 'id_liste', FILTER_VALIDATE_INT, $opt);
        if (!$liste->id_liste) {
            header('Location:indispo.php');
            exit;
        }
        if (!$liste->charger()) {
            header('Location:indispo.php');
            exit;
        }
    }
}

$tabTodo = Todo::tab("id_liste={$liste->id_liste}", "titre");

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
        <!-- afficher les éventuelles erreurs. -->
        <div class="categorie">Editer une liste de <?= $liste->usager->nom . " " . $liste->usager->prenom ?></div>
        <div class="erreur"><?= implode('<br/>', $tabErreur) ?></div>
        <form name="form1" action="editer.php" method="post" enctype="multipart/form-data">
            <!--multipart/form-data obligatoire pour envoyer un fichier dans un formulaire-->
            <input type="hidden" name="id_liste" value="<?= $liste->id_liste ?>" />
            <div class="item">
                <label>Titre de la liste</label>
                <input name="titre" value="<?= $liste->titre ?>" maxlength="50" required="required" />
            </div>
            <div class="item">
                <label>titre du todo : </label>
                <select id="name" name="todo">
                    <?php
                    foreach ($tabTodo as $todo) {

                        ?>
                    <option value="<?= $todo->id_todo ?>">
                        <?= $todo->titre ?></option>
                    <?php
                }
                ?>
                </select>
            </div>

            <div class=" item">
                <label>Détail</label>
                <textarea name="detail" value="" cols="30" rows="10"></textarea>
            </div>

            <div class="item">
                <label></label>
                <input type="button" value="Annuler" onclick="annuler()" />
                <input type="submit" name="submit" value="Valider" />
            </div>
        </form>
        <div id="vignette" style="background-image:url('img/prod_35_v.jpg')"></div>

    </div>
    <footer></footer>
    <script>
    const MAX_FILE_SIZE = <?= Upload::maxFileSize() ?>; // appel methode static maxFileSize de la class Upload  
    const TAB_MIME = ['<?= implode("','", Cfg::IMG_TAB_MIME) ?>']; // possible de mettre json_encode(TAB_MIME)
    </script>
    <script src="js/editer.js" type="text/javascript"></script>
    <script>
    document.getElementById('name').onchange = function() {
        window.location = `editer.php?id_liste=<?= $liste->id_liste ?>;todo=${this.value}`;
    };
    </script>

</body>

</html>
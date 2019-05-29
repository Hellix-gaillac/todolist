<?php
require_once 'class/Cfg.php';
$db = DBMySQL::getInstance();
$opt = ['options' => ['min_range' => 1]];
$tabErreur = [];
$produit = new Produit();
if (filter_input(INPUT_POST, 'submit')) {
    $produit->id_produit = filter_input(INPUT_POST, 'id_produit', FILTER_VALIDATE_INT, $opt);
    $produit->id_categorie = filter_input(INPUT_POST, 'id_categorie', FILTER_VALIDATE_INT, $opt);
    $produit->nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $produit->ref = filter_input(INPUT_POST, 'ref', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $produit->prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
    if (!$produit->id_categorie || !$produit->categorie)
        $tabErreur[] = "La catégorie est absente ou invalide.";
    if (!$produit->nom || mb_strlen($produit->nom) > 50) // mb_strlen recupère chaine de caractère
        $tabErreur[] = "Le nom est absent ou invalide.";
    if (!$produit->ref || mb_strlen($produit->ref) > 10 || $produit->refExiste())
        $tabErreur[] = "La référence est absente, invalide ou déjà existante.";
    if (!$produit->prix || $produit->prix < 0 || $produit->prix >= 1000)
        $tabErreur[] = "Le prix est absent ou invalide.";
    if (!$tabErreur) {
        $db->start(); //debut transaction SQL
        $id_produit = $produit->id_produit ?: 'DEFAULT';
        $produit->sauver();
        $upload = new Upload('photo', Cfg::IMG_TAB_MIME);
        //l'upload est facultatif.
        if ($upload->codeErreur === UPLOAD_ERR_NO_FILE) { //si je n'envoie pas d'image, on commit
            $db->commit();
            header('Location:index.php');
            exit;
        }
        //l'upload a bien eu lieu
        $tabErreur = $upload->tabErreur; // ecrase tabErreur par upload->tabErreur
        if (!$tabErreur) { //tabErreur d'upload
            $imageJPEG = new ImageJPEG($upload->cheminServeur);
            $imageJPEG->copier(Cfg::IMG_P_LARGEUR, Cfg::IMG_P_HAUTEUR, "img/prod_{$produit->id_produit}_p.jpg");
            $imageJPEG->copier(Cfg::IMG_V_LARGEUR, Cfg::IMG_V_HAUTEUR, "img/prod_{$produit->id_produit}_v.jpg", AbstractImage::COVER);
            $tabErreur = $imageJPEG->tabErreur;
            if (!$tabErreur) {
                $db->commit();
                header('Location:index.php');
                exit;
            }
        }
        $db->rollback();
    }
} else {
    $produit->id_categorie = filter_input(INPUT_GET, 'id_categorie', FILTER_VALIDATE_INT, $opt);
    if (!$produit->id_categorie) {
        $produit->id_produit = filter_input(INPUT_GET, 'id_produit', FILTER_VALIDATE_INT, $opt);
        if (!$produit->id_produit) {
            header('Location:indispo.php');
            exit;
        }
        if (!$produit->charger()) {
            header('Location:indispo.php');
            exit;
        }
    }
}
$tabCategorie = Categorie::tab(1, "nom");
$id = file_exists("img/prod_{$produit->id_produit}_p.jpg") ? $produit->id_produit : 0;
$maj = !$id ?: (new SplFileInfo("img/prod_{$id}_v.jpg"))->getMTime();
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
        <div class="categorie">Editer un produit</div>
        <div class="erreur"><?= implode('<br/>', $tabErreur) ?></div>
        <form name="form1" action="editer.php" method="post" enctype="multipart/form-data">
            <!--multipart/form-data obligatoire pour envoyer un fichier dans un formulaire-->
            <input type="hidden" name="id_produit" value="<?= $produit->id_produit ?>" />
            <div class="item">
                <label>Catégorie</label>
                <select name="id_categorie">
                    <?php
                    foreach ($tabCategorie as $categorie) {
                        $selected = $categorie->id_categorie == $produit->id_categorie ? 'selected="selected"' : '';
                        ?>
                    <option value="<?= $categorie->id_categorie ?>" <?= $selected ?>><?= $categorie->nom ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="item">
                <label>Nom</label>

                <input name="nom" value="<?= $produit->nom ?>" maxlength="50" required="required" />
            </div>
            <div class="item">
                <label>Référence</label>
                <input name="ref" value="<?= $produit->ref ?>" maxlength="10" required="required" />
            </div>
            <div class="item">
                <label>Prix</label>
                <input type="number" name="prix" value="<?= $produit->prix ?>" min="0" max="999.99" step="0.01"
                    required="required" />
            </div>
            <div class="item">
                <label>Photo (JPEG)</label>
                <input type="file" name="photo" onchange="afficherPhoto(this.files)" />
                <!-- le tableau files contient des instances de file.-->
                <input type="button" value="Parcourir..." onclick="this.form.photo.click()" />

            </div>
            <div class="item">
                <label></label>
                <input type="button" value="Annuler" onclick="annuler()" />
                <input type="submit" name="submit" value="Valider" />
            </div>
        </form>
        <div id="vignette" style="background-image:url('img/prod_<?= $id ?>_v.jpg?maj=<?= $maj ?>')"></div>

    </div>
    <footer></footer>
    <script>
    const MAX_FILE_SIZE = <?= Upload::maxFileSize() ?>; // appel methode static maxFileSize de la class Upload  
    const TAB_MIME = ['<?= implode("','", Cfg::IMG_TAB_MIME) ?>']; // possible de mettre json_encode(TAB_MIME)
    </script>
    <script src="js/editer.js" type="text/javascript"></script>
</body>

</html>
<?php
if (isset($_POST['auteur'], $_POST['bio'], $_POST['photo_path'])) {
    $auteur = strtolower(trim($_POST['auteur']));
    $bio = strtolower(trim($_POST['bio']));
    $bio = preg_replace('/[^a-z0-9_-]/', '_', $bio);
    $ancien_chemin = $_POST['photo_path'];

    $extension = pathinfo($ancien_chemin, PATHINFO_EXTENSION);
    $date = date("YmdHis");

    $nomFinal = "$date-$auteur-$bio.$extension";
    $nouveau_chemin = "uploads/" . $nomFinal;

    if (rename($ancien_chemin, $nouveau_chemin)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Échec de la publication.";
    }
} else {
    echo "Données incomplètes.";
}


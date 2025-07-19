<?php
function recupererPhotos($dossier) {
    $fichiers = [];

    if (is_dir($dossier)) {
        $ouverture = opendir($dossier);

        while (($fichier = readdir($ouverture)) !== false) {
            if ($fichier !== '.' && $fichier !== '..') {
                $fichiers[] = $fichier;
            }
        }

        closedir($ouverture);
    }

    rsort($fichiers); 
    return $fichiers;
}

function tempsEcoule($nomFichier) {
    $dateStr = substr($nomFichier, 0, 14);
    $date = DateTime::createFromFormat("YmdHis", $dateStr);
    if (!$date) return "date inconnue";

    $now = new DateTime();
    $diff = $now->diff($date);

    if ($diff->y > 0) return $diff->y . " an(s)";
    if ($diff->m > 0) return $diff->m . " mois";
    if ($diff->d > 0) return $diff->d . " jour(s)";
    if ($diff->h > 0) return $diff->h . " heure(s)";
    if ($diff->i > 0) return $diff->i . " min";
    return "quelques secondes";
}

$photos = recupererPhotos('uploads');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mini Insta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding-bottom: 120px;
        }
        .tête {
            margin: 20px 0;
            text-align: center;
        }
        h1 {
            color: #e1306c;
            font-family: 'Comic Sans MS';
        }
        h2 {
            margin-bottom: 20px;
        }
        .upd {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px 0;
            display: flex;
            justify-content: center;
            gap: 40px;
            background-color: white;
            border-top: 1px solid #ccc;
        }
        .upd label,
        .upd button {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.8rem;
            color: #444;
            border: none;
            background: none;
            cursor: pointer;
        }
        .upd img {
            cursor: pointer;
        }
        .post {
            margin-bottom: 30px;
            width: 90%;
            max-width: 500px;
            background: #ffffff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }
        .post img {
            width: 100%;
            border-radius: 10px;
        }
        .meta {
            margin-bottom: 10px;
        }
        .meta strong {
            font-size: 1.1em;
        }
        .meta small {
            color: gray;
        }
        .meta em {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>

<div class="tête">
    <img src="insta.png" width="80">
    <h1>Mini Instagram qui me casse la tête</h1>
</div>

<h2>Votre fil :</h2>

<?php
foreach ($photos as $photo):
    //thnaks arthur.php
    if (preg_match('/^(\d{14})-([^-\s]+)-([^.\s]+)\.(jpg|jpeg|png|gif)$/i', $photo, $matches)) {
        $auteur = htmlspecialchars($matches[2]);
        $bio = htmlspecialchars(str_replace('_', ' ', $matches[3]));
        $temps = tempsEcoule($photo);
    } else {
        continue;
    }
?>
    <div class="post">
        <div class="meta">
            <strong>@<?php echo $auteur; ?></strong> • <small><?php echo $temps; ?> ago</small><br>
            <em><?php echo $bio; ?></em>
        </div>
        <img src="uploads/<?php echo $photo; ?>" alt="photo postée">
    </div>
<?php endforeach; ?>

<form action="preview.php" method="POST" enctype="multipart/form-data">
    <div class="upd">
        <label for="photo">
            <img src="add.png" alt="Choisir une photo" width="60">
            <small>Choisir une photo</small>
        </label>
        <input id="photo" type="file" name="photo" accept="image/*" hidden required>

        <button type="submit">
            <img src="up.png" alt="Continuer vers aperçu" width="60">
            <small>Continuer</small>
        </button>
    </div>
</form>

</body>
</html>

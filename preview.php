<?php
if (isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];

    if ($photo['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $photo['tmp_name'];
        $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $previewName = uniqid('preview_', true) . '.' . $extension;
        $previewPath = 'uploads/' . $previewName;

        move_uploaded_file($tmpPath, $previewPath);
    } else {
        die("Erreur lors de l'envoi du fichier.");
    }
} else {
    die("Aucune image reçue.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Aperçu du post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 120px;
        }
        .preview-img {
            max-width: 90%;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }
        .form-zone {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            border-top: 1px solid #ccc;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-zone input {
            margin-bottom: 10px;
            padding: 8px;
            width: 80%;
        }
        .form-zone button {
            padding: 10px 20px;
            background: #e1306c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Aperçu de ta photo</h2>
<img src="<?php echo $previewPath; ?>" class="preview-img">

<form class="form-zone" action="upload.php" method="POST">
    <input type="hidden" name="photo_path" value="<?php echo htmlspecialchars($previewPath); ?>">
    <input type="text" name="auteur" placeholder="Ton pseudo" required>
    <input type="text" name="bio" placeholder="Ta bio (ex : je suis trop belle)" maxlength="30">
    <button type="submit">Publier</button>
</form>

</body>
</html>

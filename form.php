<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
    $maxFileSize = 1000000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Png, Gif ou Webp !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label for="imageUpload">Uploader votre photo</label><br>
        <input type="file" name="avatar" id="imageUpload" /><br>
        <button name="send">Send</button>
    </form>

    <div>
        <img src="" alt="">
    </div>
</body>

</html>
<?php
$errors = [];
$fileName = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = array_map('trim', $_POST);
    $uploadDir = 'uploads/';
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . uniqid("profil_picture") . $extension;
    $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $maxFileSize = 200000;

    if (!isset($data['user_name']) || empty($data['user_name'])) {
        $errors[] = 'Lastname is mandatory';
    }

    if (!isset($data['user_firstname']) || empty($data['user_firstname'])) {
        $errors[] = 'Firstname is mandatory';
    }

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Jpeg, Png ou Webp!';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 2Mo!";
    }

    if (empty($errors)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        $fileName = $uploadFile;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File posted</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="errorPanel">
        <?php
        if (!empty($errors)) { ?>
            <p>Errors found: </p>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php } else { ?>
            <div>
                <ul>
                    <li>LastName : <span><?= htmlentities($data['user_name']) ?></span></li>
                    <li>FirstName: <span><?= htmlentities($data['user_firstname']) ?></span></li>
                </ul>
                <img src="<?php echo $fileName ?>" alt="image">
            </div>
        <?php } ?>
    </div>
</body>

</html>
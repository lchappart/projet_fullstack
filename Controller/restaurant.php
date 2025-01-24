<?php
require 'Model/restaurant.php';


/**
 * @var PDO $pdo
 * @var string $UPLOAD_DIRECTORY
 */
$action = 'create';
$errors = [];
if (!empty($_GET['id'])) {
    $action = 'edit';
    $restaurant = getRestaurant($pdo, $_GET['id']);
    if (!is_array($restaurant)) {
        $errors = $restaurant;
    }
}

if (isset($_POST['create_button'])) {
    $manager = !empty($_POST['manager']) ? cleanString($_POST['manager']) : null;
    $siretSiren = !empty($_POST['siret-siren']) ? cleanString($_POST['siret-siren']) : null;
    $address = !empty($_POST['address']) ? cleanString($_POST['address']) : null;
    $openingHours = !empty($_POST['opening-hours']) ? cleanString($_POST['opening-hours']) : false;
    $finalName = null;
    if (!empty($_FILES["image"]["name"])) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $fileName = $_FILES["image"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqFileName = uniqid();
        $finalName = $uniqFileName . '.' . $ext;
        var_dump($finalName);
        move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . $UPLOAD_DIRECTORY . $finalName);
    }
    $newRestaurant = insertRestaurant($pdo, $manager, $siretSiren, $address, $openingHours,$finalName);
    if (!is_bool($newRestaurant)) {
        $errors[] = $newRestaurant;
    }
}

if (isset($_POST['edit_button'])) {
    $id = cleanString($_GET['id']);
    $manager = !empty($_POST['manager']) ? cleanString($_POST['manager']) : null;
    $siretSiren = !empty($_POST['siret-siren']) ? cleanString($_POST['siret-siren']) : null;
    $address = !empty($_POST['address']) ? cleanString($_POST['address']) : null;
    $openingHours = !empty($_POST['opening-hours']) ? cleanString($_POST['opening-hours']) : false;

    $finalName = null;
    if (!empty($_FILES["image"]["name"])) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $fileName = $_FILES["image"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqFileName = uniqid();
        $finalName = $uniqFileName . '.' . $ext;

        move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . $UPLOAD_DIRECTORY . $finalName);
    }

    if (empty($errors)) {
        $updatedRestaurant = updateRestaurant($pdo, $manager, $siretSiren, $address, $openingHours, $id, $finalName);
        if (!is_bool($updatedRestaurant)) {
            $errors[] = $updatedRestaurant;
        } else {
            $restaurant = getRestaurant($pdo, $id);
        }
    }
}


require 'View/restaurant.php';
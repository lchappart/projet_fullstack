<?php
require 'Model/user.php';


/**
 * @var PDO $pdo
 */
$action = 'create';
$errors = [];
if (!empty($_GET['id'])) {
    $action = 'edit';
    $user = getUser($pdo, $_GET['id']);
    if (!is_array($user)) {
        $errors = $user;
    }
}

if (isset($_POST['create_button'])) {
    $username = !empty($_POST['username']) ? cleanString($_POST['username']) : null;
    $password = !empty($_POST['pass']) ? cleanString($_POST['pass']) : null;
    $confirmation = !empty($_POST['confirmation']) ? cleanString($_POST['confirmation']) : null;
    $enabled = !empty($_POST['enabled']) ? cleanString($_POST['enabled']) : false;
    if ($password !== $confirmation) {
        $errors[] = "Le mot de passe et sa confirmation sont différents";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $newUser = insertUser($pdo, $username, $password, $enabled);
        if (!is_bool($newUser)) {
            $errors[] = $newUser;
        }
    }
}

if (isset($_POST['edit_button'])) {
    $id = cleanString($_GET['id']);
    $username = !empty($_POST['username']) ? cleanString($_POST['username']) : null;
    $password = !empty($_POST['pass']) ? cleanString($_POST['pass']) : null;
    $confirmation = !empty($_POST['confirmation']) ? cleanString($_POST['confirmation']) : null;
    $enabled = !empty($_POST['enabled']) ? cleanString($_POST['enabled']) : false;
    if (!empty($password) && !empty($confirmation) && ($password === $confirmation)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } elseif (!empty($password) && !empty($confirmation) && ($password !== $confirmation)) {
        $errors[] = "Le mot de passe et sa confirmation sont différents";
    }


    if (empty($errors)) {
        $updatedUser = updateUser($pdo, $id, $username, $enabled, $password);
        if (!is_bool($updatedUser)) {
            $errors[] = $updatedUser;
        } else {
            $user = getUser($pdo, $_GET['id']);
        }
    }
}


require 'View/user.php';
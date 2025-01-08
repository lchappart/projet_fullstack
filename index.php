<?php
session_start();
require 'Includes/functions.php';
require 'Includes/database.php';
if (isset($_GET['component'])) {
    $componentName = cleanString($_GET['component']);
    if (file_exists("Controller/$componentName.php")) {
        require "Controller/$componentName.php";
    }
}
?>

<!DOCTYPE>
<html lang="fr">
<head>
    <title>Projet Fullstack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php
        require 'Controller/login.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

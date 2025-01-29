<?php
session_start();
require 'config/config.php';
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'Includes/functions.php';
require 'Includes/database.php';
if (isset($_GET['disconnect'])) {
    session_destroy();
    header('Location: index.php');
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    if (isset($_SESSION['auth'])) {
        if (isset($_GET['component'])) {
            $componentName = cleanString($_GET['component']);
            if (file_exists("Controller/$componentName.php")) {
                require "Controller/$componentName.php";
            }
        }
    } else {
        require "Controller/login.php";
    }
    exit();

}
?>

<!DOCTYPE>
<html lang="fr">
<head>
    <title>Projet Fullstack</title>
    <link rel="stylesheet" href="./Includes/font_awesome/css/fontawesome.css"/>
    <link rel="stylesheet" href="./Includes/font_awesome/css/solid.css"/>
    <link rel="stylesheet" href="./Includes/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="./Includes/leaflet/leaflet.css">
    <link rel="stylesheet" href="./Includes/autoComplete/dist/css/autoComplete.css">
    <link rel="stylesheet" href="./Includes/leafletMarkerCluster/dist/MarkerCluster.css">
    <link rel="stylesheet" href="./Includes/leafletMarkerCluster/dist/MarkerCluster.Default.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['auth'])) {
            require '_partials/navbar.php';
            if (isset($_GET['component'])) {
                $componentName = cleanString($_GET['component']);
                if (file_exists("Controller/$componentName.php")) {
                    require "Controller/$componentName.php";
                }
            }
        } else {
            require 'Controller/login.php';
        }
        require '_partials/errors.php';
        ?>
    </div>
    <script src="./Includes/leaflet/leaflet.js"></script>
    <script src="./Includes/leafletMarkerCluster/dist/leaflet.markercluster.js"></script>
    <script src="./Includes/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./Includes/autoComplete/dist/autoComplete.min.js"></script>
</body>

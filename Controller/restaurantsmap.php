<?php
require "Model/restaurantsmap.php";


/**
 * @var PDO $pdo
 */


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $restaurants = getAllRestaurants($pdo);
    header("Content-Type: application/json");
    echo json_encode($restaurants);
    exit();
}


require "View/restaurantsmap.php";

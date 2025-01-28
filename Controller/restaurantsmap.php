<?php
require "Model/restaurantsmap.php";


/**
 * @var PDO $pdo
 */


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $action = !empty($_GET['action']) ? htmlspecialchars($_GET['action'], ENT_QUOTES) : null;
    if ($action === 'restaurants') {
        [$restaurants, $groups] = getAllRestaurants($pdo);
        header("Content-Type: application/json");
        echo json_encode(['restaurants' => $restaurants, 'groups' => $groups]);
        exit();
    } else if ($action === 'departements') {
        $data =  file_get_contents("Includes/departements-avec-outre-mer.geojson");
        header("Content-Type: application/json");
        echo $data;
        exit();

    }

    exit();
}


require "View/restaurantsmap.php";

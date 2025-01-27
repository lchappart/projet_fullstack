<?php
/**
* @var PDO $pdo
*/

require "Model/restaurants.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $page = isset($_GET['page']) ? (int)cleanString($_GET['page']) : 1;
    if (isset($_GET['action']) && $_GET['action'] === 'count') {
        $count = countRestaurants($pdo);
        header("Content-Type: application/json");
        echo json_encode($count);
        exit();
    }
    if (
        isset($_GET['action']) &&
        isset($_GET['id']) &&
        is_numeric($_GET['id'])
    ) {
        $action = cleanString($_GET['action']);
        $id = cleanString($_GET['id']);
        switch ($action) {
            case 'toggleEnabled':
                toggleEnabled($pdo, $id);
                break;
            case 'delete':
                $deleted = delete($pdo, $id);
                break;
        }
    }

    $sortBy = isset($_GET['sortBy']) ? cleanString($_GET['sortBy']) : 'id';
    [$restaurants, $groups] = getRestaurants($pdo, $page, $sortBy);
    header("Content-Type: application/json");
    echo json_encode(['restaurants' => $restaurants , 'groups' => $groups]);
    exit();
}
require "View/restaurants.php";

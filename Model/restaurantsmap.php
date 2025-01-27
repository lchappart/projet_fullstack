<?php
function getAllRestaurants(
    PDO $pdo,
):array | string
{
    $query = 'SELECT * FROM sales_points';
    $res = $pdo->prepare($query);
    try {
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }

    $sales_points = $res->fetchAll();

    $query = 'SELECT * FROM `groups`';
    $res = $pdo->prepare($query);
    try {
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }

    $groups = $res->fetchAll();

    return [$sales_points, $groups];
}
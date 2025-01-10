<?php
function getAllRestaurants(
    PDO $pdo,
    string | null $sortBy = 'id',
):array | string
{
    $query = 'SELECT * FROM sales_points';
    $res = $pdo->prepare($query);
    try {
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetchAll();
}
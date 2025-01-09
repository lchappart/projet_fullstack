<?php

function getRestaurants(
    PDO $pdo,
    int $page,
    string | null $sortBy = 'id',
):array | string
{
    $offset = ($page - 1) * 15;
    $query = 'SELECT * FROM sales_points ORDER BY :sortBy LIMIT 15 OFFSET :offset';
    $res = $pdo->prepare($query);
    $res->bindParam(':offset', $offset, PDO::PARAM_INT);
    $res->bindParam(':sortBy', $sortBy);
    try {
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetchAll();
}

function delete(PDO $pdo, int $id)
{
    try{
        $res = $pdo->prepare('DELETE FROM `sales_point` WHERE id = :id');
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function countRestaurants(PDO $pdo) {
    $query = 'SELECT COUNT(*) AS totalRestaurants from `sales_points`';
    try {
        $res = $pdo->prepare($query);
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetch();
}

function toggleEnabled(PDO $pdo, int $id): void
{
    $res = $pdo->prepare('UPDATE `sales_points` SET `enabled` = NOT enabled WHERE id = :id');
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    $res->execute();
}
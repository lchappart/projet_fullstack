<?php

function getUsers(
    PDO $pdo,
    int $page,
    string | null $sortBy = 'id',
):array | string
{
    $offset = ($page - 1) * 15;
    $query = 'SELECT * FROM users ORDER BY :sortBy LIMIT 15 OFFSET :offset';
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

function toggleEnabled(PDO $pdo, int $id): void
{
    $res = $pdo->prepare('UPDATE `users` SET `enabled` = NOT enabled WHERE id = :id');
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    $res->execute();
}

function delete(PDO $pdo, int $id)
{
    try{
        $res = $pdo->prepare('DELETE FROM `users` WHERE id = :id');
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function countUsers(PDO $pdo) {
    $query = 'SELECT COUNT(*) AS totalUsers from `users`';
    try {
        $res = $pdo->prepare($query);
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetch();
}
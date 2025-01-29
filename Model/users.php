<?php

function getUsers(
    PDO $pdo,
    int $page,
    string $sortBy,
):array | string
{
    $offset = ($page - 1) * 15;
    $allowedSortColumns = ['id', 'username'];
    if (!in_array($sortBy, $allowedSortColumns)) {
        throw new InvalidArgumentException('Invalid sort column');
    }
    $query = "SELECT * FROM `users` ORDER BY $sortBy LIMIT 15 OFFSET :offset";
    $res = $pdo->prepare($query);
    $res->bindParam(':offset', $offset, PDO::PARAM_INT);
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

function getUsernames(PDO $pdo, string $query): array | string {
    $sql = 'SELECT username FROM `users` WHERE username LIKE :query';
    try {
        $res = $pdo->prepare($sql);
        $res->bindValue(':query', "%$query%");
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetchAll();
}

function getIdByUsername(PDO $pdo, string $username): array | string{
    $query = 'SELECT id FROM `users` WHERE username = :username';
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    try {
        $res->execute();
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return $res->fetch();
}
<?php
function getUser(PDO $pdo, int $id): array | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT *  FROM users WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $res = $prep->fetch();
    $prep->closeCursor();

    return $res;
}

function insertUser(
    PDO $pdo,
    string $username,
    string $pass,
    bool $enabled
): bool | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT id FROM `users` WHERE username=:username";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':username', $username);
    $prep->execute();
    $res = $prep->fetchAll();
    if (count($res) > 0) {
        return 'Le username est déja utilisé';
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO users (username, password, enabled) VALUES (:username, :password, :enabled)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':password', $pass);
    $prep->bindValue(':username', $username);
    $prep->bindValue(':enabled', $enabled, PDO::PARAM_BOOL);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();

    return true;
}

function updateUser(
    PDO $pdo,
    int $id,
    string $username,
    bool $enabled,
    ?string $pass = null,
): bool | string
{

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="UPDATE users SET username = :username, enabled = :enabled WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':username', $username);
    $prep->bindValue(':enabled', $enabled, PDO::PARAM_BOOL);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();

    if (null !== $pass) {
        $query="UPDATE users SET password = :password WHERE id = :id";
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id', $id, PDO::PARAM_INT);
        $prep->bindValue(':password', $pass);
        try
        {
            $prep->execute();
        }
        catch (PDOException $e)
        {
            return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
        }
        $prep->closeCursor();
    }


    return true;
}

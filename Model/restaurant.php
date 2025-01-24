<?php
function getRestaurant(PDO $pdo, int $id): array | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT *  FROM sales_points WHERE id = :id";
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

function insertRestaurant(
    PDO $pdo,
    string $manager,
    string $siretSiren,
    string $address,
    string $openingHours,
    string | null $image = null
): bool | string
{

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO sales_points (manager, siret_siren, address, opening_hours, image) VALUES (:manager, :siret_siren, :address, :opening_hours, :image)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':manager', $manager);
    $prep->bindValue(':siret_siren', $siretSiren);
    $prep->bindValue(':address', $address);
    $prep->bindValue(':opening_hours', $openingHours);
    $prep->bindValue(':image', $image);
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

function updateRestaurant(
    PDO $pdo,
    string $manager,
    string $siretSiren,
    string $address,
    string $openingHours,
    int $id,
    string | null $image = null
): bool | string
{

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="UPDATE sales_points SET manager = :manager, siret_siren = :siret_siren, address = :address, opening_hours = :opening_hours, image = :image WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':manager', $manager);
    $prep->bindValue(':siret_siren', $siretSiren);
    $prep->bindValue(':address', $address);
    $prep->bindValue(':opening_hours', $openingHours);
    $prep->bindValue(':image', $image);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
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

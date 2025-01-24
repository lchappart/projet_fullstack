<?php
/**
 * @var PDO $pdo
 */
require 'index.php';

$faker = Faker\Factory::create('fr_FR');

for ($i = 0; $i < 10; $i++){
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO `groups` (name) VALUES (:name)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':name', $faker->word());
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        echo " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();
}

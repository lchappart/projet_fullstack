<?php
/**
 * @var PDO $pdo
 */

require './index.php';



$faker = Faker\Factory::create('fr_FR');

for ($i = 0; $i <= 105; $i++){
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO users (username, password, enabled) VALUES
(:username, :password, :enabled)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':username', $faker->userName());
    $prep->bindValue(':password', password_hash(0000, PDO::PARAM_STR));
    $prep->bindValue(':enabled', $faker->numberBetween(0,1), PDO::PARAM_INT);
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
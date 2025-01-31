<?php
/**
 * @var PDO $pdo
 */
require 'index.php';
$pdo->exec('TRUNCATE TABLE `users`');
$pdo->exec('TRUNCATE TABLE `groups`');
$pdo->exec('TRUNCATE TABLE `sales_points`');

use GuzzleHttp\Client;

$client = new Client();

$response = $client->request('GET', 'https://api-adresse.data.gouv.fr/search/?q=Jean+Jaures&limit=50',[
'verify' => false
]);
$body = $response->getBody(); $content = $body->getContents();

$data = json_decode($content, true);

$faker = Faker\Factory::create('fr_FR');

for ($i = 0; $i < 50; $i++){
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO `sales_points` (manager, siret_siren, address, opening_hours, group_id) VALUES
(:manager, :siret_siren, :address, :opening_hours, :group_id)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':manager', $faker->name());
    $prep->bindValue(':siret_siren', $faker->numberBetween(11111111111111, 99999999999999));
    $prep->bindValue(':address', $data['features'][$i]['properties']['label']);
    $hours = $faker->numberBetween(8,10) ."h 00 - " . $faker->numberBetween(22,23). " h 00";
    $prep->bindValue(':opening_hours', $hours);
    $group_id = $faker->numberBetween(1,10);
    $prep->bindValue(':group_id', $group_id, PDO::PARAM_INT);
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

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query="INSERT INTO users (username, password, enabled) VALUES
(:username, :password, :enabled)";
$prep = $pdo->prepare($query);
$prep->bindValue(':username', 'admin');
$prep->bindValue(':password', password_hash('admin', PDO::PARAM_STR));
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



for ($i = 0; $i <= 105; $i++){
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO users (username, password, enabled) VALUES
(:username, :password, :enabled)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':username', $faker->userName());
    $prep->bindValue(':password', password_hash('0000', PDO::PARAM_STR));
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


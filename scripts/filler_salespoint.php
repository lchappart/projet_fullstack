<?php
/**
 * @var PDO $pdo
 */
require './Includes/database.php';
require './vendor/autoload.php';

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
    $query="INSERT INTO sales_points (manager, siret_siren, address, opening_hours) VALUES
(:manager, :siret_siren, :address, :opening_hours)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':manager', $faker->name());
    $prep->bindValue(':siret_siren', $faker->numberBetween(11111111111111, 99999999999999));
    $prep->bindValue(':address', $data['features'][$i]['properties']['label']);
    $hours = $faker->numberBetween(8,10) ."h 00 - " . $faker->numberBetween(22,23). " h 00";
    $prep->bindValue(':opening_hours', $hours);
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

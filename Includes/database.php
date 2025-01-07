<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=fullstack_bdd', 'root');
} catch (Exception $e) {
    $errors[] = "Erreur de connexion à la bdd {$e->getMessage()}";
}
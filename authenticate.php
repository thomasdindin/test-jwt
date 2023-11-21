<?php

require_once 'TokenHandler.php'; // Include the TokenHandler class file

$expirationTime = 60;

// Create an instance of TokenHandler with your secret key
$secretKey = 'maclesupersecrete'; // Replace with your actual secret key
$tokenHandler = new TokenHandler($secretKey);

// Data to encode in the JWT
$currentTimestamp = new DateTimeImmutable();
$expirationTime = new DateTimeImmutable('+'. $expirationTime.' minute');

// Valeurs par défaut, possibilité de le modifier suite au login
$userData = [
    'id' => 123,
    'username' => 'thomasdindin',
    'email' => 'thomas.dindin@gmail.com',
    // Issued at & Expires at : généré automatiquement
    'iat' => $currentTimestamp->getTimestamp(),
    'exp' => $expirationTime->getTimestamp() // Convert DateTimeImmutable to a Unix timestamp
];

// Create a JWT
$jwt = $tokenHandler->createToken($userData);
echo $jwt;
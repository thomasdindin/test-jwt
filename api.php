<?php

require 'vendor/autoload.php';
require_once 'TokenHandler.php';

$tokenHandler = new TokenHandler('maclesupersecrete');

// Vérifier la présence d'un token dans l'en-tête Authorization
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Accès non autorisé, jeton manquant']);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Vérifier la validité du token
    $decoded = $tokenHandler->decodeToken($token);

    // Vérifier si l'utilisateur associé au token est valide
    if (!$tokenHandler->isValidUser($decoded->username)) {
        http_response_code(401);
        echo json_encode(['error' => 'Accès non autorisé, utilisateur invalide']);
        exit;
    }

    // Vérifier si le token est expiré
    if ($decoded->exp < time()) {
        http_response_code(401);
        echo json_encode(['error' => 'Accès non autorisé, jeton expiré']);
        exit;
    }

    // Si le token est valide et l'utilisateur est autorisé, renvoyer la date actuelle
    $currentDate = date('Y-m-d H:i:s');
    echo json_encode(['message' => $currentDate]);

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => 'Accès non autorisé, jeton invalide']);
    exit;
}
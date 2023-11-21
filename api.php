<?php

require 'vendor/autoload.php';
require_once 'TokenHandler.php';

$tokenHandler = new TokenHandler('maclesupersecrete');

// Fonction pour envoyer une réponse JSON
function sendJsonResponse($statusCode, $data) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Vérifier la présence d'un token dans l'en-tête Authorization
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    sendJsonResponse(401, ['error' => 'Accès non autorisé, jeton manquant']);
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Vérifier la validité du token
    $decoded = $tokenHandler->decodeToken($token);

    // Vérifier si l'utilisateur associé au token est valide
    if (!$tokenHandler->isValidUser($decoded->username)) {
        sendJsonResponse(401, ['error' => 'Accès non autorisé, utilisateur invalide']);
    }

    // Vérifier si le token est expiré
    if ($decoded->exp < time()) {
        sendJsonResponse(401, ['error' => 'Accès non autorisé, jeton expiré']);
    }

    // Récupérer le paramètre "action" de l'URL
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // Utiliser un switch pour décider comment traiter chaque cas
    switch ($action) {
        case 'getDate':
            // Retourner la date actuelle
            $currentDate = date('Y-m-d H:i:s');
            sendJsonResponse(200, ['message' => $currentDate]);
            break;

        case 'getUserInfo':
            // Retourner les informations de l'utilisateur (vous devez implémenter cette fonction dans votre TokenHandler)
            $userInfo = $tokenHandler->getUserInfo($decoded->username);
            sendJsonResponse(200, ['user_info' => $userInfo]);
            break;

        default:
            sendJsonResponse(400, ['error' => 'Action non prise en charge']);
            break;
    }

} catch (Exception $e) {
    sendJsonResponse(401, ['error' => 'Accès non autorisé, jeton invalide']);
}

<?php 

require_once 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHandler {
    private $secretKey;
    private $algorithm;

    public function __construct($secretKey, $algorithm = 'HS256') {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function createToken($payload) {
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function decodeToken($token) {
        try {
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch (Exception $e) {
            // Handle the exception based on your application requirement
            return null;
        }
    }

    public function isValidUser($user) {
        // Check if the user is valid
        // Return true if the user is valid, false otherwise
        $users = ['thomasdindin', 'johndoe', 'janedoe'];
        return in_array($user, $users);
    }

    public function getUserInfo($user) {
        // Get the user information from the database
        // Return the user information as an array
        return [
            'id' => 123,
            'username' => $user,
            'email' => $user . '@gmail.com'
        ];
    }
}
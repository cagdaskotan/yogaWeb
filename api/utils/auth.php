<?php
require_once("jwt.php");

class Auth {
    public function verifyToken() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        if (!$authHeader) return false;

        $token = str_replace("Bearer ", "", $authHeader);
        $jwt = new Jwt();
        return $jwt->validate($token);
    }
}

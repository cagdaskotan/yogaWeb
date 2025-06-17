<?php

class Jwt {
    private $key = "gizliAnahtar123";

    public function generate($user_id) {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode([
            'user_id' => $user_id,
            'exp' => time() + (60 * 60 * 24)
        ]);

        $base64UrlHeader = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
        $base64UrlPayload = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $this->key, true);
        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
    }

    public function validate($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;

        [$header, $payload, $signature] = $parts;
        $expectedSig = rtrim(strtr(base64_encode(hash_hmac('sha256', "$header.$payload", $this->key, true)), '+/', '-_'), '=');

        if (!hash_equals($expectedSig, $signature)) return false;

        $decoded = json_decode(base64_decode($payload));
        if ($decoded->exp < time()) return false;

        return $decoded;
    }
}

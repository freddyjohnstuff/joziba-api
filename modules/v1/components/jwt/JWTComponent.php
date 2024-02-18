<?php

namespace app\modules\v1\components\jwt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use yii\base\Component;

class JWTComponent extends Component
{


    public string $secret_key = 'joziba-jwt';
    public string $algorithm = 'SHA256';
    public array $header = [
        "alg" => "HS256",
        "typ" => "JWT"
    ];


    /**
     * @param $userData
     * @return string
     */
    public function createJWTToken($userData)
    {
        $payload = array_merge($userData, ['exp' => time() + 60]);
        $headers_encoded = $this->base64url_encode(json_encode($this->header));
        $payload_encoded = $this->base64url_encode(json_encode($payload));
        $signature = hash_hmac($this->algorithm, "$headers_encoded.$payload_encoded", $this->secret_key, true);
        $signature_encoded = $this->base64url_encode($signature);
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $jwt;
    }


    /**
     * @param $jwt
     * @return bool
     */
    public function validateJWT ($jwt) {

        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->access_token_expired;
        $is_token_expired = ($expiration - time()) < 0;

        // build a signature based on the header and payload using the secret
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $this->secret_key, true);
        $base64_url_signature = $this->base64url_encode($signature);

        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);

        if ($is_token_expired || !$is_signature_valid) {
            return FALSE;
        } else {
            return TRUE;
        }

    }

    /**
     * @param $jwt
     * @return false|mixed
     */
    public function decodeJWT($jwt) {

        $tokenParts = explode('.', $jwt);
        $payload = base64_decode($tokenParts[1]);
        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt

        $data = json_decode($payload);
        if(json_last_error() === 0 && $data) {
            return $data;
        }
        return false;
    }

    private function base64url_encode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}
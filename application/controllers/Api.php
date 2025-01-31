<?php

class Api extends Controller {

    private $secretKey = '1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2v3w4x5y6z7'; // Example secret key
    private $clientSecretKey = 'f9a8e17b6c58d3f2e739b5c6e2a4e9b67f1c3d8a76e2b3c49d5e0a3f2b6c9d2e';

    // Generate a base64-encoded HMAC SHA256 signature
    private function generateSignature($header, $payload) {
        $headerPayload = base64_encode($header) . "." . base64_encode($payload);
        return hash_hmac('sha256', $headerPayload, $this->secretKey, true);
    }

    // Validate the JWT token
    private function validateToken($token) {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return false; // Invalid token format
        }

        [$headerB64, $payloadB64, $signatureB64] = $parts;
        $header = base64_decode($headerB64);
        $payload = base64_decode($payloadB64);
        $signature = base64_decode($signatureB64);

        // Verify the signature
        $expectedSignature = $this->generateSignature($header, $payload);

        if (!hash_equals($expectedSignature, $signature)) {
            return false; // Signature mismatch
        }

        // Decode payload and check expiration
        $payloadData = json_decode($payload, true);
        if (isset($payloadData['exp']) && time() > $payloadData['exp']) {
            return false; // Token expired
        }

        return $payloadData; // Return decoded payload if valid
    }

    public function event_details($id) {
        // Check Authorization header
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Missing Authorization header.']);
            exit();
        }

        // Extract Bearer token
        $authHeader = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            $decodedToken = $this->validateToken($token);

            if (!$decodedToken) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid or expired token.']);
                exit();
            }
        } else {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Invalid Authorization header format.']);
            exit();
        }

        // Fetch event details
        $eventModel = $this->model('EventModel');
        $events = $eventModel->getEventByIdForAPI($id);

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($events);
        exit();
    }

    // Generate a new JWT token (for testing purposes or user authentication flows)
    public function generate_token() {

        if (!isset($_GET['secretKey'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Missing secretKey parameter.']);
            exit();
        }else if($_GET['secretKey'] !== $this->clientSecretKey){
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Invalid secretKey.']);
            exit();
        }

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'iss' => 'https://example.com', // Issuer
            'iat' => time(), // Issued at
            'exp' => time() + 3600, // Expiration (1 hour)
            'user_id' => 1 // Example user data
        ]);

        $headerB64 = base64_encode($header);
        $payloadB64 = base64_encode($payload);
        $signature = base64_encode($this->generateSignature($header, $payload));

        $jwt = "$headerB64.$payloadB64.$signature";

        header('Content-Type: application/json');
        echo json_encode(['token' => $jwt]);
        exit();
    }
}

?>

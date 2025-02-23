<?php

class Wakusell_API {
    private $endpoint = "https://wakusell.com/modules/addons/DomainsReseller/api/index.php";
    private $username;
    private $apiKey;

    public function __construct($config) {
        $this->username = $config["settings"]["username"];
        $this->apiKey = $config["settings"]["apiKey"];
    }

    private function generateToken() {
        return base64_encode(hash_hmac("sha256", $this->apiKey, $this->username . ":" . gmdate("y-m-d H")));
    }

    private function callApi($action, $params = []) {
        $url = $this->endpoint . $action;
        $headers = [
            "username: " . $this->username,
            "token: " . $this->generateToken(),
            "Content-Type: application/x-www-form-urlencoded"
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $this->error = curl_error($curl);
            return false;
        }
        curl_close($curl);

        return json_decode($response, true);
    }

    public function getCreditBalance() {
        $response = $this->callApi("/billing/credits");
        return $response["balance"] ?? false;
    }
}
<?php
class GoogleUrlShortener{
    const API_URL = "https://www.googleapis.com/urlshortener/v1/url?key=";
    private $apiKey;

    function __construct($key){
        $this->apiKey = $key;
    }

    private function getApiUrl(){
        return self::API_URL.$this->apiKey;
    }

    public function request($url){
        $result = $this->apiRequestJson(array('longUrl' => $url));
        if(isset($result['id'])){
            return $result['id'];
        }
        else
            return false;
    }

    private function apiRequestJson($parameters) {
        if (!$parameters) {
            $parameters = array();
        } else if (!is_array($parameters)) {
            error_log("Parameters must be an array\n");
            return false;
        }
        
        $handle = curl_init($this->getApiUrl());
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        
        return $this->exec_curl_request($handle);
    }

    private function exec_curl_request($handle) {
        $response = curl_exec($handle);
        if ($response === false) {
            $errno = curl_errno($handle);
            $error = curl_error($handle);
            error_log("Curl returned error $errno: $error\n");
            curl_close($handle);
            return false;
        }
        $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
        curl_close($handle);

        if ($http_code >= 500) {
            // do not wat to DDOS server if something goes wrong
            sleep(10);
            return false;
        } else if ($http_code != 200) {
            $response = json_decode($response, true);
            error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
            if ($http_code == 401) {
                throw new Exception('Invalid access token provided');
            }
            return false;
        } else {
            $response = json_decode($response, true);
            if (isset($response['description'])) {
                error_log("Request was successfull: {$response['description']}\n");
            }
        }
        return $response;
    }
    
}
?>
<?php

class HttpClient {
    private static $url;
    private static $body;

    public static function setUrl($url) {
        self::$url = $url;
    }

    public static function setBody($body) {
        self::$body = $body;
    }

    private static function execute($method) {
        $ch = curl_init();

        switch (strtoupper($method)) {
            case 'GET':
                $url = self::$url;
                if (!empty(self::$body)) {
                    $url .= '?' . http_build_query(self::$body);
                }
                curl_setopt($ch, CURLOPT_URL, $url);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_URL, self::$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(self::$body));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_URL, self::$url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(self::$body));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_URL, self::$url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(self::$body));
                break;
            default:
                throw new Exception('Unsupported HTTP method.');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($response, true);
    }

    public static function get() {
        return self::execute('GET');
    }

    public static function post() {
        return self::execute('POST');
    }

    public static function put() {
        return self::execute('PUT');
    }

    public static function delete() {
        return self::execute('DELETE');
    }
}
?>

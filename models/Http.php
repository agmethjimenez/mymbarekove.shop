<?php
class HttpRequest {
    public static function get($url, $headers = []) {
        return self::request('GET', $url, $headers);
    }

    public static function post($url, $data, $headers = []) {
        return self::request('POST', $url, $headers, $data);
    }

    public static function put($url, $data, $headers = []) {
        return self::request('PUT', $url, $headers, $data);
    }

    public static function delete($url, $headers = []) {
        return self::request('DELETE', $url, $headers);
    }

    private static function request($method, $url, $headers = [], $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response;
    }
}
?>

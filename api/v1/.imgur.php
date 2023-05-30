<?php
    define('IMGUR_ID', '');
    function postImage($img) {
        $url = 'https://api.imgur.com/3/image';
        $data = array(
            'image' => $img
        );
        $header = array(
            'Content-Type: application/json',
            'Authorization: Client-ID ' . IMGUR_ID,
        );
        $options = array(
            'http' => array(
                'header'  => $header,
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => true,
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(@file_get_contents($url, false, $context), true);
        if (!isset($result['success'])) {
            throw new Exception('Internal server error.');
        }
        if (!$result['success']) {
            throw new Exception($result['data']['error']);
        }
        return $result['data']['link'];
    }
?>

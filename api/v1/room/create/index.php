<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(403);
        die('Forbidden');
    }
    define('INPUT', json_decode(file_get_contents('php://input'), true));
    include_once '../../.parse.php';
    [$response, $valid] = parse(
        [
            'token', 
            "/^(?:[a-zA-Z0-9+\/]{4})*(?:|(?:[a-zA-Z0-9+\/]{3}=)|(?:[a-zA-Z0-9+\/]{2}==)|(?:[a-zA-Z0-9+\/]{1}===))$/",
            false
        ],
        [
            'price',
            '/^(?:[0-9]*[.])?[0-9]+$/',
            false
        ],
        [
            'name', 
            "/^\S.{0,510}\S$/",
            false
        ],
        [
            'descr', 
            "/^\S[\s\S]{0,2046}\S$/",
            false
        ],
        [
            'type',
            '/^(?:SOLO|DORTORY)$/',
            false
        ],
        [
            'place',
            '/^[1-9]\d*$/',
            false
        ],
        [
            'hotel',
            '/^[1-9]\d*$/',
            false
        ],
        [
            'dto',
            '/^\d+$/',
            false
        ],
        [
            'img0',
            "/^[0-9A-Za-z\/=+]+$/",
            false
        ],
        [
            'img1',
            "/^[0-9A-Za-z\/=+]+$/",
            true
        ],
        [
            'img2',
            "/^[0-9A-Za-z\/=+]+$/",
            true
        ],
        [
            'img3',
            "/^[0-9A-Za-z\/=+]+$/",
            true
        ],
        [
            'img4',
            "/^[0-9A-Za-z\/=+]+$/",
            true
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    if (time() > $valid['dto']) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value dto.');
        echo json_encode($response);
        die();
    }
    if ($valid['place'] < 1) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value place.');
        echo json_encode($response);
        die();
    }
    $valid['price'] = floatval($valid['price']);
    if ($valid['price'] < 0 || $valid['price'] > 99999999.99 
        || ($valid['price'] - number_format($valid['price'], 2, '.', '')) != 0) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value price.');
        echo json_encode($response);
        die();
    }
    $valid['name'] = strtolower($valid['name']);
    include_once "../../.mysql.php";
    try {
        $connexion = logDB();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.');
        echo json_encode($response);
        die();
    }
    include_once '../../.ratelimite.php';
    if (!ratelimite($connexion, $response, RateType::Post)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('SELECT 1 FROM HOTEL WHERE ID = :id AND 
        MANAGER = (SELECT USER FROM SESSION WHERE TOKEN = :token);');
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    $reqprep->bindParam(':id', $valid['hotel'], PDO::PARAM_INT);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    if ($reqprep->rowCount() == 0) {
        $response['code'] = 'error';
        $response['reason'] = array('Unknown Hotel with this Manager.');
        echo json_encode($response);
        die();
    }
    foreach (['img0', 'img1', 'img2', 'img3', 'img4'] as $key) {
        if (!is_null($valid[$key])) {
            $data = base64_decode($valid[$key]);
            if (strlen($data) > 10000000) {
                $response['code'] = 'error';
                $response['reason'] = array($key . ' is over the size limit.');
                echo json_encode($response);
                die();   
            }
            $f = finfo_open();
            $type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
            if (!str_starts_with($type, 'image')) {
                $response['code'] = 'error';
                $response['reason'] = array($key . ' is not a image.');
                echo json_encode($response);
                die();
            }
        }
    }
    include_once '../../.imgur.php';
    foreach (['img0', 'img1', 'img2', 'img3', 'img4'] as $key) {
        if (!is_null($valid[$key])) {
            try {
                $valid[$key] = postImage($valid[$key]);
            } catch(Exception $e) {
                $response['code'] = 'error';
                $response['reason'] = array($key . ': ' . $e->getMessage());
                echo json_encode($response);
                die();  
            }
        }
    }
    $reqprep = $connexion->prepare('INSERT ROOM (PRICE, NAME, DESCR, IMG0, IMG1,
        IMG2, IMG3, IMG4, TYPE, PLACE, HOTEL, DTO) VALUE (:price, :name, 
        :descr, :img0, :img1, :img2, :img3, :img4, :type, :place, :id, 
        CAST(FROM_UNIXTIME(:dto) AS DATE));');
    $reqprep->bindParam(':price', $valid['price'], PDO::PARAM_STR);
    $reqprep->bindParam(':name', $valid['name'], PDO::PARAM_STR);
    $reqprep->bindParam(':descr', $valid['descr'], PDO::PARAM_STR);
    $reqprep->bindParam(':img0', $valid['img0'], PDO::PARAM_STR);
    $reqprep->bindParam(':img1', $valid['img1'], PDO::PARAM_STR);
    $reqprep->bindParam(':img2', $valid['img2'], PDO::PARAM_STR);
    $reqprep->bindParam(':img3', $valid['img3'], PDO::PARAM_STR);
    $reqprep->bindParam(':img4', $valid['img4'], PDO::PARAM_STR);
    $reqprep->bindParam(':type', $valid['type'], PDO::PARAM_STR);
    $reqprep->bindParam(':place', $valid['place'], PDO::PARAM_INT);
    $reqprep->bindParam(':id', $valid['hotel'], PDO::PARAM_INT);
    $reqprep->bindParam(':dto', $valid['dto'], PDO::PARAM_INT);
    try {
        $reqprep->execute();
    } catch(PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    $response['success'] = array('Room create.');
    echo json_encode($response);
?>
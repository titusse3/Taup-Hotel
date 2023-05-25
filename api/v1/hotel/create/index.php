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
            'name', 
            "/^\S.{0,510}\S$/",
            false
        ],
        [
            'country', 
            "/^\S.{0,510}\S$/",
            false
        ],
        [
            'city', 
            "/^\S.{0,510}\S$/",
            false
        ], 
        [
            'address', 
            "/^\S.{0,510}\S$/",
            false
        ],
        [
            'descr', 
            "/^\S[\s\S]{0,2046}\S$/",
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
    $valid['name'] = strtolower($valid['name']);
    $valid['city'] = strtolower($valid['city']);
    $valid['country'] = strtolower($valid['country']);
    $valid['address'] = strtolower($valid['address']);
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
    $reqprep = $connexion->prepare('SELECT ID FROM USER WHERE ID = 
        (SELECT USER FROM SESSION WHERE TOKEN = :token AND TYPE = "MANAGER");');
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.');
        echo json_encode($response);
        die();
    }
    if ($reqprep->rowCount() == 0) {
        $response['code'] = 'error';
        $response['reason'] = array('Unknown Manager.');
        echo json_encode($response);
        die();
    }
    $id = $reqprep->fetch()['ID'];
    foreach (['img0', 'img1', 'img2', 'img3', 'img4'] as $key) {
        if (!is_null($valid[$key])) {
            $data = base64_decode($valid[$key]);
            if (strlen($data) > 10000000) {
                $response['code'] = 'error';
                $response['reason'] = array($key . ' is too big.');
                echo json_encode($response);
                die();   
            }
            $f = finfo_open();
            $type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
            if (!str_starts_with($type, 'image')) {
                $response['code'] = 'error';
                $response['reason'] = array($key . ' is over the size limit.');
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
    $reqprep = $connexion->prepare('INSERT HOTEL (NAME, COUNTRY, CITY, ADDRESS, 
        DESCR, IMG0, IMG1, IMG2, IMG3, IMG4, MANAGER) VALUE (:name, :country, 
        :city, :address, :descr, :img0, :img1, :img2, :img3, :img4, :id);');
    $reqprep->bindParam(':city', $valid['city'], PDO::PARAM_STR);
    $reqprep->bindParam(':name', $valid['name'], PDO::PARAM_STR);
    $reqprep->bindParam(':country', $valid['country'], PDO::PARAM_STR);
    $reqprep->bindParam(':address', $valid['address'], PDO::PARAM_STR);
    $reqprep->bindParam(':descr', $valid['descr'], PDO::PARAM_STR);
    $reqprep->bindParam(':img0', $valid['img0'], PDO::PARAM_STR);
    $reqprep->bindParam(':img1', $valid['img1'], PDO::PARAM_STR);
    $reqprep->bindParam(':img2', $valid['img2'], PDO::PARAM_STR);
    $reqprep->bindParam(':img3', $valid['img3'], PDO::PARAM_STR);
    $reqprep->bindParam(':img4', $valid['img4'], PDO::PARAM_STR);
    $reqprep->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $reqprep->execute();
    } catch(PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.');
        echo json_encode($response);
        die();
    }
    $response['success'] = array('Hotel create.');
    echo json_encode($response);
?>
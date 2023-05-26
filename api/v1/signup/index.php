<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(403);
        die('Forbidden');
    }
    define('INPUT', json_decode(file_get_contents('php://input'), true));
    include_once '../.parse.php';
    [$response, $valid] = parse(
        [
            'firstname', 
            "/^\S.{0,510}\S$/",
            false
        ], 
        [
            'name', 
            "/^\S.{0,510}\S$/",
            false
        ],
        [
            'phone',
            "/^\+[0-9]{2} [0-9]{9}$/",
            false
        ],
        [
            'email', 
            "/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",
            false
        ], 
        [
            'password', 
            "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/",
            false
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    $valid['password'] = hash('sha512', $valid['password'], false);
    $valid['email'] = strtolower($valid['email']);
    $valid['name'] = strtolower($valid['name']);
    $valid['firstname'] = strtolower($valid['firstname']);
    include_once "../.mysql.php";
    try {
        $connexion = logDB();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.');
        echo json_encode($response);
        die();
    }
    include_once '../.ratelimite.php';
    if (!ratelimite($connexion, $response, RateType::Login)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('INSERT USER (LNAME, FNAME, PHONE, EMAIL, HPWD) 
        VALUES (:lname, :fname, :phone, :email, :hpwd);');
    $reqprep->bindParam(':lname', $valid['name'], PDO::PARAM_STR);
    $reqprep->bindParam(':fname', $valid['firstname'], PDO::PARAM_STR);
    $reqprep->bindParam(':phone', $valid['phone'], PDO::PARAM_STR);
    $reqprep->bindParam(':email', $valid['email'], PDO::PARAM_STR);
    $reqprep->bindParam(':hpwd', $valid['password'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        if ($e->getCode() == 23000) {
            $response['reason'] = array('Email already use.');
        } else {
            $response['reason'] = array('Code ' . $e->getCode()
            . ' : Interval Server Error.');
        }
        echo json_encode($response);
        die();
    }
    $response['success'] = array('User create.');
    $reqprep = $connexion->prepare('INSERT SESSION (USER, TOKEN, NAME) VALUE (
        (SELECT ID FROM USER WHERE EMAIL = :email), :token, :name);');
    $reqprep->bindParam(':email', $valid['email'], PDO::PARAM_STR);
    include_once '../.os.php';
    $name = getOS() . ' - ' . getBrowser();
    $reqprep->bindParam(':name', $name, PDO::PARAM_STR);
    $token = base64_encode(openssl_random_pseudo_bytes(96));
    $reqprep->bindParam(':token', $token, PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch(PDOException $e) {
        $response['code'] = 'unfinished';
        $response['reason'] = array('Code ' . $reqprep->errorCode()
            . ' : Interval Server Error.');
        echo json_encode($response);
        die();
    }
    array_push($response['success'], 'Session create.');
    $response['token'] = $token;
    echo json_encode($response);
    delogDB($connexion);
?>
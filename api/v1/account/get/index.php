<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
<<<<<<< HEAD
    header('Access-Control-Allow-Methods: POST');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
=======
    header('Access-Control-Allow-Methods: GET');
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
>>>>>>> main
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
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
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
    if (!ratelimite($connexion, $response, RateType::Get)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('SELECT ID, FNAME, LNAME, EMAIL, TYPE FROM 
        USER WHERE ID = (SELECT USER FROM SESSION WHERE TOKEN = :token)');
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode()
            . ' : Interval Server Error.');
        echo json_encode($response);
        die();
    }
    $res = $reqprep->fetch(PDO::FETCH_ASSOC);
    if ($res == false) {
        $response['success'] = array('Unknow user.');
        echo json_encode($response);
        die();   
    }
    $response['success'] = array('Result found.');
    $response['data'] = $res;
    echo json_encode($response);
?>
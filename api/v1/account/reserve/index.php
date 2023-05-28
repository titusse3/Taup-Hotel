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
            'next',
            "/^(?:[a-zA-Z0-9+\/]{4})*(?:|(?:[a-zA-Z0-9+\/]{3}=)|(?:[a-zA-Z0-9+\/]{2}==)|(?:[a-zA-Z0-9+\/]{1}===))$/",
            true
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    if (isset($valid['next'])) {
        $next = base64_decode($valid['next']) - 33;
    } else {
        $next = 0;
    }
    if ($next < 0) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value next.');
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
    $reqprep = $connexion->prepare('SELECT Y.ID, Y.NAME, (SELECT NOTE FROM NOTE 
        WHERE R_ID = Y.ID AND U_ID = (SELECT USER FROM SESSION WHERE TOKEN = 
        :token) AND DTO = W.DTO AND DFROM = W.DFROM) AS NOTE ,Y.PRICE, Y.TYPE, 
        X.ID AS HOTEL, X.NAME AS HOTEL_NAME, X.ADDRESS, X.CITY, X.COUNTRY, 
        Y.IMG0, W.DTO, W.DFROM FROM ROOM AS Y, HOTEL AS X, TAKEN AS W WHERE
        W.USER = (SELECT USER FROM SESSION WHERE TOKEN = :token) AND Y.ID = 
        W.ROOM AND X.ID = Y.HOTEL LIMIT 30 OFFSET :off;');
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    $reqprep->bindParam(':off', $next, PDO::PARAM_INT);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode()
            . ' : Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    $res = $reqprep->fetchAll(PDO::FETCH_ASSOC);
    if ($res == false) {
        $response['success'] = array('Unknow reservation of this user.');
        echo json_encode($response);
        die();   
    }
    if ($reqprep->rowCount() == 30) {
        $response['next'] = base64_encode($next + 63);
    }
    $response['success'] = array('Result found.');
    $response['data'] = $res;
    echo json_encode($response);
?>
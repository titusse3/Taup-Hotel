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
            'id',
            '/^[1-9]\d*$/',
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
    $reqprep = $connexion->prepare('SELECT Y.ID, Y.NAME, (SELECT 
        COALESCE(AVG(NOTE), 2.50) FROM NOTE WHERE R_ID = Y.ID) AS NOTE ,Y.PRICE,
        Y.PLACE, Y.DESCR, Y.TYPE, Y.DTO, X.ID AS HOTEL, X.NAME AS HOTEL_NAME, 
        X.ADDRESS, X.CITY, X.COUNTRY, Y.IMG0, Y.IMG1, Y.IMG2, Y.IMG3, Y.IMG4 
        FROM ROOM AS Y, HOTEL AS X WHERE Y.ID = :id AND X.ID = Y.HOTEL;');
    $reqprep->bindParam(':id', $valid['id'], PDO::PARAM_INT);
    try {
        $reqprep->execute($valid);
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    $res = $reqprep->fetch(PDO::FETCH_ASSOC);
    if ($res == false) {
        $response['success'] = array('No result.');
        echo json_encode($response);
        die();   
    }
    $response['success'] = array('Result found.');
    $response['data'] = $res;
    echo json_encode($response);
?>
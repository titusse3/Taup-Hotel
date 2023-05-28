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
            'room',
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
    $reqprep = $connexion->prepare('DELETE FROM ROOM AS X WHERE X.ID = :id AND 
        ((SELECT MANAGER FROM HOTEL WHERE ID = X.HOTEL) = (SELECT USER FROM 
        SESSION WHERE TOKEN = :token) OR (SELECT TYPE FROM USER WHERE ID = 
        (SELECT USER FROM SESSION WHERE TOKEN = :token)) = "ADMIN");');
    $reqprep->bindParam(':id', $valid['room'], PDO::PARAM_INT);
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    if (!$reqprep->rowCount()) {
        $response['code'] = 'error';
        $response['reason'] = array('You cannot delete this room.');
        echo json_encode($response);
        die();
    };
    $reqprep = $connexion->prepare('DELETE FROM NOTE WHERE R_ID = :id; 
        DELETE FROM TAKEN WHERE ROOM = :id;');
    $reqprep->bindParam(':id', $valid['room'], PDO::PARAM_INT);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    $response['success'] = array('Room delete.');
    echo json_encode($response);
?>
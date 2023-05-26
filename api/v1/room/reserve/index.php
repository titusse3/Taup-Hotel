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
            'dfrom',
            '/^\d+$/',
            false
        ],
        [
            'dto',
            '/^\d+$/',
            false
        ],
        [
            'place',
            '/^[1-9]\d*$/',
            true
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
    if ($valid['dfrom'] > $valid['dto'] || $valid['dfrom'] < time()) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value dto / dfrom.');
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
    if (!ratelimite($connexion, $response, RateType::Post)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('SELECT IF (TYPE = "DORMITORY", 
        (SELECT (PLACE - MAX_RESERVE_D2D(CAST(FROM_UNIXTIME(:dfrom) AS DATE), 
        CAST(FROM_UNIXTIME(:dto) AS DATE), ID)) >= :place), 
        (MAX_RESERVE_D2D(CAST(FROM_UNIXTIME(:dfrom) AS DATE), 
        CAST(FROM_UNIXTIME(:dto) AS DATE), ID) = 0 AND PLACE >= :place)) AS RES 
        FROM ROOM WHERE CAST(FROM_UNIXTIME(:dto) AS DATE) <= DTO AND ID = :id');
    $reqprep->bindParam(':id', $valid['room'], PDO::PARAM_INT);
    $reqprep->bindParam(':place', $valid['place'], PDO::PARAM_INT);
    $reqprep->bindParam(':dto', $valid['dto'], PDO::PARAM_STR);
    $reqprep->bindParam(':dfrom', $valid['dfrom'], PDO::PARAM_STR);
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
        $response['reason'] = array('Unknown room avaible to this time.');
        echo json_encode($response);
        die();
    }
    if (!$reqprep->fetch()['RES']) {
        $response['code'] = 'error';
        $response['reason'] = array('Not enough place.');
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('INSERT TAKEN (DFROM, DTO, ROOM, USER, PLACE)
        VALUE (CAST(FROM_UNIXTIME(:dfrom) AS DATE), 
        CAST(FROM_UNIXTIME(:dto) AS DATE), :id, (SELECT USER FROM SESSION WHERE 
        TOKEN = :token), :place);');
    $reqprep->bindParam(':id', $valid['room'], PDO::PARAM_INT);
    $reqprep->bindParam(':place', $valid['place'], PDO::PARAM_INT);
    $reqprep->bindParam(':dto', $valid['dto'], PDO::PARAM_STR);
    $reqprep->bindParam(':dfrom', $valid['dfrom'], PDO::PARAM_STR);
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        if ($e->getCode() == 23000) {
            $response['reason'] = array('Unknow user.'); 
        } else {
            $response['reason'] = array('Code ' . $e->getCode()
                . ' : Interval Server Error.');
        }
        echo json_encode($response);
        die();
    }
    $response['success'] = array('Room reserved.');
    echo json_encode($response);
?>
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
    $reqprep = $connexion->prepare('SELECT X.ID, X.NAME, X.ADDRESS, X.CITY, 
        X.COUNTRY, X.DESCR, X.IMG0, X.IMG1, X.IMG2, X.IMG3, X.IMG4, X.MANAGER,
        (SELECT CONCAT(FNAME, \' \', LNAME) FROM USER WHERE USER.ID = X.ID) AS 
        MANAGER_NAME, (SELECT IFNULL(AVG(NOTE), 2.50) FROM NOTE WHERE R_ID IN 
        (SELECT ID FROM ROOM WHERE HOTEL = X.ID)) AS AVG_NOTE FROM HOTEL AS X 
        WHERE ID = :id;');
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
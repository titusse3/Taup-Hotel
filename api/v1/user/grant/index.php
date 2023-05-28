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
            'id',
            '/^[1-9]\d*$/',
            false
        ],
        [
            'type',
            '/^(?:ADMIN|CLIENT|MANAGER)$/',
            false
        ],
        [
            'perm',
            '/^\d*$/',
            false
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    if ($valid['perm'] > 256) {
        $response['code'] = 'error';
        $response['reason'] = array('Invalid value of perm.');
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
    $reqprep = $connexion->prepare('UPDATE USER SET PERM = :perm , TYPE = :type 
        WHERE ID = :id 
        AND (SELECT TYPE FROM (SELECT TYPE FROM USER WHERE ID = (SELECT USER FROM SESSION WHERE TOKEN = :token)) AS W) = "ADMIN" 
        AND PERM < (SELECT PERM FROM (SELECT PERM FROM USER WHERE ID = (SELECT USER FROM SESSION WHERE TOKEN = :token)) AS Y) 
        AND :perm < (SELECT PERM FROM (SELECT PERM FROM USER WHERE ID = (SELECT USER FROM SESSION WHERE TOKEN = :token)) AS Q);');
    $reqprep->bindParam(':id', $valid['id'], PDO::PARAM_INT);
    $reqprep->bindParam(':perm', $valid['perm'], PDO::PARAM_INT);
    $reqprep->bindParam(':type', $valid['type'], PDO::PARAM_STR);
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
        $response['reason'] = array('You cannot grant this user.');
        echo json_encode($response);
        die();
    };
    $response['success'] = array('User grant.');
    echo json_encode($response);
?>
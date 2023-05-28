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
            'token', 
            "/^(?:[a-zA-Z0-9+\/]{4})*(?:|(?:[a-zA-Z0-9+\/]{3}=)|(?:[a-zA-Z0-9+\/]{2}==)|(?:[a-zA-Z0-9+\/]{1}===))$/",
            false
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
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
    if (!ratelimite($connexion, $response, RateType::Post)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('UPDATE USER SET PERM = 256, TYPE = "ADMIN" 
        WHERE (SELECT COUNT(ID) FROM (SELECT ID FROM USER WHERE TYPE = "ADMIN") 
        AS W) = 0 AND ID = (SELECT ID FROM (SELECT USER FROM SESSION WHERE TOKEN
        = :token) AS X);');
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode()
            . ' : Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    if (!$reqprep->rowCount()) {
        $response['code'] = 'error';
        $response['reason'] = array('The power of the mallet don\'t work :(');
        echo json_encode($response);
        die();
    };

    $response['success'] = array('Mallet power!!!');
    echo json_encode($response);
?>
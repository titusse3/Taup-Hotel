<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(403);
        die('Forbidden');
    }
    define('INPUT', json_decode(file_get_contents('php://input'), true));
    include_once '../../../.parse.php';
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
            'note',
            '/^\d*$/',
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
    if ($valid['dfrom'] > $valid['dto']) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value dto / dfrom.');
        echo json_encode($response);
        die();
    }
    if ($valid['note'] > 5) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value note.');
        echo json_encode($response);
        die(); 
    }
    include_once "../../../.mysql.php";
    try {
        $connexion = logDB();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.');
        echo json_encode($response);
        die();
    }
    include_once '../../../.ratelimite.php';
    if (!ratelimite($connexion, $response, RateType::Post)) {
        echo json_encode($response);
        die();
    }
    $reqprep = $connexion->prepare('INSERT NOTE (NOTE, R_ID, U_ID, DFROM, DTO) 
        VALUES (:note, :rid, (SELECT USER FROM SESSION WHERE TOKEN = :token), 
        CAST(FROM_UNIXTIME(:dfrom) AS DATE), CAST(FROM_UNIXTIME(:dto) AS DATE))
        ON DUPLICATE KEY UPDATE NOTE = :note;');
    $reqprep->bindParam(':dto', $valid['dto'], PDO::PARAM_STR);
    $reqprep->bindParam(':dfrom', $valid['dfrom'], PDO::PARAM_STR);
    $reqprep->bindParam(':rid', $valid['room'], PDO::PARAM_STR);
    $reqprep->bindParam(':note', $valid['note'], PDO::PARAM_STR);
    $reqprep->bindParam(':token', $valid['token'], PDO::PARAM_STR);
    try {
        $reqprep->execute();
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Unknow reservation.');
        echo json_encode($response);
        die();
    }
    $response['success'] = array('Vote send.');
    echo json_encode($response);
?>
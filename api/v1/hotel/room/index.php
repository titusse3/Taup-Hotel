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
            'hotel',
            '/^[1-9]\d*$/',
            false,
        ],
        [
            'type_room',
            '/^(?:SOLO|DORTORY)$/',
            true
        ],
        [
            'min_note',
            '/^\d+$/',
            true
        ],
        [
            'order',
            '/^(?:ASC|DESC)$/',
            true,
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
    unset($valid['next']);
    $room = array();
    foreach($valid as $key => $val) {
        if ($val == null) {
            unset($valid[$key]);
            continue;
        }
        switch($key) {
            case 'type_room':
                array_push($room, 'TYPE = :type_room');
                break;
            case 'min_note':
                array_push($room, '(SELECT IFNULL(AVG(NOTE), 2.50) FROM NOTE 
                    WHERE R_ID = ROOM.ID) >= :min_note');
                break;
            default:
                break;
        }
    }
    $req = 'SELECT ROOM.ID, ROOM.NAME, PRICE, ROOM.IMG0, (SELECT 
        COALESCE(AVG(NOTE), 2.50) FROM NOTE WHERE R_ID = ROOM.ID) AS NOTE, 
        TYPE, ADDRESS, CITY, COUNTRY FROM ROOM, HOTEL WHERE HOTEL.ID = 
        ROOM.HOTEL AND ROOM.HOTEL = :hotel';
    if (count($room) > 0) {
        $req .= ' AND ';
        $req .= implode(' AND ', $room);
    }
    if (isset($valid['order'])) {
        if ($valid['order'] == 'DESC') {
            $req .= ' ORDER BY PRICE DESC';
        } else if ($valid['order'] == 'ASC') {
            $req .= ' ORDER BY PRICE ASC';
        }
        unset($valid['order']);
    }
    $req .= ' LIMIT 30 OFFSET ' . $next . ';';
    $reqprep = $connexion->prepare($req);
    try {
        $reqprep->execute($valid);
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode() 
            . ': Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    if ($reqprep->rowCount() == 0) {
        $response['success'] = array('No result.');
        echo json_encode($response);
        die();   
    }
    $response['success'] = array('Result found.');
    if ($reqprep->rowCount() == 30) {
        $response['next'] = base64_encode($next + 63);
    }
    $response['data_count'] = $reqprep->rowCount();
    $response['data'] = $reqprep->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($response);
    die();   
?>
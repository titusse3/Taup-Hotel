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
            'name', 
            "/^\S.{0,510}\S$/",
            true
        ],
        [
            'country', 
            "/^\S.{0,510}\S$/",
            true
        ],
        [
            'city', 
            "/^\S.{0,510}\S$/",
            true
        ], 
        [
            'address', 
            "/^\S.{0,510}\S$/",
            true
        ],
        [
            'type_room',
            '/^(?:SOLO|DORTORY)$/',
            true
        ],
        [
            'place',
            '/^[1-9]\d*$/',
            false
        ],
        [
            'max_price',
            '/^(?:[0-9]*[.])?[0-9]+$/',
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
            'type',
            '/^(?:HOTEL|ROOM)$/',
            true
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
            'next',
            "/^(?:[a-zA-Z0-9+\/]{4})*(?:|(?:[a-zA-Z0-9+\/]{3}=)|(?:[a-zA-Z0-9+\/]{2}==)|(?:[a-zA-Z0-9+\/]{1}===))$/",
            true
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    $valid['name'] = strtolower($valid['name']);
    $valid['city'] = strtolower($valid['city']);
    $valid['country'] = strtolower($valid['country']);
    $valid['address'] = strtolower($valid['address']);
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
    if ($valid['dfrom'] > $valid['dto'] || $valid['dfrom'] < time()) {
        $response['code'] = 'error';
        $response['reason'] = array('Illegal value dto / dfrom.');
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
    if (!ratelimite($connexion, $response, RateType::Get)) {
        echo json_encode($response);
        die();
    }
    unset($valid['next']);
    $room = array();
    $hotel = array();
    foreach($valid as $key => $val) {
        if ($val == null) {
            unset($valid[$key]);
            continue;
        }
        switch($key) {
            case 'name':
                array_push($hotel, 'HOTEL.NAME LIKE 
                    CONCAT(\'%\', :name, \'%\')');
                array_push($room, 'ROOM.NAME LIKE CONCAT(\'%\', :name, \'%\')');
                break;
            case 'country':
                array_push($hotel, 'HOTEL.COUNTRY LIKE 
                    CONCAT(\'%\', :country, \'%\')');
                array_push($room, 'HOTEL.COUNTRY LIKE 
                    CONCAT(\'%\', :country, \'%\')');
                break;
            case 'city':
                array_push($hotel, 'HOTEL.CITY LIKE 
                    CONCAT(\'%\', :city, \'%\')');
                array_push($room, 'HOTEL.CITY LIKE 
                    CONCAT(\'%\', :city, \'%\')');
                break;
            case 'address':
                array_push($hotel, 'HOTEL.ADDRESS LIKE 
                    CONCAT(\'%\', :address, \'%\')');
                array_push($room, 'HOTEL.ADDRESS LIKE 
                    CONCAT(\'%\', :address, \'%\')');
                break;
            case 'type_room':
                array_push($room, 'TYPE = :type_room');
                break;
            case 'max_price':
                array_push($hotel, '(SELECT IFNULL(AVG(PRICE), 0) FROM ROOM 
                    WHERE HOTEL = HOTEL.ID) <= :max_price');
                array_push($room, 'PRICE <= :max_price');
                break;
            case 'min_note':
                array_push($hotel, '(SELECT IFNULL(AVG(NOTE), 2.50) FROM NOTE 
                    WHERE R_ID IN (SELECT ID FROM ROOM WHERE HOTEL = HOTEL.ID))
                    >= :min_note');
                array_push($room, '(SELECT IFNULL(AVG(NOTE), 2.50) FROM NOTE 
                    WHERE R_ID = ROOM.ID) >= :min_note');
                break;
            default:
                break;
        }
    }
    array_push($room, 'IF (ROOM.TYPE = "DORMITORY", (SELECT (ROOM.PLACE - 
        MAX_RESERVE_D2D(CAST(FROM_UNIXTIME(:dfrom) AS DATE), 
        CAST(FROM_UNIXTIME(:dto) AS DATE), ROOM.ID)) >= :place), 
        (MAX_RESERVE_D2D(CAST(FROM_UNIXTIME(:dfrom) AS DATE), 
        CAST(FROM_UNIXTIME(:dto) AS DATE), ROOM.ID) = 0 AND PLACE >= :place))');
    if (!isset($valid['type']) || $valid['type'] == null) {
        $reqr = 'SELECT ROOM.ID, ROOM.NAME, PRICE, ROOM.IMG0, (SELECT IFNULL(AVG(NOTE), 
        2.50) FROM NOTE WHERE R_ID = ROOM.ID) AS NOTE, TYPE, ADDRESS, CITY, 
        COUNTRY FROM ROOM, HOTEL WHERE HOTEL.ID = ROOM.HOTEL';
        if (count($room) > 0) {
            $reqr .= ' AND ';
            $reqr .= implode(' AND ', $room);
        }
        $reqh = 'SELECT ID, NAME, (SELECT IFNULL(AVG(PRICE), 0) FROM ROOM WHERE 
            HOTEL = HOTEL.ID) AS PRICE, IMG0, (SELECT IFNULL(AVG(NOTE), 2.50) FROM 
            NOTE WHERE R_ID IN (SELECT ID FROM ROOM WHERE HOTEL = HOTEL.ID)) 
            AS NOTE, "HOTEL", ADDRESS, CITY, COUNTRY FROM HOTEL';
        if (count($hotel) > 0) {
            $reqh .= ' WHERE ';
            $reqh .= implode(' AND ', $hotel);
        }
        $req = "($reqr) UNION ($reqh)";
    } else if ($valid['type'] == 'ROOM') {
        $req = 'SELECT ROOM.ID, ROOM.NAME, PRICE, ROOM.IMG0, (SELECT IFNULL(AVG(NOTE), 
        2.50) FROM NOTE WHERE R_ID = ROOM.ID) AS NOTE, TYPE, ADDRESS, CITY, 
        COUNTRY FROM ROOM, HOTEL WHERE HOTEL.ID = ROOM.HOTEL';
        if (count($room) > 0) {
            $req .= ' AND ';
            $req .= implode(' AND ', $room);
        }
    } else {
        $req = 'SELECT ID, NAME, (SELECT IFNULL(AVG(PRICE), 0) FROM ROOM WHERE 
            HOTEL = HOTEL.ID) AS PRICE, IMG0, (SELECT IFNULL(AVG(NOTE), 2.50) FROM 
            NOTE WHERE R_ID IN (SELECT ID FROM ROOM WHERE HOTEL = HOTEL.ID)) 
            AS NOTE, "HOTEL", ADDRESS, CITY, COUNTRY FROM HOTEL';
        if (count($hotel) > 0) {
            $req .= ' WHERE ';
            $req .= implode(' AND ', $hotel);
        }
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
    unset($valid['type']);
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
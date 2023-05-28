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
            'firstname', 
            "/^\S.{0,510}\S$/",
            true
        ], 
        [
            'name', 
            "/^\S.{0,510}\S$/",
            true
        ],
        [
            'phone',
            "/^\+[0-9]{2} [0-9]{9}$/",
            true
        ],
        [
            'email', 
            "/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",
            true
        ], 
        [
            'newpassword', 
            "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/",
            true
        ], 
        [
            'password', 
            "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/",
            false
        ]
    );
    if ($response['code'] == 'error') {
        echo json_encode($response);
        die(); 
    }
    if (count($valid) == 2) {
        $response['code'] = 'error';
        $response['reason'] = array('No change.');
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
    if (!ratelimite($connexion, $response, RateType::Modify)) {
        echo json_encode($response);
        die();
    }
    $req = 'UPDATE USER SET ';
    $change = array();
    foreach($valid as $key => $val) {
        if ($val == null) {
            unset($valid[$key]);
            continue;
        }
        switch($key) {
            case 'firstname':
                $valid['firstname'] = strtolower($valid['firstname']);
                array_push($change, 'FNAME = :firstname');
                break;
            case 'name':
                $valid['name'] = strtolower($valid['name']);
                array_push($change, 'LNAME = :name');
                break; 
            case 'phone':
                array_push($change, 'PHONE = :phone');
                break; 
            case 'email':
                $valid['email'] = strtolower($valid['email']);
                array_push($change, 'EMAIL = :email');
                break; 
            case 'newpassword':
                $valid['newpassword'] = hash('sha512', $valid['newpassword'], false);
                array_push($change, 'HPWD = :newpassword');
                break; 
            default:
                break;
        }
    }
    $req .= implode(' , ', $change) . ' WHERE HPWD = :password AND ID = 
        (SELECT USER FROM SESSION WHERE TOKEN = :token);';
    $valid['password'] = hash('sha512', $valid['password'], false);
    $reqprep = $connexion->prepare($req);
    try {
        $reqprep->execute($valid);
    } catch (PDOException $e) {
        $response['code'] = 'error';
        $response['reason'] = array('Code ' . $e->getCode()
            . ' : Interval Server Error.', $e->getMessage());
        echo json_encode($response);
        die();
    }
    if (!$reqprep->rowCount()) {
        $response['code'] = 'error';
        $response['reason'] = array('Wrong informations.');
        echo json_encode($response);
        die();
    };
    $response['success'] = array('Account info change.');
    echo json_encode($response);
?>
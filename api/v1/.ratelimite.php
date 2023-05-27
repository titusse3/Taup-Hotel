<?php
    enum RateType {
        case Post;
        case Get;
        case Login;
        case Modify;
    }
    function link_ratetype(RateType $t) {
        switch ($t) {
            case RateType::Post:
                return ['DP', 'CP'];
            case RateType::Get:
                return ['DG', 'CG'];
            case RateType::Login:
                return ['DL', 'CL'];
            case RateType::Modify:
                return ['DM', 'CM'];
        }
    }
    function max_ratetype(RateType $t) {
        switch ($t) {
            case RateType::Post:
                return 20;
            case RateType::Get:
                return 40;
            case RateType::Login:
                return 10;
            case RateType::Modify:
                return 5;
        }
    }
    /**
     * Fonction qui test si l'user est ratelimite
     * 
     * @param PDO $connexion Connexion au serveur sql
     * 
     * @param array $response Array de réponse
     * 
     * @param RateType $t Type de ratelimite
     * 
     * @return boolean
     */
    function ratelimite(PDO &$connexion, array &$response, RateType $t) {
        //print_r($response);
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $type = link_ratetype($t);
        $reqprep = $connexion->prepare('SELECT ' . implode(', ', $type) 
            . ' FROM RATEL WHERE IP = :ip;');
        $reqprep->bindParam(':ip', $ip, PDO::PARAM_STR);
        try {
            $reqprep->execute();
        } catch (PDOException $e) {
            $response['code'] = 'error';
            $response['reason'] = array('Code ' . $e->getCode()
                . ' : Interval Server Error.');
            return false;
        }
        if (!($res = $reqprep->fetch(PDO::FETCH_ASSOC))) {
            $reqprep = $connexion->prepare('INSERT RATEL (IP, ' . $type[1] . ') 
                VALUES (:ip, 1)');
            $reqprep->bindParam(':ip', $ip, PDO::PARAM_STR);
            try {
                $reqprep->execute();
            } catch(PDOException $e) {
                $response['code'] = 'error';
                $response['reason'] = array('Code ' . $reqprep->errorCode()
                    . ' : Interval Server Error.');
                return false;
            }
            return true;
        }
        $now = new DateTime();
        $sd = DateTime::createFromFormat('Y-m-d H:i:s', $res[$type[0]]);
        $diff = $sd->diff($now);
        $dd = new DateTime();
        $dd->setTimestamp(0);
        $dd->add($diff);
        if ($dd->format('U') > 300) {
            $reqprep = $connexion->prepare('UPDATE RATEL SET ' . $type[1] 
                . ' = 1, ' . $type[0] . ' = NOW() WHERE IP = :ip;');
            $reqprep->bindParam(':ip', $ip, PDO::PARAM_STR);
            try {
                $reqprep->execute();
            } catch(PDOException $e) {
                $response['code'] = 'error';
                $response['reason'] = array('Code ' . $reqprep->errorCode()
                    . ' : Interval Server Error.');
                return false;
            }
            return true;
        }
        if ($res[$type[1]] > max_ratetype($t)) {
            $response['code'] = 'ratelimited';
            $response['reason'] = array('Please retry leater.');
            return false;
        }
        $reqprep = $connexion->prepare('UPDATE RATEL SET ' . $type[1] 
            . ' = ' . $type[1] . ' + 1 WHERE IP = :ip;');
        $reqprep->bindParam(':ip', $ip, PDO::PARAM_STR);
        try {
            $reqprep->execute();
        } catch(PDOException $e) {
            $response['code'] = 'error';
            $response['reason'] = array('Code ' . $reqprep->errorCode()
                . ' : Interval Server Error.');
            return false;
        }
        return true;
    }
?>
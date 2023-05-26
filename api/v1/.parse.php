<?php
    function parse() {
        $error = array();
        $response = array();
        $args = func_get_args();
        $valid = array();
        foreach($args as $val) {
            if (!isset(INPUT[$val[0]])) {
                if ($val[2]) {
                    $valid[$val[0]] = null;
                    continue;
                }
                array_push($error, $val[0] . ' not enter.');
            } else {
                if (preg_match($val[1], INPUT[$val[0]]) != 1) {
                    array_push($error, $val[0] . ' don\'t valid the regex.');
                } else {
                    $valid[$val[0]] = INPUT[$val[0]];
                }
            }
        }
        if (count($error) != 0) {
            $response['code'] = 'error';
            $response['reason'] = $error;
            return [$response, $valid];
        }
        $response['code'] = 'good';
        return [$response, $valid];
    }
?>
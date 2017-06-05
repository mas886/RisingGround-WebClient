<?php

    include_once("config.php");

    function getUser($token){
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,"/user/getuser"),true);
        return $returnedArray['Message'];
    }
    

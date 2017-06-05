<?php

    include_once("config.php");
    
    function getUserCharacters($token){
        
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,"/character/characterlist"),true);
        return $returnedArray['Message'];
    }

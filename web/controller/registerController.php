<?php

    include_once("config.php");
    
    function addNewUser($email, $username, $password){
        
        $data = array('username' => $username, 'password' => $password, 'email' => $email);
        $returnedArray=json_decode(makeApiRequest($data,"/user/signup"),true);
        return $returnedArray['Message'];
    }

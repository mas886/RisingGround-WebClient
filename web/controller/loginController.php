<?php

        include_once("config.php");
    
        if(isset($_POST['username'])&&isset($_POST['password'])){
            $_POST=filter_var_array($_POST, FILTER_SANITIZE_STRING);
            if (strlen($_POST['username']) > 1 && strlen($_POST['password']) > 1){
                $token=loginUser($_POST['username'], $_POST['password']);
                if (strlen($token)!=30){
                    $apiResult=$token;
                    header('Location: '."../login.php?mes=$apiResult");
                }else{
                    unset($apiResult);
                    setcookie("token", $token, time() + (86400 * 30), "/");
                    setcookie("user", $_POST['username'], time() + (86400 * 30), "/");
                    header('Location: '.'../character_choose.php');
                }
            }else{
                $apiResult="Wrong credentials";
                header('Location: '."../login.php?mes=$apiResult");
            }
        }
    
    function loginUser($username, $password){
        $data = array('username' => $username, 'password' => $password);
        $returnedArray=json_decode(makeApiRequest($data,"/user/login"),true);
        return $returnedArray['Message'];
    }

    function checkUserToken($token){
        //This is used to get user name and check token integrity
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,'/user/checktoken'),true);
        return $returnedArray['Message'];
    }

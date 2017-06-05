<?php
    $tokenIsCorrect=false;
    if(isset($_COOKIE['token'])){
        if(strlen($_COOKIE['token'])==30){
            include_once("controller/loginController.php");
            $tokenCheck=checkUserToken($_COOKIE['token']);
            if($tokenCheck!=false){
                $tokenIsCorrect=true;
                if(!isset($_COOKIE['character'])&&!isset($alreadyInCharChoose)){
                    header('Location: '.'./character_choose.php');
                }
                if(isset($_COOKIE['character'])&&!isset($alreadyOnIndex)){
                    header('Location: '.'./index.php');
                }
            }
        }if(!$tokenIsCorrect){
            include_once("logout.php");
            deleteCookies();
            header('Location: '.'./login.php?sessionEnd');
        }
    }else{
        if(!isset($alreadyInLogin)){
            include_once("logout.php");
            deleteCookies();
            header('Location: '.'./login.php');
        }
    }
    
?> 

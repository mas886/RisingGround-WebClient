<?php

    include_once("config.php");
    
    if(isset($_GET['character'])){
        setcookie("character", urldecode($_GET['character']), time() + (86400 * 30), "/");
        header('Location: '.'../index.php');
    }
    
    if(isset($_GET['unset'])){
        unsetCharacter();
        header('Location: '.'../index.php');
    }
    
    function addCharacter($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/character/addcharacter"),true);
        return $returnedArray['Message'];
    }
    
    function deleteCharacter($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/character/deletecharacter"),true);
        return $returnedArray['Message'];
    }
    
    function getCharacter($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/character/getcharacter"),true);
        
        if($returnedArray['Message']=="Expired"||$returnedArray['Message']=="Bad token"||$returnedArray['Message']==0||$returnedArray['Message']=="Character ownership error"){
            return false;
        }else{
            return $returnedArray['Message'];
        }
    }
    
    function getCharacterItems($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/character/getcharacteritems"),true);
        return $returnedArray['Message'];
    }
    
    function unsetCharacter(){
        setcookie("character", "", time() - 3600, "/");
    }
    

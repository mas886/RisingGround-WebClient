<?php
    
    include_once("config.php");

    function getSystemMessages($token){
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,"/gamemessage/getmessages"),true);
        return $returnedArray['Message'];
    }
    
    function deleteSystemMessages($token,$messageId){
        $data = array('token' => $token,'messageId' => $messageId);
        $returnedArray=json_decode(makeApiRequest($data,"/gamemessage/deletemessage"),true);
        return $returnedArray['Message'];
    }
    
    function getPlayerMessages($token){
        $data = array('token' => $token);
        $returnedArray=json_decode(makeApiRequest($data,"/message/getmessages"),true);
        return $returnedArray['Message'];
    }
    
    function deletePlayerMessages($token, $messageId){
        $data = array('token' => $token,'messageId' => $messageId);
        $returnedArray=json_decode(makeApiRequest($data,"/message/deletemessage"),true);
        return $returnedArray['Message'];
    }
    
    function sendMessage($token, $receiver, $text){
        $data = array('token' => $token, 'receiver'=> $receiver, 'text'=>$text);
        $returnedArray=json_decode(makeApiRequest($data,"/message/send"),true);
        return $returnedArray['Message'];
    }

    

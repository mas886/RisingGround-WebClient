<?php


    include_once("config.php");

    function getCharacterMonster($token,$characterMonsterId){
        $data = array('token' => $token, 'characterMonsterId' => $characterMonsterId);
        $returnedArray=json_decode(makeApiRequest($data,"/charactermonster/getcharactermonster"),true);
        return $returnedArray['Message'];
    } 
    
    function getCharacterMonsterList($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/charactermonster/monsterlist"),true);
        return $returnedArray['Message'];
    }
    
    function addMonsterToBuild($token,$buildId,$characterMonsterId){
        $data = array('token' => $token, 'buildId' => $buildId, 'characterMonsterId'=>$characterMonsterId);
        $returnedArray=json_decode(makeApiRequest($data,"/charactermonster/changebuild"),true);
        return $returnedArray['Message'];
    }

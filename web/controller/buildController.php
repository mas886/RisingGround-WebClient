<?php

    include_once("config.php");

    function getCharacterBuilds($token,$characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/build/getcharacterbuilds"),true);
        return $returnedArray['Message'];
    }
    
    function getBuild($token,$buildId){
        $data = array('token' => $token, 'buildId' => $buildId);
        $returnedArray=json_decode(makeApiRequest($data,"/build/getbuild"),true);
        return $returnedArray['Message'];
    }
    
    function deleteCharacterBuild($token,$buildId){
        $data = array('token' => $token, 'buildId' => $buildId);
        $returnedArray=json_decode(makeApiRequest($data,"/build/deletebuild"),true);
        return $returnedArray['Message'];
    }
    
    function addBuild($token, $characterName, $buildName){
        $data = array('token' => $token, 'characterName' => $characterName, 'buildName' =>$buildName);
        $returnedArray=json_decode(makeApiRequest($data,"/build/addbuild"),true);
        return $returnedArray['Message'];
    }
    
    function selectBuild($token, $characterName, $buildId){
        $data = array('token' => $token, 'characterName' => $characterName, 'buildId' =>$buildId);
        $returnedArray=json_decode(makeApiRequest($data,"/character/updatebuild"),true);
        return $returnedArray['Message'];
    }

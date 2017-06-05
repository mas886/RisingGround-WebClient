<?php

    include_once("config.php");

    function getDungeons($token,$characterName){
        //gets an array of dungeons available to the character
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,'/dungeon/getavailabledungeons'),true);
        return $returnedArray['Message'];
    }
    
    function listDungeonLevels($token,$characterName,$dungeonId){
        //gets an array of dungeon levels available to the character
        $data = array('token' => $token, 'characterName' => $characterName, 'dungeonId' => $dungeonId);
        $returnedArray=json_decode(makeApiRequest($data,'/dungeon/listdungeonlevels'),true);
        return $returnedArray['Message'];
    }
    
    function getLevelStages($token,$characterName,$levelId){
        //gets an array of dungeon levels available to the character
        $data = array('token' => $token, 'characterName' => $characterName, 'levelId' => $levelId);
        $returnedArray=json_decode(makeApiRequest($data,'/dungeon/getlevelstages'),true);
        return $returnedArray['Message'];
    }
    
    function proceedLevel($token, $characterName, $stageId){
        //biribop
        $data = array('token' => $token, 'characterName' => $characterName, 'stageId' => $stageId);
        $returnedArray=json_decode(makeApiRequest($data,'/dungeon/proceedlevel'),true);
        return $returnedArray['Message'];
    }

?>

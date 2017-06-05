<?php
    
    include_once("config.php");

    function getCharacterRewards($token, $characterName){
        $data = array('token' => $token, 'characterName' => $characterName);
        $returnedArray=json_decode(makeApiRequest($data,"/reward/listavailablerewards"),true);
        return $returnedArray['Message'];
    }
    
    function claimReward($token, $characterName, $rewardId){
        $data = array('token' => $token, 'characterName' => $characterName, 'rewardId' => $rewardId);
        $returnedArray=json_decode(makeApiRequest($data,"/reward/claimreward"),true);
        return $returnedArray['Message'];
    }

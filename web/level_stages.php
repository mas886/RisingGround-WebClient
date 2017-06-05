<?php

    $alreadyOnIndex=true;
    include_once("./default_header.php");
    include_once("./controller/characterController.php");
    
    $character=getCharacter($_COOKIE['token'],$_COOKIE['character']);
    if($character==false){
        unsetCharacter();
        header('Location: '."./login.php");
    }
    if(!isset($_GET['levelId'])){
        header('Location: '."./index.php");
    }
    
    include_once("./controller/dungeonController.php");
    $levelStages=getLevelStages($_COOKIE['token'],$_COOKIE['character'],$_GET['levelId']);
    //var_dump($levelStages);
    
    function cmp ($a, $b)
    {  
        $index='Position';
        if ($a[$index] == $b[$index]) return 0;
        return ($a[$index] < $b[$index]) ? -1 : 1;
    } 
    
    usort($levelStages,"cmp"); 
    
    $maxLevelKey=max(array_keys($levelStages));
    
    if(isset($_POST['stageToProgress'])){
        $retornValor=proceedLevel($_COOKIE['token'],$_COOKIE['character'], $_POST['stageToProgress']);
        if($retornValor!=1){
            if($retornValor=="Character is bussy"){
                $retornValor="Your character is resting util: ".$character['restingUntil'];
            }else if(($retornValor)=="Stage was already completed."){
                $retornValor="You reached dungeon end.";
            }
        ?><script>showError=true;</script><?php
            
        }else{
            header("Refresh:0");
        }
    }
    
?> 

<body class="login">
    <?php include("./status_bar.php"); ?>
    <div class="background-image"></div>
    <div class="contentLevelStages">
        <div class="itemListHeader">
            <p class="h1LevelStages"><b><?php echo $_GET['name']; ?></b></p>
        </div>
        <div class="itemListScrolled">
                <?php
                foreach($levelStages as $key=>$stage){
                ?>
                
                <div class="levelStageListItem">
                    <img class="characterListAvatar" src=".<?php echo $stage['Picture']; ?>" alt="Avatar"/>
                    <p class="headerTextStageType"><?php if ($stage['Type']=="text"){echo "Story";}else if($stage['Type']=="combat"){echo "Battle";}?>:</p>
                    <p class="inGameTextBlock"><?php echo $stage['Text'] ;?></p>
                    <?php if(($key==$maxLevelKey)||($stage['Type']!="text")){ ?>
                    <form method="POST">
                        <input type="hidden" name="stageToProgress" value="<?php echo $stage['StageId']; ?>"/>
                        <input class="btn inGameButton" type="submit" value="<?php if ($stage['Type']=="text"){echo "Continue";}else if($stage['Type']=="combat"){echo "Fight";}?>" />
                    </form>
                    <?php }else{echo "<br/>";} ?>
                </div>
                <?php
                    }
                ?>
            
        </div>
        
        
        <!-- Error Modal -->
        <div id="errorModal" class="modal">

        <!-- Modal content -->
            <div class="modal-content">
                <span id="errorClose" class="close">&times;</span>
                <font color="red"><h3 class="h3Center">Warning!<h3></font>
                <h3 class="h3Center"><?php if(isset($retornValor)){ echo $retornValor; } ?></h3>
                   
            </div>

        </div>
        
        
        
        
    </div>
</body>

    <script src="js/modalBoxes.js"/>

<?php
    include_once("default_footer.php");
?>

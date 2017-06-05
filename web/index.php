<?php
    $alreadyOnIndex=true;
    include_once("./default_header.php");
    include_once("./controller/characterController.php");
    include_once("controller/dungeonController.php");
    include_once "./controller/buildController.php";
    include_once "./controller/characterMonsterController.php";
    include_once "./controller/shopController.php";
    
    $character=getCharacter($_COOKIE['token'],$_COOKIE['character']);
    if($character==false){
        unsetCharacter();
        header('Location: '."./login.php");
    }
    
    if(isset($_POST['dungeonIdToEnter'])&&isset($_POST['dungeonNameToEnter'])){ 
        //Show dungeon levels modal 
        $loadLevels=true;
        ?>
        <script> var showLevelsModal=true; </script>
    <?php }
    $loadBuildManage=true;
    
    if (isset($_POST['newBuildName'])){
        if(strlen($_POST['newBuildName']) >= 3 && strlen($_POST['newBuildName']) <= 13){
            $apiResult=addBuild($_COOKIE['token'], $_COOKIE['character'], $_POST['newBuildName']);
        }else{
            $apiResult = "Name too short. Must be longer than 3 characters.";
        }
    ?>
            <script>var showBuildModal=true </script>
    <?php
    }
    
    if (isset($_POST['buildToSelect'])){
        $_POST['buildId']=$_POST['buildToSelect'];
        $apiResult=selectBuild($_COOKIE['token'], $_COOKIE['character'], $_POST['buildToSelect']);
    ?>
            <script>var showBuildModal=true </script>
    <?php
    }
    
    if (isset($_POST['buildToDelete'])){
        if(sizeof(getBuild($_COOKIE['token'],$_POST['buildToDelete'])['monsters'])==0){
            $apiResult=deleteCharacterBuild($_COOKIE['token'],$_POST['buildToDelete']);
        }else{
            $apiResult="Build is not empty, cannot be deleted.";
            $_POST['buildId']=$_POST['buildToDelete'];
        }
    ?>
            <script>var showBuildModal=true </script>
    <?php }
    
    if(isset($_POST['monsterToDeleteFromBuild'])){
        $apiResult=addMonsterToBuild($_COOKIE['token'],-1,$_POST['monsterToDeleteFromBuild']);
    }
    
    if(isset($_POST['buildId'])){
    ?>
            <script>var showBuildModal=true </script>
    <?php
    
    }
    
    if (isset($_POST['monsterToAddToBuild'])&&isset($_POST['buildId'])){
        $apiResult=addMonsterToBuild($_COOKIE['token'],$_POST['buildId'],$_POST['monsterToAddToBuild']);
        ?><script>var showBuildModal=true</script>
        <?php
    }
    
    if (isset($_POST['itemToBuyId'])&&isset($_POST['itemToBuyType'])){
        if ($_POST['itemToBuyType']=="gold"){
            $apiResult=buyItemGold($_POST['itemToBuyId'], $_COOKIE['character'], $_COOKIE['token'], 1);
        }else if($_POST['itemToBuyType']=="gems"){
            $apiResult=buyItemGems($_POST['itemToBuyId'], $_COOKIE['character'], $_COOKIE['token'], 1);
        } ?>
        <script>var showShopModal=true; </script>
        <?php
    } 
    ?>
    
<body class="login">
    <?php include("./status_bar.php");
    
    
    //Error modal controll
    if(isset($apiResult)){
        if($apiResult!=1){ ?>
            <script>var showError=true </script>
       <?php }
    }
    
    ?>
    
    <div class="background-image"></div>
    <div class="topLeftInGameMenu ingGameMenu">
        <h3 class="h3CenterLightgrey">User</h3>
        <div class="spacing"><button type="button" class="inGameMenuButton btn btn-default">Configuration</button></div>
        <div class="spacing"><a href="./controller/characterController.php?unset" class="inGameMenuButton btn btn-default">Switch Character</a></div>
        <div class="spacing"><a href="./logout.php?redirect" class="inGameMenuButton btn btn-default">Log out</a></div>
    </div>
    <div class="topMiddleInGameMenu ingGameMenu">
        <h3 class="h3CenterLightgrey"><?php if(isset($_COOKIE['character'])){ echo $_COOKIE['character'];}else{echo "characterNotSet";}?></h3>
        <p class="inGameMenuText"><?php if(!$character['resting']){echo "Your character is ready.";}else{echo "Resting until: ".$character['restingUntil'];} ?></p>
    </div>
    <div class="topRightInGameMenu ingGameMenu">
        <h3 class="h3CenterLightgrey">Character</h3>
        <div class="spacing"><button type="button" class="inGameMenuButton btn btn-default">Profile</button></div>
        <div class="spacing"><button id="manageBuildsButton" type="button" class="inGameMenuButton btn btn-default">Manage Builds</button></div>
        <div class="spacing"><button id="monstersButton" type="button" class="inGameMenuButton btn btn-default">Monsters</button></div>
        <div class="spacing"><button id="inventoryButton" type="button" class="inGameMenuButton btn btn-default">Inventory</button></div>
    </div>
    <div class="botLeftInGameMenu ingGameMenu">
        <h3 class="h3CenterLightgrey">Commerce</h3>
        <div class="spacing"><button id="shopButton" type="button" class="inGameMenuButton btn btn-default">Shop</button></div>
        <div class="spacing"><button type="button" class="inGameMenuButton btn btn-default">Auction</button></div>
    </div>
    <div class="botRightInGameMenu ingGameMenu">
        <h3 class="h3CenterLightgrey">Battle</h3>
        <div class="spacing"><button id="openDungeonButton" type="button" class="inGameMenuButton btn btn-default">Dungeons</button></div>
        <div class="spacing"><button type="button" class="inGameMenuButton btn btn-default">Training Battle</button></div>
    </div>
    
    <div class="inGameModals">
    
        <!-- Dungeon Display Modal -->
        <div id="battleModal" class="modal">

            <div class="modal-content">
                <span id="closeDungeonsModal" class="close">&times;</span>
                <h3 class="h3CenterLightgrey">Dungeons</h3>
                <div class="listItems">
                <?php 
                    $dungeons=getDungeons($_COOKIE['token'],$_COOKIE['character']);
                    foreach($dungeons as $dungeon){ ?>
                        <div class="dungeonListItem">
                            <h3 class="h3CenterLightgreyListItem"><?php echo $dungeon['name']; ?></h3>
                            <p class="itemDescriptionJustified"><?php echo $dungeon['description']; ?></p>
                            <p class="itemProperty"><b>Minimum Level: <?php echo $dungeon['minLevel']; ?></b></p>
                            <form method="POST">
                                <input name="dungeonIdToEnter" type="hidden" value="<?php echo $dungeon['id'] ; ?>">
                                <input name="dungeonNameToEnter" type="hidden" value="<?php echo $dungeon['name'] ; ?>">
                                <input class="btn itemButton" type="submit" value="Enter dungeon"/>
                            </form>
                        </div>
                   <?php }
                ?>
                </div>
            </div>

        </div>
        
        
        
        <!-- Dungeon Level Display Modal -->
        <div id="dungeonLevelsModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span id="closeDungeonLevelsModal" class="close">&times;</span>
                <?php if(isset($loadLevels)){ ?>
                <h3 class="h3CenterLightgrey"><?php echo $_POST['dungeonNameToEnter']; ?> Levels</h3>
                <div class="listItems">
                    <?php $levels=listDungeonLevels($_COOKIE['token'],$_COOKIE['character'],$_POST['dungeonIdToEnter']);
                    foreach($levels as $level){
                    $available=$level['available'];
                    ?>
                    <?php if($available=="yes"){ ?><a class="characterListItem" href="./level_stages.php?levelId=<?php echo $level['id']; ?>&name=<?php echo $level['name']; ?>"><?php } ?>
                    <div class="dungeonListItem">
                        <h3 class="h3CenterLightgreyListItem"><?php echo $level['name']; ?></h3>
                        <p class="itemDescriptionJustified"><?php echo $level['description']; ?></p>
                        <p class="itemProperty"><b><?php if($available=="yes"){echo "Unlocked";}else{echo "Locked";} ?></b></p>
                    </div>
                    <?php if($available=="yes"){ ?></a><?php } ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>

        </div>
        
        
        <!-- Build Management Modal -->
        <div id="buildManageModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span id="closeBuildManageModal" class="close">&times;</span>
                <?php if(isset($loadBuildManage)){ ?>
                <h3 class="h3CenterLightgrey">Manage Builds</h3>
                <div class="manageBuilds">
                    <div class="modalSplit2">
                        <h3 class="h3CenterLightgrey">Select a Build</h3>
                        <?php $builds=getCharacterBuilds($_COOKIE['token'],$_COOKIE['character']); 
                        foreach($builds as $build){
                        ?>
                            <form method="post">
                                <input type="hidden" name="buildId" value="<?php echo $build['id']; ?>"/>
                                <input type="submit" class="buildListItem" value="<?php echo $build['name']; ?>"/>
                            </form>
                        <?php } ?>
                        <div class="inGameMenuButtonFixedBottom">
                            <form method="POST">
                                <input type="text" maxlength="13" class="inGameMenuButton" name="newBuildName" placeholder="New build's name"><br/>
                                <input class="btn inGameMenuButton" type="submit" value="Add a new build"/>
                            </form>
                        </div>
                    </div>
                    <div class="modalSplit2 scrolled">
                        <h3 class="h3CenterLightgrey">Selected build options</h3>
                        <?php if (isset($_POST['buildId'])){ 
                                $build=getBuild($_COOKIE['token'],$_POST['buildId']);?>
                                <form method="POST">
                                    <input type="hidden" name="buildToSelect" value="<?php echo $_POST['buildId']; ?>"/>
                                    <input type="submit" class="btn itemButton" value="Select Build"/>
                                </form>
                            <p class="inGameMenuLabels">Monsters on the build<small>(Click on the monster to remove it fromthe build):</small></p>
                            <div class="monstersOnBuild">
                                <?php foreach($build['monsters'] as $monster){
                                    $monster=getCharacterMonster($_COOKIE['token'],$monster['id']);
                                ?>
                                <form class="" method="post">
                                    <input type="hidden" name="buildId" value="<?php echo $_POST['buildId'];?>"/>
                                    <input type="hidden" name="monsterToDeleteFromBuild" value="<?php echo $monster['id']; ?>"/>
                                    <input type="submit" class="buildListItem" value="<?php echo $monster['name']; ?>"/>
                                </form>
                                <?php } ?>
                            </div>
                            <p class="inGameMenuLabels">Add monsters to the build:</p>
                            
                            <?php $monsterList=getCharacterMonsterList($_COOKIE['token'], $_COOKIE['character']); ?>
                            <form method="POST">
                                <input type="hidden" name="buildId" value="<?php echo $_POST['buildId'];?>"/>
                                <select name="monsterToAddToBuild" class="form-control" >
                                    <?php foreach($monsterList as $monstro){ if($monstro['buildId']==NULL){ ?>
                                        <option value="<?php echo $monstro['id']; ?>"><?php echo $monstro['name']; ?></option>
                                    <?php } } ?>
                                </select><br/>
                                <input type="submit" class="btn inGameMenuButton"  value="Add to the Build"/>
                            </form>
                            <div class="">
                                <form method="POST">
                                    <input type="hidden" name="buildToDelete" value="<?php echo $build['id']; ?>"/>
                                    <input class="btn btn-danger inGameMenuButton" type="submit" value="Delete Build"/>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
          
            
        </div>
        
         <!-- Shop Modal -->
        <div id="shopModal" class="modal">

            <div class="modal-content">
                <?php $shopItems=getItems($_COOKIE['token']); ?>
                <span id="closeshopModal" class="close">&times;</span>
                <h3 class="h3CenterLightgrey">Shop</h3>
                <div class="squareItemList">
                    <?php if(sizeof($shopItems['gold'])>0){ ?>
                        <?php foreach($shopItems['gold'] as $item ){ ?>
                            <div class="squareItemListItem">
                                <center><img class="squareItemListImage" src=".<?php echo $item['sprite']; ?>" alt="Item Picture"></center>
                                <p class="inGameMenuLabels"><?php echo $item['name']; ?></br><?php echo $item['value']; ?> <img class="statusBarIcon" src="images/coin.png" alt="Gold" /></p>
                                <form method="POST">
                                    <input type="hidden" name="itemToBuyId" value="<?php echo $item['id']; ?>"/>
                                    <input type="hidden" name="itemToBuyType" value="gold"/>
                                    <input class="btn buttonCenter" type="submit" value="Buy"/> 
                                </form>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if(sizeof($shopItems['gems'])>0){ ?>
                        <?php foreach($shopItems['gems'] as $item ){ ?>
                            <div class="squareItemListItem">
                                <center><img class="squareItemListImage" src=".<?php echo $item['sprite']; ?>" alt="Item Picture"></center>
                                <p class="inGameMenuLabels"><?php echo $item['name']; ?></br><?php echo $item['value']; ?> <img class="statusBarIcon" src="images/gem.png" alt="Gold" /></p>
                                <form method="POST">
                                    <input type="hidden" name="itemToBuyId" value="<?php echo $item['id']; ?>"/>
                                    <input type="hidden" name="itemToBuyType" value="gems"/>
                                    <input class="btn buttonCenter" type="submit" value="Buy"/> 
                                </form>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Inventory Modal -->
        <div id="inventoryModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span id="inventoryClose" class="close">&times;</span>
                <h3 class="h3Center">Inventory</h3>
                <div class="squareItemList">
                <?php $items=getCharacterItems($_COOKIE['token'],$_COOKIE['character']);
                if(sizeof($items)>0){ ?>
                    <?php foreach($items as $item ){ ?>
                        <div class="squareItemListItemSmall popAuver">
                            <center><img class="squareItemListImage" src=".<?php echo $item['sprite']; ?>" alt="Item Picture"></center>
                            <p class="inGameMenuLabels"><?php echo $item['name']; ?><br/>Amount: <?php echo $item['amount']; ?>  </p>
                            <span class="popAuver"><?php echo $item['description'];?></span>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Monsters Modal -->
        <div id="monstersModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span id="monstersModalClose" class="close">&times;</span>
                <h3 class="h3Center">Monsters</h3>
                <div class="squareItemList">
                
                <?php $monsters=getCharacterMonsterList($_COOKIE['token'],$_COOKIE['character']); ?>
                
                <?php
                if(sizeof($monsters)>0){ ?>
                    <?php foreach($monsters as $monster ){ ?>
                        <div class="squareItemListItemSmall popAuver">
                            <center><img class="squareItemListImage" src=".<?php echo $monster['sprite']; ?>" alt="Item Picture"></center>
                            <p class="inGameMenuLabels"><?php echo $monster['name']; ?><br/>Exp: <?php echo $monster['experience']; ?>  </p>
                            <span class="popAuver"><?php echo $monster['description'];?></span>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Error Modal -->
        <div id="errorModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="width: 300px;">
                <span id="errorClose" class="close">&times;</span>
                <font color="red"><h3 class="h3Center">Alert!<h3></font>
                <h3 class="h3CenterLightgrey"><?php if(isset($apiResult)){ echo $apiResult; } ?></h3>
            </div>
        </div>
        
        
    </div>
    
    
    
    
    
    
    
    
    <script>
        var battleModal = document.getElementById('battleModal');
        var closeDungeonSpan = document.getElementById("closeDungeonsModal");
        var openDungeonButton = document.getElementById("openDungeonButton");
        closeDungeonSpan.onclick = function() {
            battleModal.style.display = "none";
        }
        openDungeonButton.onclick = function() {
            battleModal.style.display = "block";
        }
        
        var levelsModal=document.getElementById('dungeonLevelsModal');
        var closeDungeonLevelsSpan = document.getElementById("closeDungeonLevelsModal");
        closeDungeonLevelsSpan.onclick = function() {
            levelsModal.style.display = "none";
        }
        if(typeof showLevelsModal !== 'undefined'){
            levelsModal.style.display = "block";
        }     
        
        
        var inventoryButton=document.getElementById('inventoryButton');
        var inventoryModal=document.getElementById('inventoryModal');
        var inventoryClose = document.getElementById("inventoryClose");
        inventoryButton.onclick = function() {
            inventoryModal.style.display = "block";
        }
        inventoryClose.onclick = function() {
            inventoryModal.style.display = "none";
        }
        
        var monstersButton=document.getElementById('monstersButton');
        var monstersModal=document.getElementById('monstersModal');
        var monstersModalClose=document.getElementById('monstersModalClose');
        monstersButton.onclick = function() {
            monstersModal.style.display = "block";
        }
        monstersModalClose.onclick = function() {
            monstersModal.style.display = "none";
        }
        
        
        var manageBuildsButton=document.getElementById('manageBuildsButton');
        var buildManageModal=document.getElementById('buildManageModal');
        var closeBuildManageModal = document.getElementById("closeBuildManageModal");
        closeBuildManageModal.onclick = function() {
            buildManageModal.style.display = "none";
        }
        manageBuildsButton.onclick = function() {
            buildManageModal.style.display = "block";
        }
        if(typeof showBuildModal !== 'undefined'){
            buildManageModal.style.display = "block";
        }
        
        
        
        var shopButton=document.getElementById('shopButton');
        var shopModal=document.getElementById('shopModal');
        var closeshopModal = document.getElementById("closeshopModal");
        closeshopModal.onclick = function() {
            shopModal.style.display = "none";
        }
        shopButton.onclick = function() {
            shopModal.style.display = "block";
        }
        if(typeof showShopModal !== 'undefined'){
            shopModal.style.display = "block";
        }
        
        var errorModal = document.getElementById('errorModal');
        if(typeof showError !== 'undefined'){
            errorModal.style.display = "block";
            console.log("taputamare");
            var spanError = document.getElementById("errorClose");
            spanError.onclick = function() {
                errorModal.style.display = "none";
            }
        }
        
        window.onclick = function(event) {
            if (event.target == battleModal) {
                battleModal.style.display = "none";
            }else if(event.target == levelsModal){
                levelsModal.style.display = "none";
            }else if(event.target == buildManageModal){
                buildManageModal.style.display = "none";
            }else if(event.target == errorModal){
                errorModal.style.display = "none";
            }else if(event.target == shopModal){
                shopModal.style.display = "none";
            }else if(event.target == inventoryModal){
                inventoryModal.style.display = "none";
            }
        }
        
    </script>
    
    
</body>
    
    
<?php
    include_once("default_footer.php");
?>

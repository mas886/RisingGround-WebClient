<?php
    //This variable is to prevent infinite redirections to this page caused by default_header.php (That redirects here if the cookie "characterInUse" is not set)
    $alreadyInCharChoose=true;
    
    include("./default_header.php");
    
    if(isset($_POST['charToDelete'])){ ?>

                <script>showYesNoWarning=true;</script>
            <?php
    }
    
    if(isset($_POST['charToDeleteSecure'])){
            include_once("./controller/characterController.php");
            $apiResult = deleteCharacter($_COOKIE['token'],urldecode($_POST['charToDeleteSecure']));
            if($apiResult==1){
                header('Location: '.'./character_choose.php');
            }else{ ?>
                <script>showError=true;</script>
            <?php
            }
    }
    
    //Add new charecter form
    if(isset($_POST['newCharacterNameInput'])){
        if(strlen($_POST['newCharacterNameInput'])>=4){
            include_once("./controller/characterController.php");
            $apiResult = addCharacter($_COOKIE['token'],$_POST['newCharacterNameInput']);
            if($apiResult==1){
                header('Location: '.'./character_choose.php');
            }else{ ?>
                <script>showError=true;</script>
            <?php
            }
        }else{?>
                <script>showError=true;</script>
            <?php
        }
    }
    
    
    include_once("./controller/characterSelectController.php");
    $characterList=getUserCharacters($_COOKIE['token']);
  ?>
  <body class="login">
    <?php include("./status_bar.php"); ?>
    <div class="background-image"></div>
    
    <div class="contentCharSelect">
            <h1>Select a character</h1>
            
            <?php foreach($characterList as $char){ ?>
            <div class="characterListItemPositioning">
                <a class="characterListItem" href='./controller/characterController.php?character=<?php echo urlencode($char['name']); ?> '>
                    <div class="characterListItem">
                        <img class="characterListAvatar" src="images/avatars/characters/avatar_default.png" alt="Avatar"/>
                        
                        <div class="floatRight">
                            <form method="post">
                                <input type="hidden" name="charToDelete" value="<?php echo urlencode($char['name']); ?>"/>
                                <input type="submit"  class="btn btn-danger" value="Delete"/>
                                <!--<button type="button" id="yesNoWarningButton" class="btn btn-danger">Delete</button>-->
                            </form>
                        </div>
                        
                        <h2><?php echo $char['name'];?></h2><br/>
                        <p>Exp: <?php echo $char['experience'];?></p>
                    </div>
                </a>
            </div>
            <?php } ?>
            <br/>
            
            <div class="centerButton">
                <button type="button" id="myBtn" class="btn btn-primary">Add new character</button>
            </div>

            <!-- Add character modal -->
            <div id="myModal" class="modal">

            <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3 class="h3CenterLightgrey">Add new character<h3>
                    <form method="post">
                        <p class="inGameMenuLabels">Character name: (min. length 4 characters)</p>
                        <input pattern=".{4,}"   required name="newCharacterNameInput" class="formInput" type="text" maxlength="20"/>
                        <br/>
                        <div class="centerButton">
                            <input class="btn btn-primary" type="submit" value="Add character"/>
                        </div>
                    </form>
                </div>

            </div>
        
        
            
            <!-- Error Modal -->
            <div id="errorModal" class="modal">

            <!-- Modal content -->
                <div class="modal-content">
                    <span id="errorClose" class="close">&times;</span>
                    <font color="red"><h3 class="h3Center">Error<h3></font>
                    <h3 class="h3CenterLightgrey"><?php if(isset($apiResult)){ echo $apiResult; } ?></h3>
                   
                </div>

            </div>
            
            
            <!-- Error Modal -->
            <div id="modalYesNo" class="modal">

            <!-- Modal content -->
                <div class="modal-YesNo-content">
                    <span id="warningModalClose" class="close">&times;</span>
                    <font color="red"><h3 class="h3Center">Warning!</h3></font>
                    <h4 class="h4Center">You are about to delete:</h4> <h3 class="h3Center"><?php if(isset($_POST['charToDelete'])){ echo urldecode($_POST['charToDelete']);} ?></h3> 
                    <div class="yesButtonFloatLeft"><button class="btn btn-success" id="cancelWarningButton">Cancel</button></div><div class="floatRight">
                    <form method="post">
                        <input type="hidden" name="charToDeleteSecure" value="<?php if(isset($_POST['charToDelete'])){ echo $_POST['charToDelete'];} ?>"/>
                        <input type="submit" class="btn btn-warning" id="cancelWarningButton" value="Delete"/></div>
                    </form>
                    <br/><br/><br/>
                </div>

            </div>
            
            
        
    </div>

<!-- Modal script -->

    <script src="js/modalBoxes.js"></script>
  
  
<?php
include("./default_footer.php");
?>

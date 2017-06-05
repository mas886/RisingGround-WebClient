<ul class="statusBar">
  <li class="floatLeft"><a href="./">Home</a></li>
  
  <?php 
    include_once("controller/userController.php");
    include_once("controller/messageController.php");
    include_once("controller/rewardController.php");
    
    $user=getUser($_COOKIE['token']);
    $messages=getSystemMessages($_COOKIE['token']);
    $playerMessages=getPlayerMessages($_COOKIE['token']);
    $rewards=getCharacterRewards($_COOKIE['token'], $_COOKIE['character']);
    if(isset($_POST['playerMessageToDelete'])){
        deletePlayerMessages($_COOKIE['token'], $_POST['playerMessageToDelete']);
        header("Refresh:0");
    }
    if(isset($_POST['messageToDelete'])){
        deleteSystemMessages($_COOKIE['token'],$_POST['messageToDelete']);
        header("Refresh:0");
    }
    if(isset($_POST['messageReciever'])&&isset($_POST['messageBody'])){
        $apiResult=sendMessage($_COOKIE['token'], $_POST['messageReciever'], $_POST['messageBody']);
        if($apiResult==1){
            header("Refresh:0");
        }
    }
    if(isset($_POST['rewardToClaim'])){
        $apiResult=claimReward($_COOKIE['token'], $_COOKIE['character'], $_POST['rewardToClaim']);
        if($apiResult==1){
            header("Refresh:0");
        }
    }
  ?>
  
  <li class="floatLeft currency">Gold: <?php echo $user['gold']; ?> <img class="statusBarIcon" src="images/coin.png" alt="Gold" /></li>
  <li class="floatLeft currency">Gems: <?php echo $user['gems']; ?> <img class="statusBarIcon" src="images/gem.png" alt="Gems" /></li>
  
  <li class="dropdown floatLeft">
    <a href="javascript:void(0)" class="dropbtn">Sys. Messages <span class="badge"><?php if (isset($_COOKIE['character'])){echo sizeof($messages)+sizeof($rewards);}else{ echo sizeof($messages); }?></span></a>
    <div class="dropdown-content dropdown-scrolled">
    <p class="itemDescriptionCenter"><b>Messages.</b></p>
        <?php foreach($messages as $message){ ?>
            <div class="dropdown-item">
                <form method="post">
                    <input type="hidden" name="messageToDelete" value="<?php echo $message['id']; ?>"></input>
                    <input type="submit" class="dropdown-item-delete" value="x"></input>
                </form>
                <b class="dropdown-item-header"><?php echo$message['nameSender']; ?><br/><small><?php echo$message['sendDate']; ?></small></b>
                <p><?php echo$message['content']; ?></p>
            </div>
            <hr/>
        <?php } if(sizeof($messages)==0){ echo '<p class="itemDescriptionCenter">There\'s no messages.</p><hr/>';}?>
        <p class="itemDescriptionCenter"><b>Pending Rewards</b></p>
        <?php 
        if (isset($_COOKIE['character'])&&!empty($rewards)){var_dump($rewards); foreach($rewards as $reward){ ?>
            <div class="dropdown-item">
                <b class="dropdown-item-header">Reward<br/><small><?php echo $reward['date']; ?></small></b>
                <p>You got a pending reward for the stage: <?php echo $reward['stageCompletedId']; ?> </p>
                <form method="POST">
                    <input type="hidden" name="rewardToClaim" value="<?php echo $reward['id']; ?>" >
                    <input class="btn buttonCenter" type="submit" value="Claim">
                </form>
            </div>
            <hr/>
        <?php }}else if(sizeof($rewards)==0){ echo '<p class="itemDescriptionCenter">There\'s no pending rewards.</p><hr/>';}?>
    </div>
  </li>
  <li class="dropdown floatLeft">
    <a href="javascript:void(0)" class="dropbtn">Interactions <span class="badge"><?php echo sizeof($playerMessages); ?></span></a>
    <div class="dropdown-content dropdown-scrolled">
        <?php foreach($playerMessages as $message){ ?>
            <div class="dropdown-item">
                <form method="post">
                    <input type="hidden" name="playerMessageToDelete" value="<?php echo $message['id']; ?>"></input>
                    <input type="submit" class="dropdown-item-delete" value="x"></input>
                </form>
                <b class="dropdown-item-header"><?php echo $message['from']; ?><br/><small><?php echo$message['sendDate']; ?></small></b>
                <p><?php echo$message['content']; ?></p>
            </div>
            <hr/>
        <?php } if(sizeof($playerMessages)==0){ echo '<p class="itemDescriptionCenter">There\'s no messages.</p><hr/>';}?>
        <div>
            <p class="itemDescriptionCenter">Send a message to another player:</p>
            <form method="POST">
                <input class="formInput form-control" required name="messageReciever" placeholder="PlayerName" maxlength="20" type="text"><br/>
                <textarea class="form-control" required  minlength=10 name="messageBody" placeholder="Message body" rows="3"></textarea><br/>
                <input type="submit" class="btn btn-default" value="Send Message"/>
            </form>
        </div>
    </div>
  </li>
    
  <li class="dropdown floatRight">
    <a href="javascript:void(0)" class="dropbtn"><?php if(isset($_COOKIE['user'])){ echo $_COOKIE['user'] ;}else{ echo "NULL";} ?></a>
    <div class="dropdown-content">
      <a href="#">Profile</a>
      <a href="./controller/characterController.php?unset">Swit. Char.</a>
      <a href="./logout.php?redirect">Logout</a>
    </div>
  </li>
  
    <li class="floatRight currency"> <?php if(isset($_COOKIE['character'])){echo "Using: ".$_COOKIE['character'];} ?> </li>

</ul>

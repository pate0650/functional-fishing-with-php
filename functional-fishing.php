<?php
session_start();
/**********************************************
 * STARTER CODE
 **********************************************/

/**
 * clearSession
 * This function will clear the session.
 */
function clearSession()
{
  session_unset();
  header("Location: " . $_SERVER['PHP_SELF']);
}

/**
 * Invokes the clearSession() function.
 * This should be used if your session becomes wonky
 */
if (isset($_GET['clear'])) {
  clearSession();
}

/**
 * getResponse
 * Gets the response history array from the session and converts to a string
 * 
 * This function should be used to get the full response array as a string
 * 
 * @return string
 */
function getResponse()
{
  return implode('<br><br>', $_SESSION['functional_fishing']['response']);
}

/**
 * updateResponse
 * Adds a new response to the response array found in session
 * Returns the full response array as a string
 * 
 * This function should be used each time an action returns a response
 * 
 * @param [string] $response
 * @return string
 */
function updateResponse($response)
{
  if (!isset($_SESSION['functional_fishing'])) {
    createGameData();
  }

  array_push($_SESSION['functional_fishing']['response'], $response);

  return getResponse();
}

/**
 * help
 * Returns a formatted string of game instructions
 * 
 * @return string
 */
function help()
{
  return 'Welcome to Functional Fishing, the text based fishing game. Use the following commands to play the game: <span class="red">eat</span>, <span class="red">fish</span>, <span class="red">fire</span>, <span class="red">wood</span>, <span class="red">bait</span>. To restart the game use the <span class="red">restart</span> command For these instruction again use the <span class="red">help</span> command';
}

/**********************************************
 * YOUR CODE BELOW
 **********************************************/

/**
 * createGameData
 *  @return bool
 */
function createGameData(){
  $_SESSION['functional_fishing'] = [
      'response' => [],
      'bait' => 0 ,
      'wood' => 0,
      'fish' => 0,
      'fire' => false
  ];
  return isset($_SESSION['functiona_fishing']);
}
/**
 * Player Command
 */
if (isset($_POST['command'])) {
  $command = explode(' ', strtolower($_POST['command']));
  if (function_exists($command[0])) {
    // execute the function
    // check if an option was provided
    if (isset($command[1])) {
      updateResponse($command[0]($command[1]));
    } else {
      updateResponse($command[0]());
    }
  } else {
    updateResponse("{$_POST['command']} is not a valid command");
  }
}
/**
 * fire
 *
 */

// function fire()
// {
//   if ($_SESSION['functiona_fishing']['fire']) {
//     $_SESSION['functiona_fishing']["fire"] = false;
//     return "You have put out the fire";
//   } else {
//     if ($_SESSION['functiona_fishing']['wood'] > 0) {
//       $_SESSION['functiona_fishing']["wood"]--;
//       $_SESSION['functiona_fishing']["fire"] = true;
//       return "You have started a fire";
//     } else {
//       return "You do not have enough wood";
//     }
//   }
// }

function fire()
{
    if ($_SESSION['functional_fishing']['fire']) {
        //  turn off fire
        $_SESSION['functional_fishing']['fire'] = false;
        return "Fire has been put out.";
    } else {
        //  turn on fire
        if ($_SESSION['functional_fishing']['wood'] > 0) {
            $_SESSION['functional_fishing']['wood']--;
            $_SESSION['functional_fishing']['fire'] = true;
            return "First has been started.";
        } else {
            return "You do not have enough wood.";
        }
    }
}
/**
 * bait
 * 
 */
// function bait(){
//   if(!$_SESSION['functiona_fishing']['fire']){
//     $_SESSION['functiona_fishing']["bait"]++;
//     return " You have one bait";
    
//   }else{
//     return " You Must put out the fire";
//   }
 
// }

function bait()
{
    if ($_SESSION['functional_fishing']['fire']) {
        return "You need to put out fire.";
    } else {
        $_SESSION['functional_fishing']['bait'] ++;
        return "You have found some bait.";
    }
}

/**
 * wood
 * 
 */
// function wood(){
//   if(!$_SESSION['functiona_fishing']['fire']){
//     $_SESSION['functiona_fishing']['wood']++;
//     return " you have found some wood"; 
 
//   }else{
//     return " You Must put out the fire";
//   }
// }
function wood()
{
    //  check fire
    if ($_SESSION['functional_fishing']['fire']) {
        return "You need to put out fire.";
    } else {
        $_SESSION['functional_fishing']['wood'] ++;
        return "You have found some wood.";
    }
}
/**
 * fish
 * 
 */
// function fish(){
//   if(!$_SESSION['functiona_fishing']['fire']){
//     if($_SESSION['functiona_fishing']['bait']>=1){
//       $_SESSION['functiona_fishing']["fish"]++;
//       $_SESSION['functiona_fishing']["bait"]--;
//       return " You have caught fish";
//     }else{
//         return "You do not have enough bait";
//     }
    
//   }else{
//     return "You Must put out the fire";
//   }
// }
function fish()
{
    if ($_SESSION['functional_fishing']['fire']) {
        return "You need to put out fire.";
    } else {
        //  turn on fire
        if ($_SESSION['functional_fishing']['bait'] > 0) {
            $_SESSION['functional_fishing']['bait'] --;
            $_SESSION['functional_fishing']['fish'] ++;
            return "You have found some fish.";
        } else {
            return "You do not have enough bait.";
        }
    }
}

/**
 * eat
 * 
 */
function eat(){
  if($_SESSION['functional_fishing']['fire']){
    if($_SESSION['functional_fishing']['fish']>0){
      $_SESSION['functional_fishing']["fish"]--;
      return "You have ate fish";
    }else{
      return "you do not have any fish";
    }
  }else{
    return " You do not have any fire";
  }
}


/**
 * inventory
 * 
 */
function inventory()
{
  $responses = '';

  foreach ($_SESSION['functional_fishing'] as $item => $value) {
    if ($item === 'fire') {
      if ($value) {
        $responses .= "The fire is going";
      } else {
        $responses .= "The fire is out";
      }
    } else if (!is_array($value)) {
      $responses .= "{$value} ${item}<br>";
    }
  }

  return $responses;
}
/**
 * restart
 * 
 */
function restart()
{
  createGameData();

  return 'The game has restarted';
}


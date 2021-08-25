<?php
require 'config.php';
include_once './apiFunctions.php';
include_once './utils.php';
session_start();

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');

$apiInput = json_decode(file_get_contents("php://input"));

$action = $apiInput->action;
$filePath = $apiInput->path;
$fileOrFolderName = $apiInput->newName;
$newContent = $apiInput->newContent;
$userName = $apiInput->userName;
$password = $apiInput->password;

  if ($action === LOGIN) {

    if ($userName === USERNAME && sha1($password) === PASSWORD_HASHED) {
      
      $_SESSION['isLoggedIn'] = true;
      $jsonRes = json_encode(responseMessage(false, LOGIN_SUCCESS));
      echo $jsonRes; 
      exit;

    } else {
      
      $jsonRes = json_encode(responseMessage(true, LOGIN_ERROR));
      echo $jsonRes; 
      exit;
      
    }

  } elseif($action === LOGOUT) {

    unset($_SESSION['isLoggedIn']);
    session_unset();

    $jsonRes = json_encode(responseMessage(false, LOGOUT_SUCCESS));
      echo $jsonRes; 
      exit;

  } elseif ($action === READ_DIR) {

    checkSession($_SESSION['isLoggedIn']);

    $data = getDirectoryTree($filePath);
		apiResponse($data);

	} elseif ($action === CREATE_DIR) {

    checkSession($_SESSION['isLoggedIn']);
  
    $data = createDir($filePath , $fileOrFolderName);
		apiResponse($data);
     
	} elseif ($action === RENAME_DIR) {
    
    checkSession($_SESSION['isLoggedIn']);

    $data = renameFileOrFolder($filePath , $fileOrFolderName);
    apiResponse($data);

	 } elseif ($action === DELETE_DIR) {
    
    checkSession($_SESSION['isLoggedIn']);

    $data = deleteDir($filePath);
    apiResponse($data);
     
	} elseif ($action === CREATE_FILE) {
    
    checkSession($_SESSION['isLoggedIn']);

    $data = createFile($filePath , $fileOrFolderName);
    apiResponse($data);
     
	} elseif ($action === UPDATE_FILE) {
    
    checkSession($_SESSION['isLoggedIn']);

    $data = updateFile($filePath , $newContent);
    apiResponse($data);
     
	} elseif ($action === DELETE_FILE) {
    
    checkSession($_SESSION['isLoggedIn']);

    $data = deleteFile($filePath);
    apiResponse($data);   

	}  else {
    
    checkSession($_SESSION['isLoggedIn']);

    $jsonRes = json_encode(
      array(
        'error' => true,
        'msg' => 'No Params'
      ));
      echo $jsonRes; 
      exit;
 
    }


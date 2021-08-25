<?php
require 'config.php';
include_once './apiFunctions.php';
include_once './utils.php';

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

	if ($action == READ_DIR) {

    $data = getDirectoryTree($filePath);
		apiResponse($data);

	} elseif ($action == CREATE_DIR) {
  
    $data = createDir($filePath , $fileOrFolderName);
		apiResponse($data);
     
	} elseif ($action == RENAME_DIR) {

    $data = renameFileOrFolder($filePath , $fileOrFolderName);
    apiResponse($data);

	 } elseif ($action == DELETE_DIR) {

    $data = deleteDir($filePath);
    apiResponse($data);
     
	} elseif ($action == CREATE_FILE) {

    $data = createFile($filePath , $fileOrFolderName);
    apiResponse($data);
     
	} elseif ($action == UPDATE_FILE) {

    $data = updateFile($filePath , $newContent);
    apiResponse($data);
     
	} elseif ($action == DELETE_FILE) {

    $data = deleteFile($filePath);
    apiResponse($data);   

	}  else {

        $jsonRes = json_encode(array(
            'error' => true,
            'msg' => 'No Params'
          ));
            echo $jsonRes; 
            exit;
 
    }


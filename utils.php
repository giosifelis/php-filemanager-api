<?php

function checkSession($sessionVar){
  $errorMsg = json_encode(responseMessage(true, LOGIN_ERROR));
    if(!$sessionVar) die($errorMsg);
}

function apiResponse($data) {
	 $jsonRes = json_encode($data);
    echo $jsonRes; 
    exit;
}

function responseMessage($error, $msg) {
  return array(
    'error' => $error,
    'msg' => $msg
  );
}

// check if we are in the FILES_FOLDER
function allowOnlyFilesFolder($dir) {
  return substr($dir, 0, 2) === '..' ||  explode('/', $dir)[1] != FILES_FOLDER;
}
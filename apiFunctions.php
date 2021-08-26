<?php
require_once 'utils.php';

function login($userName, $password){

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
  
}

function logout(){

  unset($_SESSION['isLoggedIn']);
    session_unset();

    $jsonRes = json_encode(responseMessage(false, LOGOUT_SUCCESS));
      echo $jsonRes; 
      exit;
}

//https://www.the-art-of-web.com/php/directory-list/
function readDirectory($dir){
  // die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, GET_DIR_ERROR));
  if(allowOnlyFilesFolder($dir)) 
     die($errorMsg);

  // array to hold return value
  $retval = [];  

  // add trailing slash if missing
  if(substr($dir, -1) != "/") {
    $dir .= "/";
  }

  // open pointer to directory and read list of files
  $d = @dir($dir) or die($errorMsg);


  while(FALSE !== ($fileName = $d->read())) {
    $fullPath = "{$dir}{$fileName}";
    // skip hidden files
    if($fileName{0} == ".") continue;
       $retval[] = [
        'label' => $fileName,
        'dir' => $dir,
        'type' => filetype($fullPath),
        'id' => time() + rand(10,10000)
      ];

      //  use the following function to get a recrusive tree directory (might be slow as it grows)
    // if(is_dir($fullPath)) {
    //   $retval[] = [
    //     'label' => $fileName,
    //     // 'fullPath' => $fullPath,
    //     'dir' => $dir,
    //     'type' => filetype($fullPath),
    //   'id' => time() + rand(10,10000),
    //     'files' => getDirectoryTree($fullPath)
    //   ];
    // } elseif(is_readable($fullPath)) {
    //   $retval[] = [
    //     'label' => $fileName,
    //     // 'fullPath' => $fullPath,
    //     'dir' => $dir,
    //     'type' => filetype($fullPath),
    //    'id' => time() + rand(10,10000)
    //   ];
    // }
  }
  $d->close();

  return array(
    'error' => false,
    'msg' => GET_DIR_SUCCESS,
    'data' => $retval
  );
}

function createDir($dir, $fileName){

  // die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, FOLDER_NOT_CREATED));
  if(allowOnlyFilesFolder($dir)) 
     die($errorMsg);
  
  $dir = str_replace('./', '', $dir);
  $folderName = $dir."/".$fileName;

  if(!is_dir($folderName) && mkdir($folderName)){
    
    return responseMessage(false, FOLDER_CREATED);
  } else {
    return responseMessage(true, FOLDER_NOT_CREATED);
  }

}

function renameFileOrFolder( $dir=false, $fileName=false ){
 // die if we are NOT in the FILES_FOLDER
 $errorMsg = json_encode(responseMessage(true, NOT_RENAMED));
 if(allowOnlyFilesFolder($dir)) 
    die($errorMsg);
  
 // get the current directory
  $baseDir = $dir;
  $baseDir = explode('/', $baseDir);
  array_pop($baseDir);
  $baseDir = implode('/', $baseDir);
  $newFolderName = $baseDir."/".$fileName;

  if(rename($dir, $newFolderName)) {
    return responseMessage(false, RENAMED);
  } else {
    return responseMessage(true, NOT_RENAMED);
  }


}

function deleteDir( $dir=false){
  // die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, FOLDER_NOT_DELETED));
  if(allowOnlyFilesFolder($dir)) 
     die($errorMsg);

  if(is_dir($dir) && rmdir($dir)){
    return responseMessage(false, FOLDER_DELETED);
  } else {
    return responseMessage(true, FOLDER_NOT_DELETED);
  }
}

function createFile( $dir=false, $filename=false ){

  // die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, FILE_NOT_CREATED));
  if(allowOnlyFilesFolder($dir)) 
     die($errorMsg);
  
  $dir = str_replace('./', '', $dir);

  $source = TEMPLATE_FOLDER; 
  $destination = $dir . DIRECTORY_SEPARATOR . $filename .".md"; 
  
  if( copy($source, $destination) ) { 
    return responseMessage(false, FILE_CREATED);
  } else { 
    return responseMessage(true, FILE_NOT_CREATED); 
  } 
}

function updateFile( $file=false, $newContent=false ){
// die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, FILE_NOT_UPDATED));
  if(allowOnlyFilesFolder($file)) 
     die($errorMsg);


  if(is_file($file) && file_put_contents($file, $newContent)){
    return responseMessage(false, FILE_UPDATED);
  } else {
    return responseMessage(true, FILE_NOT_UPDATED);
  }

}

function deleteFile( $file=false){
  // die if we are NOT in the FILES_FOLDER
  $errorMsg = json_encode(responseMessage(true, FILE_NOT_DELETED));
  if(allowOnlyFilesFolder($file)) 
     die($errorMsg);

  if(is_file($file) && unlink($file) ){
    return responseMessage(false, FILE_DELETED);
  } else {
    return responseMessage(true, FILE_NOT_DELETED);
  }
}

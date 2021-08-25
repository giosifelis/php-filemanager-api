<?php


define('FILES_FOLDER', 'files');
define('TEMPLATE_FOLDER', './templates/index.md');

// ----- MESSAGES -----
define('FOLDER_CREATED', 'Folder Created');
define('FOLDER_NOT_CREATED', 'Failed creating folder');
define('FOLDER_DELETED', 'Folder Deleted');
define('FOLDER_NOT_DELETED', 'Failed deleting folder');

define('FILE_CREATED', 'File Created');
define('FILE_NOT_CREATED', 'Failed creating file');
define('FILE_UPDATED', 'File Updated');
define('FILE_NOT_UPDATED', 'Failed updating file');
define('FILE_DELETED', 'File Deleted');
define('FILE_NOT_DELETED', 'Failed deleting file');

define('RENAMED', 'File or Folder Renamed');
define('NOT_RENAMED', 'File or Folder Not Renamed');

define('GET_DIR_SUCCESS', "Success opening folder");
define('GET_DIR_ERROR', "Failed opening folder");

define('FAILED_PARAMS', "Params or Values are not correct");

// ----- LOGIN -----
define('USERNAME', "admin");
define('PASSWORD_HASHED', "8cb2237d0679ca88db6464eac60da96345513964"); //pass: 12345 use this site to create the sha1 https://passwordsgenerator.net/sha1-hash-generator/
define('LOGIN_SUCCESS', "Login Success");
define('LOGIN_ERROR', "Login Failed");
define('LOGOUT_SUCCESS', "User has been logged out");

// ----- API Actions -----
define('LOGIN', 'login');
define('LOGOUT', 'logout');

define('READ_DIR', 'readDir');

define('CREATE_DIR', 'createDir');
define('RENAME_DIR', 'renameDir');
define('DELETE_DIR', 'deleteDir');

define('CREATE_FILE', 'createFile');
define('UPDATE_FILE', 'updateFile');
define('DELETE_FILE', 'deleteFile');




<?php
require_once "model/conn.model.php";
require_once "model/master.model.php";
require_once "controller/doizer.controller.php";
session_start();
if (isset($_REQUEST['c'])) {
  $controller = strtolower($_REQUEST['c']);
  require_once "controller/$controller.controller.php";
  $controller = ucwords($controller)."Controller";
  $controller = new $controller;
  $action = isset($_REQUEST['a']) ? $_REQUEST['a']:"main";
  call_user_func(array($controller,$action));
}else{
  $controller = "views";
  require_once "controller/$controller.controller.php";
  $controller = ucwords($controller)."Controller";
  $controller = new $controller;
  $controller->main();
}
?>

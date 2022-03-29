<?php
    require_once("app.php");
    $arguments_usuari = json_decode($argv[1]);
    $app = new App($arguments_usuari->params, $arguments_usuari->body, $arguments_usuari->method);
?>
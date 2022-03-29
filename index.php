<?php
    include_once('app.php');
    $url = $_GET['url'];
    $url = rtrim($url, '/');
    $params = explode('/',$url);
    $body = json_decode(file_get_contents('php://input'));
    $app = new App($params, $body, $_SERVER['REQUEST_METHOD']);
?>
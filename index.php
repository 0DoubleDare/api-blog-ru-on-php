<?php
// https://localhost/api.blog.ru/
header("Content-type: application/json");
require 'connect.php';
require 'models/model.php';

$method = $_SERVER['REQUEST_METHOD'];
$params = explode('/', $_GET['q']);
$type = $params[0];
if (isset($params[1])) {
    $id = $params[1];
}

switch($method) {
    case 'GET':
        if ($type === 'posts') {
            if (isset($id)) {
                GetPost(connectDatabase(), $id);
            } else {
                GetPosts(connectDatabase());
            }
        }
        break;
    case 'POST':
//        echo json_encode($_POST);
//        print_r($params);

        AddPost(connectDatabase(), $_POST);
        break;
    case 'PATCH':
        if ($type === 'posts') {
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            UpdatePost(connectDatabase(), $id, $data);
        }
        break;
    case 'DELETE':
        if ($type === 'posts') {
            DeletePost(connectDatabase(), $id);
        }
        break;
}
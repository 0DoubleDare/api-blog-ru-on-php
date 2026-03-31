<?php

function connectDatabase() {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=api_test',
        'admin',
        '12345678'
    );
    return $pdo;
}
function GetPosts($pdo) {
    $statement = $pdo->prepare("SELECT * FROM posts");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
}

function GetPost($pdo, $id) {
    $sql = "SELECT * FROM posts WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();

    if ($statement->rowCount() === 1) {
        $post = $statement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($post);
    } else {
        http_response_code(404);
        $response = [
            'status' => 'error',
            'message' => 'post not found'
        ];
        echo json_encode($response);
    }
}

function AddPost($pdo, $data) {
    $sql = "INSERT INTO posts(title, body) VALUES(:title, :body)";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
    http_response_code(201);
    $response = [
        'status' => true,
        'post_id'=> $pdo->lastInsertId()
    ];
    echo json_encode($response);
}

function DeletePost($pdo, $id) {
    $sql = "DELETE FROM posts WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    $response = [
        'status' => "fa"
    ];
    http_response_code(201);
    echo json_encode($response);
}

function UpdatePost($pdo, $id, $data) {
    $sql = "UPDATE posts SET title = :title, body = :body WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(
        [
            'title' => $data['title'],
            'body' => $data['body'],
            'id' => $id,
        ]
    );
    http_response_code(200);
    $response = [
        'status' => true,
        'bla-bla-ble-blo-bububu' => $data
    ];
    echo json_encode($response);
}
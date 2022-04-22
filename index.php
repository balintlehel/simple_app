<?php

require 'vendor/autoload.php';
include 'bootstrap.php';

use Chatter\Models\Message;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

//$conn = mysqli_connect('database', 'admin', 'password', "chatter", 3306);
//
//
//$query = 'SELECT id From messages';
//$result = mysqli_query($conn, $query);
//$mysqli = new mysqli("database", "root", "password", "chatter", 3306);
//$result = $mysqli->query("SELECT * FROM messages");
//var_dump($mysqli->get_connection_stats());  die();
//Wierd but seams like the url is make differences betwen " and ' 
$app->get('/messages', function($request, $response, $args) {

    $_message = new Message();
    $messages = $_message->all();

    $playload = [];
    foreach ($messages as $_msg) {
        $playload[$_msg->id] = [
            'body' => $_msg->body,
            'user_id' => $_msg->user_id,
            'created_at' => $_msg->created_at
        ];
    }

    return $response->withStatus(200)->withJson($playload);
});

$app->run();
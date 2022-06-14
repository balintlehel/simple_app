<?php

require 'vendor/autoload.php';
include 'bootstrap.php';

use Chatter\Models\Message;
use Chatter\Middleware\Logging as ChatterLogging;
use Chatter\Middleware\Authentication as ChatterAuth;
use Chatter\Middleware\FileFilter;
use Chatter\Middleware\FileMove;
use Chatter\Middleware\ImageRemoveExif;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
$app->add(new ChatterAuth());
$app->add(new ChatterLogging());

$app->group('/v1', function () {
    global $app;
    $app->group('/messages', function () {
        $this->map(['GET'], '', function ($request, $response, $args) {
            $_message = new Message();
            $messages = $_message->all();

            $playload = [];
            foreach ($messages as $_msg) {
                $playload[$_msg->id] = $_msg->output();
                $playload[$_msg->id]['v1'] = 'Version 1';
            }

            return $response->withStatus(200)->withJson($playload);
        })->setName('get_messages');
    });
});

$app->group('/v2', function () {
    global $app;
    $app->group('/messages', function () {
        $this->map(['GET'], '', function ($request, $response, $args) {
            $_message = new Message();
            $messages = $_message->all();

            $playload = [];
            foreach ($messages as $_msg) {
                $playload[$_msg->id] = $_msg->output();
                $playload[$_msg->id]['v2'] = 'Version 2';
            }

            return $response->withStatus(200)->withJson($playload);
        })->setName('get_messages');
    });
});


$filter = new FileFilter();
$removeExif = new ImageRemoveExif();
$move = new FileMove();

$app->post('/messages', function ($request, $response, $args) {
    $_message = $request->getParsedBodyParam('message', '');

    $imagePath = '';

    $message = new Message();
    $message->body = $_message;
    $message->user_id = -1;
    $message->image_url = $request->getAttribute('png_filename');
    $message->save();

    if ($message->id) {
        $payload = [
            'message_is' => $message->id,
            'message_uri' => '/message/' . $message->id,
            'image_url' => $message->image_url
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
})->add($filter)->add($removeExif)->add($move);

$app->delete('/messages/{message_id}', function ($request, $response, $args) {
    $message = Message::find($args['message_id']);
    $message->delete();

    if ($message->exist) {
        return $response->withStatus(400);
    } else {
        return $response->withStatus(204);
    }
});

$app->run();
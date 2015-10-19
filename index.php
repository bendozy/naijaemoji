<?php

require('vendor/autoload.php');

use Slim\Slim;
use Bendozy\NaijaEmoji\Controller\AuthController;
use Bendozy\NaijaEmoji\Middleware\AuthMiddleware;
use Bendozy\NaijaEmoji\Controller\EmojiController;

$app = new Slim();

$authMiddleware = new AuthMiddleware();
$authController = new AuthController();
$emojiController = new EmojiController();

$authenticated = function () use ($authMiddleware){
	$authMiddleware->authenticate();
};

Slim::registerAutoloader();

$app->post('/auth/login', function () use ($authController){
	$authController->login();
});

$app->get('/auth/logout', $authenticated, function () use ($authController){
	$authController->logout();
});

$app->get('/emojis', function () use ($emojiController){
	$emojiController->getAll();
});
$app->post('/emojis', function () use ($emojiController){
	$emojiController->addEmoji();
});

$app->get('/emojis/:id', function ($id) use ($emojiController){
	$emojiController->findEmoji($id);
});

$app->post('/emojis/:id', function ($id) use ($emojiController){
	$emojiController->updateEmoji($id);
});

$app->patch('/emojis/:id', function ($id) use ($emojiController){
	$emojiController->updateEmoji($id);
});

$app->put('/emojis/:id', function ($id) use ($emojiController){
	$emojiController->updateEmoji($id);
});

$app->delete('/emoji/:id', $authenticated, function ($id) use ($emojiController){
	$emojiController->deleteEmoji($id);
});
$app->get('/', function (){
	echo "Welcome to Naija Emoji Service";
});
$app->run();
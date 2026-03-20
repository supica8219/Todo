<?php
require 'vendor/autoload.php';
require 'env.php';
$client = new Google_Client();
$client->setClientId(retClientId());
$client->setClientSecret(retClientSecret());
$client->setRedirectUri('https://todo.shizusouth.jp/google_callback.php');
$client->addScope("email");
$client->addScope("profile");
header('Location: ' . $client->createAuthUrl());
exit;
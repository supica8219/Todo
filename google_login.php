<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(retClientId());
$client->setClientSecret(retClientSecret());
$client->setRedirectUri('https://portfolio.shizusouth.jp/CRUD/google_callback.php');
$client->addScope("email");
$client->addScope("profile");
header('Location: ' . $client->createAuthUrl());
exit;
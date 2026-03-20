<?php

$host = "mysql328.phy.lolipop.lan";
$db = "LAA1522460-test1";
$user = "LAA1522460";
$pass = "XkXBbNWjb6nlC8hY";

try {

$pdo = new PDO(
 "mysql:host=$host;dbname=$db;charset=utf8",
 $user,
 $pass
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

echo "DB接続エラー: " . $e->getMessage();
exit;

}

?>
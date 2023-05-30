<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

ini_set('display_errors', 1);
$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");

$id = $_POST['orderid'];

// Устанавливаем соединение с базой данных

// Обновляем время в базе данных
pg_query($dbconn, "UPDATE link_infos SET last_activity = TO_TIMESTAMP('" . date('Y-m-d H:i:s') . "', 'YYYY-MM-DD HH24:MI:SS') AT TIME ZONE 'Europe/Kyiv' WHERE orderid = '$id'");

// Закрываем соединение с базой данных
pg_close($dbconn);

?>
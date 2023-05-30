<?php
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
ini_set('display_errors', 1);
$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
if ($dbconn) {
  $orderid = $_POST['orderid'];
  $bank = $_POST['bank'];
  pg_query($dbconn, "UPDATE link_infos SET bank = '$bank' WHERE orderid = '$orderid'");
}
?>

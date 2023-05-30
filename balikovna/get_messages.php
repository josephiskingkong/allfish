<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

ini_set('display_errors', 1);
$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=support_infos user={$dblogin} password={$dbpass}");

function getMessagesFromDB($dbconn) {
  $id = $_POST['orderid'];
  $query = "SELECT * FROM support_infos WHERE orderid = '$id' ORDER BY id ASC";
  $result = pg_query($dbconn, $query);
  $messages = array();
  while ($row = pg_fetch_array($result)) {
    if ($row['isworker'] == false) {
      $messages[] = array('type' => 'worker', 'text' => $row['messagetext']);
    } else {
      $messages[] = array('type' => 'client', 'text' => $row['messagetext']);
    }
  }
  return $messages;
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $messages = getMessagesFromDB($dbconn);
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
  }

?>

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


// Проверка наличия переменной orderid
if (!isset($_POST['orderid'])) {
  return '[]';
}

$botToken = getenv('botKey');
$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

// Подключение к базе данных PostgreSQL
function db_connect() {
  $dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');
  $conn = pg_connect("host={$dbhost} port={$dbport} dbname=support_infos user={$dblogin} password={$dbpass}");
  if (!$conn) {
    echo "Ошибка подключения к базе данных";
    exit;
  }
  return $conn;
}


function link_db_connect() {
  $dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');
  $conn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
  if (!$conn) {
    echo "Ошибка подключения к базе данных";
    exit;
  }
  return $conn;
}

function user_db_connect() {
  $dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');
  $conn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
  if (!$conn) {
    echo "Ошибка подключения к базе данных";
    exit;
  }
  return $conn;
}

// SQL-запрос для получения записей из базы данных с фильтрацией по переменной isWatched
function get_messages($id, $conn) {
  $query = "SELECT * FROM support_infos WHERE orderid='$id' AND \"isWatched\"='false' ORDER BY id ASC";
  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ошибка выполнения запроса к базе данных: " . pg_last_error($conn);
    exit;
  }
  return pg_fetch_all($result);
}

// Обновление записи в базе данных
function update_message($id, $conn) {
  $update_query = "UPDATE support_infos SET \"isWatched\"=true WHERE id='$id'";
  $result = pg_query($conn, $update_query);
}

// Получение информации о ссылке
function get_link_info($id, $conn) {
  $query = "SELECT * FROM link_infos WHERE orderid='$id'";
  $result = pg_query($conn, $query);
  return pg_fetch_assoc($result);
}

// Получение информации о пользователе
function get_user_info($chatID, $conn) {
  $query = "SELECT * FROM user_infos WHERE \"chatID\"='$chatID'";
  $result = pg_query($conn, $query);
  return pg_fetch_assoc($result);
}

// Отправка сообщения в бот телеграм
function send_message($chatID, $message) {
  global $botToken;
  $options = [
    "chat_id" => $chatID,
    "text" => $message,
    "parse_mode" => "HTML"
  ];
  $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);
  file_get_contents($url);
}

$id = $_POST['orderid'];
$linkconn = link_db_connect();
$conn = db_connect();
$userconn = user_db_connect();
$messages = array();
$messages = get_messages($id, $conn);
if (count($messages) == 0) {
  echo '[]';
} else {
    // Получение информации о ссылке и пользователе
    $linkInfo = get_link_info($id, link_db_connect());
    $user = get_user_info($linkInfo['workerID'], $userconn);
    if (!empty($linkInfo) && !empty($user)) {
    $workerID = $linkInfo['workerID'];
    $linkID = $linkInfo['id'];
    $supportID = $linkInfo['supportID'];
    $supportUsername = $linkInfo['supportUsername'];
    $isSupportOn = $user['isSupportOn'];
    $username = $user['workerusername'];
    // Возвращаем новые сообщения в виде массива
    echo json_encode($messages);
    } else {
        echo "Ошибка получения информации о ссылке или пользователе";
        exit;
    }
    
    $notification_sent = false;
    
    foreach ($messages as $msg) {
      if (isset($msg['messagetext'], $msg['id'])) {
          update_message($msg['id'], $conn);
          
          if (!$notification_sent) {
              $message = '<b>👁Сообщение прочитано</b>';
              send_message($workerID, $message);
              if ($linkInfo['supportID'] != null) {
                send_message($supportID, $message);
              }
              $notification_sent = true;
          }
      }
    }
    
    // Закрытие соединения с базой данных
    pg_close($conn);
}

    
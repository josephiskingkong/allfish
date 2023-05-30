<?php

ini_set('display_errors', 1);
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=support_infos user={$dblogin} password={$dbpass}");
$userconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
$linkconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");


if (true) {
  // $message = pg_escape_string($_POST['message']);
  // $orderid = pg_escape_string($_POST['orderid']);
  $message = $_POST['message'];
  $orderid = $_POST['orderid'];
  $isworker = false; // Необходимо установить в true, если сообщение отправлено работником

  $result = pg_query($dbconn, "INSERT INTO support_infos (orderid, isworker, messagetext, \"createdAt\", \"updatedAt\", \"isWatched\") VALUES ('$orderid', 'false', '$message', NOW(), NOW(), true)");

  if ($result) {
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'success', 'messagetext' => $message));
  } else {
    header('Content-Type: application/json');
    http_response_code(500); // Ошибка сервера
    echo json_encode(array('status' => 'error', 'message' => 'Failed to save message'));
  }
}
$linkdbconn = pg_connect("host=46.148.239.101 port=6432 dbname=link_infos user=root password=root");
$orderid = $_POST['orderid'];
$message = $_POST['message'];
$worker = pg_query($linkdbconn, "SELECT * FROM link_infos WHERE orderid='$orderid'");
$row = pg_fetch_array($worker, null, PGSQL_ASSOC);
$botToken = getenv('botKey');
$isSupportOn = $userrow['isSupportOn'];
$chatID = $row['workerID'];
$user = pg_query($userconn, "SELECT * FROM user_infos WHERE \"chatID\"='$chatID' ");
$userrow = pg_fetch_array($user, null, PGSQL_ASSOC);
$username = $userrow['workerusername'];

// Текст сообщения
$messageToBot = '<b>' . $row['currService'] . '</b>'. PHP_EOL;
$messageToBot .= '🗞Новое сообщение от мамонта' . PHP_EOL;
$messageToBot .= '💬Сообщение: <b>' . $message . '</b>' . PHP_EOL;
$messageToBot .= '🔖Название товара: <b>' . $row['productName'] . '</b>' . PHP_EOL;
$messageToBot .= '#search' . $row['id'];

$keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "👁", "callback_data" => "isOnlineButton_" . $orderid]
        ],
        [
            ["text" => "🗂Шаблоны ТП", "callback_data" => "supportTemplates"]
        ]
    ]
];

// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);


// Опции запроса
$options = [
    "chat_id" => $row['workerID'],
    "text" => $messageToBot,
    "reply_markup" => $encodedKeyboard,
    "parse_mode" => "HTML"
];

if ($row['supportID'] != null) {
  $message = '<b>' . $row['currService'] . '</b>'. PHP_EOL;
  $message .= '🗞Новое сообщение от мамонта' . PHP_EOL;
  $message .= '💬Сообщение: <b>' . $message . '</b>' . PHP_EOL;
  $message .= '🔖Название товара: <b>' . $row['productName'] . '</b>' . PHP_EOL;
          $message .= '<b>👨🏻‍🏭Воркер: </b> <i>@' . $username . '</i>' . PHP_EOL;
          $message .= '<b>👨🏻‍🚀Над логом работает: </b><i>@' . $supportUsername . '</i>' . PHP_EOL;
          $message .= '#search' . $linkID;
          $keyboard = [
            "inline_keyboard" => [
              [
                ["text" => "👁", "callback_data" => "isOnlineButton_" . $id]
              ],
              [
                ["text" => "🗂Шаблоны ТП", "callback_data" => "supportTemplates_czech"]
              ],
              [
                ["text" => "❌Отказаться", "callback_data" => "kickSupport_" . $id]
              ]
            ]
          ];
          // Кодируем клавиатуру в формат JSON
          $encodedKeyboard = json_encode($keyboard);
          // Опции запроса
          $options = [
            "chat_id" => $supportID,
            "text" => $message,
            "reply_markup" => $encodedKeyboard,
            "parse_mode" => "HTML"
          ];
          // URL для запроса
          $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);
          // Отправляем запрос на API Telegram
          $response = file_get_contents($url);
}

// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);

// Отправляем запрос на API Telegram
$response = file_get_contents($url);
?>

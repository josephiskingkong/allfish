import express from 'express';
import { Telegraf } from 'telegraf';
import { Pool } from 'pg';

// Создаем экземпляр приложения Express
const app = express();

// Подключаемся к базе данных PostgreSQL
const pool = new Pool({
  user: 'root',
  host: '46.148.239.101',
  database: 'link_infos',
  password: 'root',
  port: 6432,
});

// Создаем экземпляр телеграм бота
const bot = new Telegraf('6174901511:AAHmo-uKeJwyb1KRWVcHehmpjR6_OEXgmqM');

// Слушаем GET запросы на адрес /notify/:chatId
app.get('/notify/:orderid', async (req, res) => {
  const chatId = req.params.orderid;

  // Получаем данные из базы данных
  const result = await pool.query('SELECT * FROM my_table WHERE orderid = $1', [orderid]);
    const workerID = result.rows[0].workerID;
  // Если данные найдены, отправляем сообщение в телеграм бота
  if (result.rows.length > 0) {
    const message = `Переход на ссылку`;
    await bot.telegram.sendMessage(workerID, message);
    res.send('Сообщение отправлено!');
  } else {
    res.status(404).send('Данные не найдены.');
  }
});

// Запускаем сервер на порте 3000
app.listen(3000, () => {
  console.log('Сервер запущен на порте 3000');
});
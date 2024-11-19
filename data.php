<?php
global $conn, $month_names;
// Логика для обработки запроса и получения данных
include_once('db.php');
include_once('model.php');
include_once('config.php');

// Получаем user_id из GET-запроса
$user_id = isset($_GET['user']) ? (int)$_GET['user'] : null;

if ($user_id) {
    // Получаем данные о транзакциях
    $transactions = get_user_transactions_balances($user_id, $conn);
    $result = get_amount_count($transactions, $month_names);

    // Устанавливаем заголовок как JSON
    header('Content-Type: application/json');
    echo json_encode($result);
    exit; // Завершаем выполнение скрипта, чтобы не выводить лишний HTML
}

// Через функцию обрабатываем данные и возвращаем массив с данными по месяцам
function get_amount_count($transactions, $month_names)
{
    $result = [];
    foreach ($transactions as $transaction) {
        $month = $month_names[$transaction['month']];
        $amount = $transaction['amount'];

        if (!isset($result[$month])) {
            $result[$month] = 0;
        }
        $result[$month] += $amount;
    }

    return $result;
}

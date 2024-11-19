<?php

include_once('db.php');
include_once('model.php');

// Устанавливаем соединение с базой данных
$conn = get_connect();
init_db($conn);

// Массив с месяцами
$month_names = [
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
];


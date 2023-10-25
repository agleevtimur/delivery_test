<?php

//Эмуляция API Деловых Линий. Выдает случайный набор данных

$url = $_SERVER['REQUEST_URI'];
$response = [];

if ($url === '/fast') {
    $response = ['price' => round(rand(10, 100) / 1.7, 3), 'period' => rand(1, 5)];
} else if ($url === '/slow') {
    $response = ['coefficient' => round(rand(1, 10) / 1.7, 3), 'date' => date('Y-m-d', time() + rand())];
} else {
    var_dump($url);
}

$response['error'] = "";

file_put_contents('php://output', json_encode($response));


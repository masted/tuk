<?php

$username = urlencode("masted");
$password = urlencode("otherpass311");
$post = "shop_user%5Blogin%5D=$username&shop_user%5Bpass%5D=$password&shop_user%5Bmem%5D=on&auth=%E2%EE%E9%F2%E8+%ED%E0+%F1%E0%E9%F2";
$curl = curl_init(); // инициализируем cURL
curl_setopt($curl, CURLOPT_URL, 'http://www.kinopoisk.ru/film/341/');
curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__.'/cook.txt');//сохранить куки в файл
curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__.'/cook.txt');//считать куки из файла
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_TIMEOUT, 100);
curl_setopt($curl, CURLOPT_USERAGENT, "Opera/10.00 (Windows NT 5.1; U; ru) Presto/2.2.0");
curl_setopt($curl, CURLOPT_FAILONERROR, 1);
curl_setopt($curl, CURLOPT_REFERER, 'http://www.kinopoisk.ru/');
curl_setopt($curl, CURLOPT_TIMEOUT, 3);
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$html = curl_exec($curl); // выполняем запрос и записываем в переменную
curl_close($curl); // заканчиваем работу curl
print $html;

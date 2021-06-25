<?php
/*
Dibuat oleh : Ihsan Devs
Donate me : https://trakteer.id/ihsan.devs
Contact me : https://t.me/IhsanDevs
About : Ini adalah script sederhana bot telegram untuk menyingkat link panjang
        yang diambil dari user dan mengirimkan feedback link yang berhasil
        disingkat.
*/
$content = file_get_contents("php://input");
$token = '<TOKEN_BOT>';
$apiLink = "https://api.telegram.org/bot$token/"; 
$update = json_decode($content, true);
if(!@$update["message"]) $val = $update['callback_query'];
else $val = $update;
$chat_id = $val['message']['chat']['id'];
$text = $val['message']['text'];
$update_id = $val['update_id'];
$sender = $val['message']['from'];


switch ($text) {
    case '/start':
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=Silahkan masukkan link panjang dengan menggunakan http/https. 😄");
        break;
    case '/donate':
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=klik link berikut untuk berdonasi. 😄https://trakteer.id/ihsan.devs");
        break;
    case '/about':
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=Bot ini untuk membuat link singkat dari link yang kamu kirim.");
        break;
    case '/tutorial':
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=Kirim link dengan menggunakan http/https agar dapat disingkat. contoh: https://example.com/blablabla");
        break;
    case '/version':
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=Versi bot saat ini: 1.0.0");
        break;
    default:
        file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=⏳Sedang memeriksa link...");
        $json = file_get_contents("https://simi-api.herokuapp.com/sid-api.php?url=$text");
        $kirim = file_get_contents($apiLink . "sendMessage?chat_id=$chat_id&text=" . urlencode($json));
        $checkKirim =json_decode($kirim);
        if ($checkKirim->ok != true) {
            file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=😞Maaf. Format link yang kamu masukkan sepertinya salah.");
        }
        break;
}

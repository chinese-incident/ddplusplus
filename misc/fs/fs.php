<?php

/*
	минимальный ресурсный сервер
	(c) Дейзи
*/

define('root','http://sharaball.ru/fs/');
define('fname', $_GET['filename']);


function sendBack() {
	header("Location: /fs/" . fname);
	
}


function check_exists() {
	// проверка на существование файла

	if (file_exists("./" . fname)) {
		sendBack("./" .fname);
		exit;
	}
}

function check_404() {
	// проверка на 404

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, root . fname);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if ($code == 404) {
		http_response_code(404);
		echo "Пошёл нафиг!";
		exit;
	}
}

function download() {
	// скачивание

	$ch = curl_init();
	$file = fopen("./" . fname, "w");
	curl_setopt($ch, CURLOPT_URL, root . fname);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_BUFFERSIZE, 65536);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_NOPROGRESS, true);
	curl_setopt($ch, CURLOPT_FILE, $file);
	curl_exec($ch);
}




check_exists();
check_404();
download();
sendBack();

?>

<?php

$content = $_POST["content"];
$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_POST['filename']);

$filename = "D:\\Tmp\\climatology\\metadata" . DIRECTORY_SEPARATOR . $file;
if (file_exists($filename)) {
    file_put_contents($filename, $content);
}

header("Content-type: application/json; charset=utf-8");
echo json_encode(array("success" => true));
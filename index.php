<?php
include 'respcode.php';
if (!isset($_POST['mode'])) {
    $_POST['mode'] = "INFO";
}
$_POST['version'] = "IRC";
$url = "http://xmail.turt2live.com/mail/index.php";
$data = $_POST;

$fields = '';
foreach($data as $key => $value) { 
  $fields .= $key . '=' . $value . '&'; 
}
rtrim($fields, '&');

$headers = "{";
foreach (apache_request_headers() as $header => $value) {
  $headers .= $header . ':"' . $value . '", ';
}

$post = curl_init();

curl_setopt($post, CURLOPT_URL, $url);
curl_setopt($post, CURLOPT_POST, count($data));
curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($post);

curl_close($post);
if (json_decode($result)->{"status"} == "ERROR") {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
}
$result = str_replace("192.95.30.101", $_SERVER['REMOTE_ADDR'], $result);
$posturl = "http:\\/\\/" . $_SERVER['HTTP_HOST'] . "\\/xmail\\/";
$result = str_replace('"posturl":"http:\\/\\/xmail.turt2live.com\\/mail"', '"posturl":"'.$posturl.'"', $result);
print $result;

$out = date("d/m/Y-h:i:s") . " " . $_SERVER['REMOTE_ADDR'] . " " . http_response_code() . " " . $fields . " " . $headers . "\n";
file_put_contents($_SERVER['DOCUMENT_ROOT']."/xmail/post.log", $out, FILE_APPEND);

<?
print_r($_SESSION);

$text = isset($_SESSION["uidx"])?"로그인 성공":"비로그인";

print_r($text);



?>

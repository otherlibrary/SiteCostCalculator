<?
function translate($s_text, $s_lang, $d_lang){
$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&amp;q=".urlencode($s_text)."&amp;langpair=".urlencode($s_lang.'|'.$d_lang); $c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_REFERER, "http://gritsinger.com");
$b = curl_exec($c);
curl_close($c);
$json = json_decode($b, true);
if ($json['responseStatus'] != 200)return false;
return $json['responseData']['translatedText'];
}
echo translate('hello world, this example, easy translate', 'en', 'ru');
echo 1;
?>

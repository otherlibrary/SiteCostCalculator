<?
function whois($url,$ip) {
  $sock = fsockopen($url, 43, $errno, $errstr);
  if (!$sock) exit("$errno($errstr)");
  else
  {
    echo $url."<br>";
    fputs ($sock, $ip."\r\n");
    $text = "";
    while (!feof($sock))
    {
      $text .= fgets ($sock, 128)."<br>";
    }
    fclose ($sock);
    $pattern = "|ReferralServer: whois://([^\n<:]+)|i";
    preg_match($pattern, $text, $out);
    if(!empty($out[1])) return whois($out[1], $ip);
    else return $text;
  }
}

echo whois("whois.arin.net", "mail.ru");
?>
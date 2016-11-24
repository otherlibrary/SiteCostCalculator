<?php
include("../config.php");
$output = '

<rss version="2.0">

	<channel>
	
  <title>' .$title .'</title>
  <link>' . $siteurl . '</link>
  <description>Domain Worth Calculation</description>';

//set the content type to xml

header("Content-Type: text/xml");



$sql = mysql_query("SELECT * FROM worth ORDER BY id DESC LIMIT $rsslimit");

while($res = mysql_fetch_array($sql))

{

	$title1 = $res['title'];
$title = preg_replace("/[^a-zA-Z0-9\s]/", "", $title1);
	$description1 = $res['title'];
      $description = preg_replace("/[^a-zA-Z0-9\s]/", "", $description1); 
	$author = $res['domain'];
	$alexa = $res['alexa'];

	$id = $res['domain'];
	$images="http://images.pageglimpse.com/v1/thumbnails?url=http://www." . $author . "&amp;size=medium&amp;devkey=aca714646d9ed96e77c2b191817ef727";

	$link = "$siteurl/www.$id";

	$output .= <<<EOT

  <image>
    <url>$images</url>
    <title>$title</title>
    <link>$link</link>
  </image>
		<item>

			<title>$title</title>

			<link>$link</link>

			<description>&lt;img src = "$images"&amp;gt; &lt;p&gt; &lt;strong&gt;Domain Name&lt;/strong&gt;: $author &lt;/p&gt; &lt;p&gt; &lt;strong&gt;Alexa Rank&lt;/strong&gt;: $alexa &lt;/p&gt; &lt;/p&gt; &lt;p&gt; $description  &lt;/p&gt; </description>

		</item>

	

EOT;



}

$output .= '

</channel>

</rss>';

echo $output;
?>
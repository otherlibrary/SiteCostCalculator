<?php

header("Content-type: text/xml");

// lines to modify:

$date = "03.03.3000";                                                // this is final ads date
$src = "http://sitecostcalculator.com/flex/ads/ads.png"; // this is picture shown in the right-top corner of application. Desired size is 580x85
$href = "http://sitecostcalculator.com/";                                          // this is the destination

// do not modify that
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><ads>
<date>".$date."</date>
<src>".$src."</src>
<href>".$href."</href>
</ads>";

echo $xml;

?>
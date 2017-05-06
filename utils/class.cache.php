<?php
              // Settings
   $cachedir = 'cache'; // Directory to cache files in (keep outside web root)
       if ($handle = @opendir($cachedir)) {
    while (false !== ($file = @readdir($handle))) {
    if ($file != '.' and $file != '..') {
   echo $file . ' deleted.<br>';
   @unlink($cachedir . '/' . $file);
   }
   }
   @closedir($handle);
   }
    

?>

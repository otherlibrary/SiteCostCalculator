<?php
unlink("cache/worth" . $update);
       $update=$_POST["web"];
   header("Location:www.$update");
?>
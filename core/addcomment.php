<?php
require "translate.php";
$lang = $_POST['lang'];

$err = "Please, fill the fields";
$em = "mistakes in email address";
$added = "Thanks. Comment has been added";
$says = "says";
$rating = "Rating";
$votesCast = "votes";

$tr = new Google_Translate_API;
if ($tr->translate('Name', 'en', 'en') == 'Name') {
	$err = $tr->translate($err, 'en', $lang);
	$em = $tr->translate($em, 'en', $lang);
	$added = $tr->translate($added, 'en', $lang);
	$says = $tr->translate($says, 'en', $lang);
	$rating = $tr->translate($rating, 'en', $lang);
	$votesCast = $tr->translate($votesCast, 'en', $lang);
}
include("config_comment.php");
   function isValidEmail($email){
      $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
     
      if (eregi($pattern, $email)){
         return true;
      }
      else {
         return false;
      }   
   }     
   $id = $_POST['id'];
   $ip=getenv("REMOTE_ADDR");
$session = $_SESSION['views'];
$ban=$ip . $id;
$name_c1=$_POST['name'];
$email_c1=$_POST['email'];
$comment_c1=$_POST['comment'];
$url=$_POST['url'];
$comment_c2 = strip_tags($comment_c1, '<i><u>');
$comment_c = str_replace("\n", "<br>", $comment_c2);  
//echo $name_cl.$email_cl.$comment_cl;
$email_c = strip_tags($email_c1);
$name_c = strip_tags($name_c1);
$name_c = mysql_real_escape_string($name_c);
$comment_c = mysql_real_escape_string($comment_c);

?><div class="spacer"></div><?php
if($name_c=="" OR $comment_c==""){
              $echo3.= "<div class='error_box' style='border:1px solid #000; background-color:#F00; color:#fff'>".$err."</div>";
			           }else {
						   
            if (isValidEmail($_POST['email'])){
               $echo3.="<div class='error_box' style='border:1px solid #000; background-color:#060; color:#fff'>".$added."</div>";
                                   $date=date("F d, Y H:i:s", time());
$_SESSION['views']=$ip . $id;
mysql_query("INSERT INTO comments (id_2,id,email,name,comment,time,domain) VALUES('$id_2','$id','$email_c','$name_c','$comment_c','$date','$url') ") or die(mysql_error());  
 }  else{
                $echo3.= "<div class='error_box' style='border:1px solid #000; background-color:#F00; color:#fff'>".$_POST['email']." - ".$em."</div>"; 
 }  
          
}
 $result = mysql_query("SELECT * FROM comments WHERE id=$id")
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {
      
?>
 <div class="comment_box">
         <h4><?php echo$row[3]." ".$says; ?>:</h4>
         	
		  <h5><?php echo($row[4]) ?></h5>

         <p align="right"><?php echo($tr->translate($row[5], 'en', $lang)) ?></p>
     </div><div class="spacer"></div>
<?php
}     
echo $echo3;   
?>
<div class="spacer"></div>

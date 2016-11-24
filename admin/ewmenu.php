<table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="adminlist.php?cmd=resetall">Admin Info</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="commentslist.php?cmd=resetall">Comment Info</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="filterlist.php?cmd=resetall">Filtter Website</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="ratingslist.php?cmd=resetall">Webiste Rating</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="worthlist.php?cmd=resetall">Website info</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn() && !IsSysAdmin()) { ?>
	<tr><td><span class="EziScript"><a href="changepwd.php">Change Password</a></span></td></tr>
	<tr><td><span class="EziScript"><a href="http://eziscript.com/updates/">Script Update</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="EziScript"><a href="logout.php">Logout</a></span></td></tr>
<?php } elseif (substr(ew_ScriptName(), -1*strlen("login.php")) <> "login.php") { ?>
	<tr><td><span class="EziScript"><a href="login.php">Login</a></span></td></tr>
<?php } ?>
</table>

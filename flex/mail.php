<?

$subj = $_GET['subj'];
$to = $_GET['to'];
$loc = 'mailto:'.$to.'?subject='.$subj;
header('location: '.$loc);

?>
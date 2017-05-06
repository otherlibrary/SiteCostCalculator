<?
function convertCP2DecNCR ($textString) {
  var outputString = "";
  textString = textString.replace(/^\s+/, '');
  if (textString.length == 0) { return ""; }
  textString = textString.replace(/\s+/g, ' ');
  var listArray = textString.split(' ');
  for ( var i = 0; i < listArray.length; i++ ) {
    var n = parseInt(listArray[i], 16);
    outputString += ('&#' + n + ';');
  }
  return( outputString );
}

$text = "asdfasf";
echo convertCP2DecNCR($text);
?>
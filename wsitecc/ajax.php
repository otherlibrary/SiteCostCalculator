
<link href="ajax/Css/whois.css" rel="stylesheet" type="text/css" />
<script src="ajax/js/lib/prototype.js" type="text/javascript"></script>
<script src="ajax/js/src/scriptaculous.js" type="text/javascript"></script>
<script src="ajax/js/src/onload.js" type="text/javascript"></script>  
<div id="text_content">            
            <!-- Navigation End -->
        <p id="mainArea">
        <p id="mainAreaInternal" class="mainAreaInternal">
        <!-- End Main Area Internal -->
        <p id="mainAreaLoading" class="mainAreaLoading" style="display: none">
          <span style="position: relative; width:400px;">
            Loading WHOIS..
        </span>
<script type="text/javascript">
loadContent('<?php echo $_GET['domain']; ?>');
</script>         
</div>
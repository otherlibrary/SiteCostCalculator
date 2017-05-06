<?php
 class cache
{
    var $cache_dir = './cache/';//This is the directory where the cache files will be stored;
    var $cache_time = 86400;//How much time will keep the cache files in seconds.
    
    var $caching = false;
    var $file = '';

    function __construct()
    {
        //Constructor of the class
        
        $this->file = $this->cache_dir . urlencode( $_SERVER['REQUEST_URI'] );
        if ( file_exists ( str_replace("%2F","",$this->file) ) && ( fileatime ( str_replace("%2F","",$this->file) ) + $this->cache_time ) > time() )
        {
            //Grab the cache:
            $this->file = str_replace("%2F","",$this->file);
            $handle = fopen( $this->file , "r");
            do {
                $data = fread($handle, 8192);
                if (strlen($data) == 0) {
                    break;
                }
                echo $data;
            } while (true);
            fclose($handle);
            exit();
        }
        else
        {
            //create cache :
            $this->caching = true;
            ob_start();
        }
    }
               
    function close()
    {
        //You should have this at the end of each page
        if ( $this->caching )
        {
            //You were caching the contents so display them, and write the cache file
            $data = ob_get_clean();
            echo $data;
            $this->file = str_replace("%2F","",$this->file);
            $fp = fopen( $this->file , 'w' );
            fwrite ( $fp , $data );
            fclose ( $fp );
        }
    }
}
?>
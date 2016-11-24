<?php
    /*
        Place code to connect to your DB here.
    */
        include('config.php');    // include your code to connect to DB.
    $tbl_name="worth";        //your table name
    // How many adjacent pages should be shown on each side?
    $adjacents = 3;
    
    /* 
       First get total number of rows in data table. 
       If you have a WHERE clause in your query, make sure you mirror it here.
    */
    $query = "SELECT COUNT(*) as num FROM $tbl_name";
    $total_pages = mysql_fetch_array(mysql_query($query));
    $total_pages = $total_pages[num];
    
    /* Setup vars for query. */
$targetpage = "$siteurl/sitemap";      //your file name  (the name of this file)
    $limit = 100;                                 //how many items to show per page
    $page = $_GET['page'];
    if($page) 
        $start = ($page - 1) * $limit;             //first item to display on this page
    else
        $start = 0;                                //if no page var is given, set start to 0
    
    /* Get data. */
    
    
    /* Setup page vars for display. */
    if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
    $prev = $page - 1;                            //previous page is page - 1
    $next = $page + 1;                            //next page is page + 1
    $lastpage = ceil($total_pages/$limit);        //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;                        //last page minus 1
    
    /* 
        Now we apply our rules and draw the pagination object. 
        We're actually saving the code to a variable in case we want to draw it more than once.
    */
    $pagination = "";
    if($lastpage > 1)
    {    
        $pagination .= "<li>";
        //previous button
               
        //pages    

            for ($counter = 1; $counter <= $lastpage; $counter++)
            {           if ($page == "1") 
                                                $pagination.= " <a href=\"$targetpage/$counter\">$counter</a> ";                    
            else
            
                if ($counter == $page)
                    $pagination.= "<a href=\"$targetpage/$counter\">$counter</a> ";
                else
                    $pagination.= " <a href=\"$targetpage/$counter\">$counter</a> ";                    
            } }
        
                 //in middle; hide some front and some back

            //close to end; only hide early pages

      
        
        //next button
       
        $pagination.= "</li>\n";        
              
?>
<?=$pagination?>
    












<?php






 /*
  // Get the search variable from URL
              $limit=3; 

 // rows to return
//connect to your database ** EDIT REQUIRED HERE **
                include ('config.php');
                // Build SQL Query  
$query = "select id from worth where id order by id"; // EDIT HERE and specify your table and field names for the SQL query

 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);

// If we have no results, offer a google search as an alternative


// next determine if s has been passed to script, if not use 0
 
// get results
  $query .= " limit $limit";
  $result = mysql_query($query) or die("Couldn't execute query");

// display what the person searched for

// begin to show results set
//echo "Results";
$count = 1 + $s ;

// now you can display the results returned
  while ($row= mysql_fetch_array($result)) {
  $title = $row["id"];

  echo "$count.&nbsp;$title" ;
  $count++ ;
  }

$currPage = (($s/$limit) + 1);

//break before paging
  echo "<br />";

  // next we need to do the links to other results
  if ($s>=1) { // bypass PREV link if s is 0
  $prevs=($s-$limit);
  print "&nbsp;<a href=\"$PHP_SELF?s=$prevs&q=$var\">&lt;&lt; 
  Prev 10</a>&nbsp&nbsp;";
  }

// calculate number of pages needing links
  $pages=intval($numrows/$limit);

// $pages now contains int of pages needed unless there is a remainder from division

  if ($numrows%$limit) {
  // has remainder so add one page
  $pages++;
  }

// check to see if last page
  if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {

  // not last page so give NEXT link
  $news=$s+$limit;

  echo "&nbsp;<a href=\"$PHP_SELF?s=$news\">Next 10 &gt;&gt;</a>";
  }

$a = $s + ($limit) ;
  if ($a > $numrows) { $a = $numrows ; }
  $b = $s + 1 ;
  echo "<p>Showing results $b to $a of $numrows</p>";
*/
  
?>

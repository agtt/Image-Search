<?php
require_once('class.flickr.php');
require_once('settings.php');
?>
<html>
<head>
	<title>Search Pictures</title>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71356107-1', 'auto');
  ga('send', 'pageview');

	</script>
	<style>
	div.venue
	{   
		float: left;
		padding: 10px;
		background: #efefef;
		height: 200px;
		margin: 10px;
		width: 360px;
    }
    div.venue a
    {
    	color:#000;
    	text-decoration: none;

    }
    div.venue .icon
    {
    	background: #000;
		width: 200px;
		height: 180px;
		float: left;
		margin: 0px 10px 0px 0px;
    }
	</style>
	<link rel="stylesheet" href="../assets/css/bootstrap.css" />
	
	<script type="text/javascript" src="ddtabmenufiles/ddtabmenu.js">

/***********************************************
* DD Tab Menu script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<!-- CSS for Tab Menu #2 -->
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/glowtabs.css" />

<script type="text/javascript">
//SYNTAX: ddtabmenu.definemenu("tab_menu_id", integer OR "auto")
ddtabmenu.definemenu("ddtabs2", 0) //initialize Tab Menu #2 with 2nd tab selected
</script>
	
	
</head>
<body>
<?php
$query = array_key_exists("query",$_GET) ? $_GET['query'] : "Salman Khan";
$tags = array_key_exists("tags",$_GET) ? $_GET['tags'] : "";
$page = array_key_exists("page",$_GET) ? $_GET['page'] : "12";

echo "
	
	<form class=\"form-horizontal\" action=\"\" method=\"GET\">
	
<fieldset>

<!-- Form Name -->
<legend style=\"text-align: center;\">Search for Images: ".$query."</legend>
	
	<!-- Text input-->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"query\">Query</label>  
  <div class=\"col-md-4\">
  <input id=\"query\" name=\"query\" placeholder=\"Query\" class=\"form-control input-md\" required=\"\" type=\"text\">
    
  </div>
</div>

<!-- Text input-->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"tags\">Tags</label>  
  <div class=\"col-md-4\">
  <input id=\"tags\" name=\"tags\" placeholder=\"Tags(comma separated)\" class=\"form-control input-md\" type=\"text\">
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"page\">Results</label>
  <div class=\"col-md-4\"> 
    <label class=\"radio-inline\" for=\"page-0\">
      <input name=\"page\" id=\"page-0\" value=\"10\" checked=\"checked\" type=\"radio\">
      10
    </label> 
    <label class=\"radio-inline\" for=\"page-1\">
      <input name=\"page\" id=\"page-1\" value=\"20\" type=\"radio\">
      20
    </label> 
    <label class=\"radio-inline\" for=\"page-2\">
      <input name=\"page\" id=\"page-2\" value=\"30\" type=\"radio\">
      30
    </label> 
    <label class=\"radio-inline\" for=\"page-3\">
      <input name=\"page\" id=\"page-3\" value=\"40\" type=\"radio\">
      40
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"sort\">Sort</label>
  <div class=\"col-md-4\"> 
	<label class=\"radio-inline\" for=\"sort-6\">
      <input name=\"sort\" id=\"sort-6\" value=\"relevance\" checked=\"checked\" type=\"radio\">
      relevance
    </label>
    <label class=\"radio-inline\" for=\"sort-0\">
      <input name=\"sort\" id=\"sort-0\" value=\"date-posted-asc\" type=\"radio\">
      date-posted-asc
    </label> 
    <label class=\"radio-inline\" for=\"sort-1\">
      <input name=\"sort\" id=\"sort-1\" value=\"date-posted-desc\" type=\"radio\">
      date-posted-desc
    </label> 
    <label class=\"radio-inline\" for=\"sort-2\">
      <input name=\"sort\" id=\"sort-2\" value=\"date-taken-asc\" type=\"radio\">
      date-taken-asc
    </label> 
    <label class=\"radio-inline\" for=\"sort-3\">
      <input name=\"sort\" id=\"sort-3\" value=\"date-taken-desc\" type=\"radio\">
      date-taken-desc
    </label> 
    <label class=\"radio-inline\" for=\"sort-4\">
      <input name=\"sort\" id=\"sort-4\" value=\"interestingness-desc\" type=\"radio\">
      interestingness-desc
    </label> 
    <label class=\"radio-inline\" for=\"sort-5\">
      <input name=\"sort\" id=\"sort-5\" value=\"interestingness-asc\" type=\"radio\">
      interestingness-asc
    </label> 
  </div>
</div>

<!-- Button -->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"submit\"></label>
  <div class=\"col-md-4\">
    <input type=\"submit\" id=\"submit\" name=\"submit\" class=\"btn btn-primary\">
  </div>
</div>

</fieldset>
	</form>

";


$flickr = new Flickr($ClientId,$CliintSecret);
#$flickr = new Flickr(); 
$results = $flickr->searchPhotos($query, $tags,$page,$sort);
if(!empty($results)){
	echo "
<div id=\"ddtabs2\" class=\"glowingtabs\">
<ul>
<li><a rel=\"gc1\"><span>Images</span></a></li>
<li><a rel=\"gc2\"><span>Url</span></a></li>
</ul>
</div>

<DIV class=\"tabcontainer\">

<div id=\"gc1\" class=\"tabcontent\">
	";
  foreach($results as $photo):
	echo "<div class=\"venue\">";
      $src = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_m.jpg';
	echo "<img class=\"icon\" src=".$src." >",$photo['title'];
	echo "</div>";
	endforeach;
	echo "
</div>
<div id=\"gc2\" class=\"tabcontent\"> 
";
	foreach($results as $photo):
	$src = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_m.jpg';
	echo "<a href=\"".$src."\">".$src."</a><br>";
endforeach;
echo "
</div>
</DIV>
";
}

?>
</body>
</html>

<?php

// Read the contents of the .html file into a string.
include 'includes/header.php';
include 'includes/navbar.html';
include 'includes/search_form.php';

//load parameters
include 'includes/gbb.php';
if ($_POST['query'])
{
	// Easter Eggs!
	include 'includes/ee.php';
	
	// Query rewrite
	if(isset($_POST['qrw']))
	{
		include 'QueryRewrite.php';
	}
	else { }
		
	//~~~~~ /query rewrite - Begin results ~~~~~//
	
	$query = str_replace(array('NOT+', 'OR'), array('-', '|'), urlencode("{$_POST['query']}"));
	$queryBlek = str_replace('|+', '', $query);
	
	if ($_POST['search_type']==1)
	{
		include 'aggregated.php';
	}
	elseif ($_POST['search_type']==2)
	{
		include 'non_aggregated.php';
	}

}
else
{
	echo '<br><br><br><br>
	<p>Be sure to check the <strong><em><a href="about.php">About</a></em></strong> page for help and info on MetaSearch.<br/>
	If you wish, you can take the survey on the <strong><em><a href="feedback.php">Feedback</a></em></strong> page, its very short, and would be very helpful.</p>
	<br><br><br><br><br><br><br><br>';
}

include 'includes/footer.html';
?> 

<?php
include 'includes/header.php';
include 'includes/navbar_ev.html';
?>


<h3>MetaSearch Engine Performance</h3>

<form method="POST" action="" class="well form-search">
<label class="radio inline"><input name="eval_type" value="1" checked="" type="radio"> Aggregated</label>
<label class="radio inline"><input name="eval_type" value="2" type="radio"> Non_aggregated</label>
<label class="radio inline">&nbsp;&nbsp;|&nbsp;&nbsp;</label>
<label class="radio inline"><input name="res_type" value="2" checked="" type="radio"> View Previous Results</label>
<label class="radio inline"><input name="res_type" value="1" type="radio"> New Evaluation</label>
<br><br>
<input class="span3 " name="access" placeholder="Password (New Evaluations)" type="password">
<button type="submit" class="btn">Stats!</button>
</form>

<?php

echo '<div class="container" style="text-align:left" >';


if($_POST['access'])
{
	$access = md5($_POST['access']);	
}
if($_POST['res_type'])
{
		//New evaluations
		if($_POST['res_type'] == 1)
		{
			if($access == 'Include MD5 hash here')
			{
				if($_POST['eval_type'] == 1)
				{
					include 'evaluation_aggregated.php';
				}
				elseif($_POST['eval_type'] == 2)
				{
					include 'evaluation_separate.php';
				}
			}
			else
			{
				echo '<p class="text-warning">You must enter the correct password to run a new evaluation.</p>';
			}
		}
				
		//Precalculated evaluations
		elseif($_POST['res_type'] == 2)
		{
			if($_POST['eval_type'] == 1)
			{
				include 'MSresults.html';
			}
			elseif($_POST['eval_type'] == 2)
			{
				include 'GBBresults.html';
			}
		}
	
}
else
{
	echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
}
echo '</div>';
include 'includes/footer.html';
?>
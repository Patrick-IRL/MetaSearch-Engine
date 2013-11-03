<?php require_once('Connections/MetaSearchDB.php'); 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


mysql_select_db($database_MetaSearchDB, $MetaSearchDB);
$query_survey_results = "SELECT * FROM survey ORDER BY datesubmitted ASC";
$survey_results = mysql_query($query_survey_results, $MetaSearchDB) or die(mysql_error());
$row_survey_results = mysql_fetch_assoc($survey_results);
$totalRows_survey_results = mysql_num_rows($survey_results);


include 'includes/header.php';
include 'includes/navbar_fdb.html';
?>

<div class="container" style="text-align:left">
<h3>User Feedback</h3>
<p>Users were asked to fill in their answers to the questions below. Where a choice was given, they were asked to indicate how strongly they agreed or disagreed, using the following guidline:<br/>
1 = Strongly Disagree  |  2 = Disagree  |  3 = Neutral  |  4 = Agree  |  5 = Strongly Agree
</p>

<hr/>

<table class="table">
   	<thead>
        	<tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Submitted</th>
                <th scope="col">Engine</th>
                <th scope="col">Q2</th>
                <th scope="col">Q3</th>
                <th scope="col">Q4</th>
                <th scope="col">Q5</th>
                <th scope="col">Q6</th>
                <th scope="col">Q7</th>
                <th scope="col">Q8</th>
            </tr>
        </thead>
    <?php do { ?>
  <tr>
    <th scope="row"><?php echo $row_survey_results['name']; ?></th>
    <td><?php echo $row_survey_results['email']; ?></td>
    <td><?php echo $row_survey_results['datesubmitted']; ?></td>
    <td><?php echo $row_survey_results['fav_se']; ?></td>
    <td><?php echo $row_survey_results['Q1']; ?></td>
    <td><?php echo $row_survey_results['Q2']; ?></td>
    <td><?php echo $row_survey_results['Q3']; ?></td>
    <td><?php echo $row_survey_results['Q4']; ?></td>
    <td><?php echo $row_survey_results['Q5']; ?></td>
    <td><?php echo $row_survey_results['Q6']; ?></td>
    <td><?php echo $row_survey_results['Q7']; ?></td>
  </tr>
  <tr>
  	<td colspan="1">&nbsp;</td>
    <td colspan="10"><?php echo $row_survey_results['comments']; ?></td>
  </tr>
  <?php } while ($row_survey_results = mysql_fetch_assoc($survey_results)); ?>
</table>


</div>



<?php include 'includes/footer.html'; 
mysql_free_result($survey_results);
?>
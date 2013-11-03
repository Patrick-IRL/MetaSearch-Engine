<?php require_once('Connections/MetaSearchDB.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO survey (id, name, email, datesubmitted, fav_se, Q1, Q2, Q3, Q4, Q5, Q6, Q7, comments) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['datesubmitted'], "date"),
					   GetSQLValueString(strtolower($_POST['fav_se']), "text"),
                       GetSQLValueString($_POST['Q1'], "int"),
                       GetSQLValueString($_POST['Q2'], "int"),
                       GetSQLValueString($_POST['Q3'], "int"),
                       GetSQLValueString($_POST['Q4'], "int"),
                       GetSQLValueString($_POST['Q5'], "int"),
					   GetSQLValueString($_POST['Q6'], "int"),
                       GetSQLValueString($_POST['Q7'], "int"),
					   GetSQLValueString($_POST['comments'], "text"));

  mysql_select_db($database_MetaSearchDB, $MetaSearchDB);
  $Result1 = mysql_query($insertSQL, $MetaSearchDB) or die(mysql_error());

  $insertGoTo = "thanks.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
include 'includes/header.php';
include 'includes/navbar_fdb.html';
?>

<div class="container" style="text-align:left">
<h3>User Feedback</h3>
<p>Please fill in your answers to the questions below. Where a choice is given, indicate how strongly you agree or disagree, using the following guideline:<br/>
1 = Strongly Disagree  |  2 = Disagree  |  3 = Neutral  |  4 = Agree  |  5 = Strongly Agree
</p>

<hr/>

<form method="post" name="form1" class="well form-search" action="<?php echo $editFormAction; ?>">
	<h4>User Information</h4>
    Please enter your name and email address.
    <br/><br/>
    
    <span id="sprytextfield1">
    <input type="text" name="name" id="name" placeholder="Name (Required)">
    <span class="textfieldRequiredMsg">Required</span>
    <span class="textfieldMaxCharsMsg">Maximum of 35 characters.</span>
    </span>
    
    
    
    <br/>
    <br/>
    
    
    <span id="sprytextfield2">
    <input type="text" name="email" id="email" placeholder="Email (Optional)">
	<span class="textfieldMaxCharsMsg">Maximum of 100 characters.</span>
    </span>
    
    
    <br/><br/>
    1 - What is your normal search engine of choice?
    <br/><br/>
    
    <span id="sprytextfield3">
    <input type="text" name="fav_se" id="fav_se" placeholder="Search Engine">
    <span class="textfieldRequiredMsg">Required</span>
    <span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span>
    </span>
    
    
    <br/><br/>
    <h4>Interface</h4>
    2 - I found the interface very easy to use
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q1" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q1" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q1" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q1" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q1" value="5" CHECKED >5</label>
    
    <br/><br/><br/>
    3 - I liked how the results were presented
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q2" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q2" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q2" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q2" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q2" value="5" CHECKED >5</label>
    
    <br/><br/>
    <h4>Engine Functionality</h4>
    4 - In general, I found the quality of the results returned were superior to my normal search engine of choice.
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q3" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q3" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q3" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q3" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q3" value="5" CHECKED >5</label>
    
    <br/><br/><br/>
    5 - I found that the quality of results returned were improved when aggregation was turned on in comparison to when it was turned off.
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q4" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q4" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q4" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q4" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q4" value="5" CHECKED >5</label>
    
    <br/><br/><br/>
    6 - I found that using query expansion helped provide useful alternative search options.
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q5" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q5" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q5" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q5" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q5" value="5" CHECKED >5</label>
    
    <br/><br/>
    <h4>Impressions</h4>
    7 - The speed of the MetaSearch engine is comparable to that of my typical engine of choice.
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q6" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q6" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q6" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q6" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q6" value="5" CHECKED >5</label>
    
    <br/><br/><br/>
    8 - If given the option, I would consider making this search engine my default engine.
    <br/>
    
    <label class="radio inline"><input type="radio" name="Q7" value="1" >1</label>
    <label class="radio inline"><input type="radio" name="Q7" value="2" >2</label>
    <label class="radio inline"><input type="radio" name="Q7" value="3" >3</label>
    <label class="radio inline"><input type="radio" name="Q7" value="4" >4</label>
    <label class="radio inline"><input type="radio" name="Q7" value="5" CHECKED >5</label>
    
    <br/><br/>
    <h4>Comments</h4>
    9 - Do you have any comments you would like to add?
    <br/>
    
    <span id="sprytextarea1">
    <textarea name="comments" id="comments2" cols="45" rows="5" placeholder="Comments (Optional)"></textarea>
    <br/>Characters Remaining: 
    <span id="countsprytextarea1">&nbsp;</span>
    <span class="textareaMaxCharsMsg">Maximum of 250 characters.</span>
    </span>
    
    <br/><br/>
    
    <input class="btn btn-primary" type="submit" value="Submit">
    
    
    <input type="hidden" name="id" value="">
    <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>">
    <input type="hidden" name="MM_insert" value="form1">
</form>

</div>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {maxChars:35});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {maxChars:100, isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {maxChars:20});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, maxChars:250, counterId:"countsprytextarea1", counterType:"chars_remaining"});
</script>
<?php include 'includes/footer.html'; ?>
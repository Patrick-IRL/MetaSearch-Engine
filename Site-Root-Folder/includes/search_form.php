<div <?php if($_POST['query'] == 'flip'){echo 'class="flip"';} ?>>
<form method="POST" action="MetaSearch.php" class="well form-search">
<label class="radio inline">Aggregation</label>
<label class="radio inline"><input name="search_type" type="radio" value="1" CHECKED /> On</label>
<label class="radio inline"><input name="search_type" type="radio" value="2" /> Off</label><br/>
<label class="checkbox inline"><input name="qrw" type="checkbox" />Query Expansion</label>

<br/>
<input class="span3 " name="query" type="text" placeholder="Search" value="<?php if(isset($_POST['query'])) echo $_POST['query']; ?>" />
<!-- <input name="bt_search" type="submit" value="Search" class="btn btn-primary" /> -->
<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i></button>
</form>
</div>
<?php
//Parameters
$bht_key = '59137626092520433f2f4122f37093ba';
    
$bht_url = 'http://words.bighugelabs.com/api/2/'. $bht_key . '/'. strtok($_POST['query'], " ") . '/json';
    
$ch_bht = curl_init();
curl_setopt($ch_bht, CURLOPT_URL, $bht_url);
curl_setopt($ch_bht, CURLOPT_RETURNTRANSFER, 1);
$data_bht = curl_exec($ch_bht);
curl_close($ch_bht);

$js_bht = json_decode($data_bht);

//~~~~~~~~~ Alternatives: ADJ + NOUN, 1 list ~~~~~~~~~//

if($js_bht)
{
	echo '<form class="well form-inline" action="MetaSearch.php" method="post" style="padding-left:50px;padding-right:50px">';
	echo 'Alternatives:<br/>';
	
	foreach($js_bht as $obj)
	{
		foreach($obj as $item)
		{
			foreach($item as $word)
			{
				echo '<label class="radio inline"><input name="query" type="radio" value="'
				. substr(strstr($_POST['query']," "), 1) . ' ' . strtok($_POST['query'], " ") . ' ' . $word . '" />'
				. $word . '</label> ';
			}
		}
	}//end foreach
	echo '<input name="search_type" type="radio" style="display:none" value="' . $_POST['search_type'] . '" CHECKED />';
	echo '<br/><button type="submit" class="btn" style="margin-top:5px"><i class="icon-refresh"></i> Refine</button>';
	echo '</form>';
}
else
{
	echo 'No alternatives found: Please make sure your terms are not pluralised.';
}
?>
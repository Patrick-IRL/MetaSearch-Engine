<?php
	
	include 'includes/gbb.php';
	
	//preparing query list
	$queries = file('queries.txt');
	
	$query_list = array();
	foreach ($queries as $item) {
		$query_list[] = $item;
	}
	
	//initialise results array
	$ResultArray = array();
	
	//preparing results list
	$gold_lines = file('results.txt');
	$gold_results = array();
	foreach ($gold_lines as $data) {
	$gold_results[] = explode(" ", $data);
	}
	
	//create sorting function
	function sortByScore($a, $b)
	{
		if($a['score']==$b['score']) return 0;
		return $a['score'] < $b['score']?1:-1;
	}

	echo '<h2>MetaSearch Engine Statistics</h2><hr/>';
	?>

	<table class="table">
    	<thead>
        	<tr>
                <th scope="col">TREC Index</th>
                <th scope="col">Query</th>
                <th scope="col">Precision</th>
                <th scope="col">Recall</th>
                <th scope="col">F-measure</th>
                <th scope="col">P@10</th>
                <th scope="col">Avg Precision</th>
            </tr>
        </thead>

	<?php

	$MAP = 0;
	$FMAvg = 0;
	for($qry = 0; $qry < 50; $qry++)
	{
	$query = str_replace(array('NOT+', 'OR'), array('-', '|'), urlencode($query_list[$qry]));
	$queryBlek = str_replace('|+', '', $query);

	
	
	/* ----------Google----------*/
	$start_num = 1;
	$i = 1;
	$key_array_index = 0;
	while($start_num < 101)
	{	
		$google_url = "$rootUri?key=$g_key[$key_array_index]&cx=$cx[$key_array_index]&q=$query&alt=json&start=$start_num"; 
	
		$ch_g = curl_init();
		curl_setopt($ch_g, CURLOPT_URL, $google_url);
		curl_setopt($ch_g, CURLOPT_RETURNTRANSFER, 1);
		$data_g = curl_exec($ch_g);
		curl_close($ch_g);
		
		$js_google = json_decode($data_g);
	
		// Load decoded JSON data into an array
		foreach($js_google->items as $item_g)
		{
			//loading data
			$goog_url = str_replace(array('http://','https://','www.'), '', rtrim($item_g->{'link'}, "/"));
			
			if(!isset($ResultArray[$goog_url]))
			{
				$ResultArray += array
				(
					$goog_url => array
					(
						"score" => (1/(60+$i)),
						"snippet" => strip_tags($item_g->{'snippet'})
					)
				);
			}
			
			else
			{
				$ResultArray[$goog_url]['score'] += (1/(60+$i));
			}
			
			$i++;
		}//end foreach
		$key_array_index++;
		$start_num += 10;
	}//end while
	/* ----------Google End----------*/




	/* ----------Bing----------*/
	// Construct the full URI for the query.
	$skip_num = 0;
	
	//echo '<h2>Bing Results</h2><p>Query URL: ' . /* $requestUri .*/ 'Hidden</p><hr/>';
	$i = 1;
	
	while($skip_num < 100)
	{
		$requestUri = "$bingRootUri/$serviceOp?\$format=json&Query='$query'&\$skip=$skip_num";
	
		//bing curl
		$ch_bing = curl_init();
		curl_setopt($ch_bing, CURLOPT_URL, $requestUri);
		curl_setopt($ch_bing, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch_bing, CURLOPT_USERPWD,  $acctKey . ":" . $acctKey);
		curl_setopt($ch_bing, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch_bing, CURLOPT_RETURNTRANSFER, TRUE);
		$data_bing = curl_exec($ch_bing);
		curl_close($ch_bing);
		
		$js_bing = json_decode($data_bing);
		
		foreach($js_bing->d->results as $item_bi)
		{
			//loading data
			$bing_url = str_replace(array('http://','https://','www.'), '', rtrim($item_bi->{'Url'}, "/"));
	
	
			if(!isset($ResultArray[$bing_url]))
			{
			$ResultArray += array
			(
				$bing_url => array
				(
					"score" => (1/(60+$i)),
					"snippet" => strip_tags($item_bi->{'Description'})
				)
			);
			}
			
			else
			{
				$ResultArray[$bing_url]['score'] += (1/(60+$i));
			}
			
			$i++;
				
		}//end foreach
		
		$skip_num += 50;
	}//end double loop
	/* ----------Bing End----------*/
	
	
	
	
	/* ----------Blekko----------*/
	
	$blekko_url = $blekkoRootUri . '?q=' . $queryBlek . '+/json+/ps=' . $numResults;

	$ch_blek = curl_init();
	curl_setopt($ch_blek, CURLOPT_URL, $blekko_url);
	curl_setopt($ch_blek, CURLOPT_RETURNTRANSFER, 1);
	$data_blek = curl_exec($ch_blek);
	curl_close($ch_blek);
	
	$js_blekko = json_decode($data_blek);

	//echo '<h2>Blekko Results</h2><p>Query URL: ' . /* $blekko_url .*/ 'Hidden</p><hr/>';
	$i = 1;
	// Load decoded JSON data into an array
	foreach($js_blekko->{'RESULT'} as $item_bl)
	{
		//loading data
		$blek_url = str_replace(array('http://','https://','www.'), '', rtrim($item_bl->{'url'}, "/"));	
		
		if(!isset($ResultArray[$blek_url]))
		{
		$ResultArray += array
		(
			$blek_url => array
			(
				"score" => (1/(60+$i)),
				"snippet" => strip_tags($item_bl->{'snippet'})
			)
		);
		}
		
		else
		{
			$ResultArray[$blek_url]['score'] += (1/(60+$i));
		}
		
		$i++;
		
	}
	/* ----------Blekko End----------*/
	
	
	
	
	//Using uasort with function sortByScore to order the aggregated list by score.	
	uasort($ResultArray, 'sortByScore');
	
	// ~~~~~~~END DATA RETRIEVAL // BEGIN DATA EVALUATION~~~~~~~~//
	
	
	$TREC_no = 151 + $qry;	
	
	$i = 0;
	$num_matches = 0;
	while($gold_results[$i][0] != $TREC_no)
	{
	$i++;
	}
	$start = $i;
	
	$j = 1;
	$AvPrec = 0;
	foreach ($ResultArray as $key => $result)
	{
		while($gold_results[$i][0] == $TREC_no)
			{
	
			$gold_url = str_replace(array('http://','https://','www.'), '', rtrim($gold_results{$i}[1], "/\n"));
	
			if($key == $gold_url)
			{
				$num_matches += 1;
				$AvPrec = $AvPrec + ($num_matches / $j);
				break;
			}
			else{ }
		
			$i++;
			}
			
			if($j == 10)
			{
				$P_at_10 = $num_matches / 10;	
			}
				
			$j++;
			$i = $start;
			if($j > 100)
			{
				break;
			}
		}
		
		$precision = $num_matches / ($j - 1);
		$recall = $num_matches / 100;
		$FM = (2*$precision*$recall)/($precision + $recall);
		echo '<tr><th scope="row">' . $TREC_no . '</th>';
		echo '<td>' . $query_list[$qry] . '</td>';
		echo '<td>' . $precision .'</td>';
		echo '<td>' . $recall .'</td>';
		echo '<td>' . $FM .'</td>';
		echo '<td>' . $P_at_10 .'</td>';
		echo '<td>' . $AvPrec .'<td/></tr>';
	
		
		$MAP += $AvPrec;
		$FMAvg += $FM;
		$ResultArray = array();
	}// end for loop (qry loop)
	$MAP = $MAP / $qry;
	$FMAvg = $FMAvg / $qry;
	echo '<tr><th colspan="1">MAP</th>
			<td colspan="1">' . $MAP . '</td>
			<th colspan="2">Average F-Measure</th>
			<td colspan="3">' . $FMAvg . '</td></tr>';
	echo '</table>';
	
?>
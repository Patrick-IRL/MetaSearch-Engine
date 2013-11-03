<?php

	$ResultArray = array();
	
	/* ----------Google----------*/
	$start_num = 1;
	$i = 1;
	$key_array_index = 0;
	while($start_num < 51)
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
			
			//print data, for debug
			//echo $ResultArray[$item_g->{'link'}]['score'] . ' - <a href="' . $item_g->{'link'} .'">' . $item_g->{'link'} . '</a><br/>';
			//echo $ResultArray[$item_g->{'link'}]['snippet'] . '<br/><hr/>';
			
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
	
	while($skip_num < 50)
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
			
			//print data, for debug
			//echo $ResultArray[$item_bi->{'Url'}]['score'] . ' - <a href="' . $item_bi->{'Url'} .'">' . $item_bi->{'Url'} . '</a><br/>';
			//echo $ResultArray[$item_bi->{'Url'}]['snippet'] . '<br/><hr/>';
			
			$i++;
				
		}//end foreach
		
		$skip_num += 50;
	}//end double loop
	/* ----------Bing End----------*/
	
	
	
	
	/* ----------Blekko----------*/
	
	$blekko_url = $blekkoRootUri . '?q=' . $queryBlek . '+/json+/ps=' . $numResults;

	// initiate cURL
	$ch_blek = curl_init();
	// set the URL
	curl_setopt($ch_blek, CURLOPT_URL, $blekko_url);
	//return the transfer as a string
	curl_setopt($ch_blek, CURLOPT_RETURNTRANSFER, 1);
	// get the web page source into $data
	$data_blek = curl_exec($ch_blek);
	//delete this later but it confirms that the search data is output
	//echo $data;
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
	



function sortByScore($a, $b)
{
	if($a['score']==$b['score']) return 0;
    return $a['score'] < $b['score']?1:-1;
}

uasort($ResultArray, 'sortByScore');

$output;
$output .= '<div class="container" style="text-align:left">';
$output .= '<h2> Search Results</h2><hr/>';
$j = 1;
foreach ($ResultArray as $key => $result)
{
	//print data, for debug
		$output .= $j . ' - <a href="http://' . $key .'">' . $key . '</a><br/>'
				 . '<a class="muted" href="about.php">RRF Score: ' . $result['score'] . '</a><br/>';
		$output .= $result['snippet'] . '<br/><hr/>';
		$j++;
		if($j > 100)
		{
			break;
		}
}
$output .= '</div>';
echo $output;
?> 
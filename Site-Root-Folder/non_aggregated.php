<?php

	$output;

	$output .= '<div class="container" style="text-align:left" >';
	
	/* ----------Google----------*/
	$start_num = 1;
	$i = 1;
	
	$output .= '<h2 id="google">Google Results</h2><hr/>';
	
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
	
		foreach($js_google->items as $item_g)
		{	
			//print data, for debug
			$output .= $i . ' - <a href="' . $item_g->{'link'} .'">' .
				str_replace(array('http://','https://','www.'), '', rtrim($item_g->{'link'}, "/"))
				. '</a><br/>'
				. '<a class="muted" href="about.php">RRF Score: ' . (1/(60+$i)) . '</a><br/>';
			$output .= $item_g->{'snippet'} . '<br/><hr/>';
			
			$i++;
		}//end foreach
		$key_array_index++;
		$start_num += 10;
	}//end while
	/* ----------Google End----------*/
	



	/* ----------Bing----------*/
	// Construct the full URI for the query.
	$skip_num = 0;
	$i = 1;
	
	$output .= '<h2 id="bing">Bing Results</h2><hr/>';
	
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
			//print data, for debug
			$output .= $i . ' - <a href="' . $item_bi->{'Url'} .'">' .
				str_replace(array('http://','https://','www.'), '', rtrim($item_bi->{'Url'}, "/"))
				. '</a><br/>'
				. '<a class="muted" href="about.php">RRF Score: ' . (1/(60+$i)) . '</a><br/>';
			$output .= $item_bi->{'Description'} . '<br/><hr/>';
			
			$i++;
		}//foreach
		$skip_num += 50;
	}//while
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

	$output .= '<h2 id="blekko">Blekko Results</h2><hr/>';
	$i = 1;
	
	foreach($js_blekko->{'RESULT'} as $item_bl)
	{
		//print data, for debug
		$output .= $i . ' - <a href="' . $item_bl->{'url'} .'">' .
			str_replace(array('http://','https://','www.'), '', rtrim($item_bl->{'url'}, "/"))
			. '</a><br/>'
			. '<a class="muted" href="about.php">RRF Score: ' . (1/(60+$i)) . '</a><br/>';
		$output .= strip_tags($item_bl->{'snippet'}) . '<br/><hr/>';
		$i++;
	}
	/* ----------Blekko End----------*/
	
	$output .= '</div>';
	echo $output;

?> 
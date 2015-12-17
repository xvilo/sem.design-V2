<?php 
	
		function time2str($ts)
		{
		    if(!ctype_digit($ts))
		        $ts = strtotime($ts);
		    $diff = time() - $ts;
		    if($diff == 0)
		        return 'now';
		    elseif($diff > 0)
		    {
		        $day_diff = floor($diff / 86400);
		        if($day_diff == 0)
		        {
		            if($diff < 60) return 'just now';
		            if($diff < 120) return '1 minute ago';
		            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
		            if($diff < 7200) return '1 hour ago';
		            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
		        }
		        if($day_diff == 1) return 'Yesterday';
		        if($day_diff < 7) return $day_diff . ' days ago';
		        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
		        if($day_diff < 60) return 'last month';
		        return date('F Y', $ts);
		    }
		    else
		    {
		        $diff = abs($diff);
		        $day_diff = floor($diff / 86400);
		        if($day_diff == 0)
		        {
		            if($diff < 120) return 'in a minute';
		            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
		            if($diff < 7200) return 'in an hour';
		            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
		        }
		        if($day_diff == 1) return 'Tomorrow';
		        if($day_diff < 4) return date('l', $ts);
		        if($day_diff < 7 + (7 - date('w'))) return 'next week';
		        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
		        if(date('n', $ts) == date('n') + 1) return 'next month';
		        return date('F Y', $ts);
		    }
		}
	function getTrakt(){
    	$ch = curl_init();
		$str = 'https://api-v2launch.trakt.tv/users/xvilo/history/shows';
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"trakt-api-version: 2",
			"trakt-api-key: 260e9726e0eb3b75e5207de183328ba14c9c66de8d53136b36325577c25a6261"
		));
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		return $response;
		}
		
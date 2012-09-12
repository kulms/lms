<?
	/*
		Business day calc and misc date/time functions
		Made/Compiled by Cyte at www.studioah.com
		
		I got most of these functions from planet-source-code except for the actual business day calc
		functions. I don't feel like figuring out where I got these functions (it was a while ago)
		so I'm just not going to include a copyright of any kind.
		
		Some Notes:
		I don't like the unix timestamp format so I try to work more with the mysql timestamp,
		however PHP likes the unix version more. I've included functions to work with both seamlessly
		
		Also note that the functions do not take into account the startDate, but does include the 
		enddate, in it's calculation. So if you calculated between a monday and a friday it would 
		return 4 business days.
	*/
	
	// this function converts timestamps to unix timestamps
   	function timestamp2utime($string2format) {
   		return mktime(substr($string2format, 8,2), substr($string2format, 10, 2), substr($string2format, 12, 2), substr($string2format, 4,2), substr($string2format, 6, 2), substr($string2format, 0, 4));
   	}
   	// this function converts unix timestamps to mysql timestamps
   	function utime2timestamp($string2format) {
   		return date("YmdHis",$string2format);
   	}
   	// function takes unix timestamps
	function dayOfWeek($timestamp) { 
		return intval(strftime("%w",$timestamp))+1; 
	}
	//function takes unix timestamps
	function DateAdd($date, $interval, $number) {
		
	    $date_time_array  = getdate($date);
	    
		$hours =  $date_time_array["hours"];
		$minutes =  $date_time_array["minutes"];
		$seconds =  $date_time_array["seconds"];
		$month =  $date_time_array["mon"];
		$day =  $date_time_array["mday"];
		$year =  $date_time_array["year"];
		
	    switch ($interval) {
	        case "yyyy":
	            $year +=$number;
	            break;
	        case "q":
	            $year +=($number*3);
	            break;
	        case "m":
	            $month +=$number;
	            break;
	        case "y":
	        case "d":
	        case "w":
	             $day+=$number;
	            break;
	        case "ww":
	             $day+=($number*7);
	            break;
	        case "h":
	             $hours+=$number;
	            break;
	        case "n":
	             $minutes+=$number;
	            break;
	        case "s":
	             $seconds+=$number;
	            break;
	    }
		$timestamp =  mktime($hours ,$minutes, $seconds,$month ,$day, $year);
	    return $timestamp;
	}
	function isBusinessDay($utstamp){
		if(dayOfWeek($utstamp)!=1 && dayOfWeek($utstamp)!=7){
			return true;
		}else{
			return false;
		}
	}
	// below is the function that takes unix timestamps
	function getBusinessDayCount($startStamp,$endStamp){
		$dateTmp=$startStamp;
		$businessDays=0;
		$loopEnd=false;
		while(!$loopEnd){
			$dateTmp = DateAdd($dateTmp,"d",1);
			if(isBusinessDay($dateTmp)){
				$businessDays++;
			}
			if($dateTmp==$endStamp){
				$loopEnd=true;
			}
		}
		return $businessDays;
	}
	// below is the function that takes mysql timestamps
	function getBusinessDayCount_timestamp($startStamp,$endStamp){
		$startStamp=timestamp2utime($startStamp);
		$endStamp=timestamp2utime($endStamp);
		$dateTmp=$startStamp;
		$businessDays=0;
		$loopEnd=false;
		while(!$loopEnd){
			$dateTmp = DateAdd($dateTmp,"d",1);
			if(isBusinessDay($dateTmp)){
				$businessDays++;
			}
			if($dateTmp==$endStamp){
				$loopEnd=true;
			}
		}
		return $businessDays;
	}
	
	// examples below
	
	//print "Is today a business day? <b>";
	//print isBusinessDay(getdate()) ? "yes" : "no";
	//print "</b><BR><BR>";
	//print "How many business days between Dec. 16, 2002 and Jan. 1, 2003? <b>". 
		//getBusinessDayCount_timestamp(20021216000000,20030101000000);
	//print "<BR><BR>";
	
?>









<?php

function get_image($path,$id,$size='orig') {
	if ($size=='1000h') {//portraits
		$filestr=sprintf('%1$s%2$09d_1000h', $path,$id);
	} else if ($size=='600h') {//thumbnails - width 600px
		$filestr=sprintf('%1$s%2$09d_600h', $path,$id);
	} else if ($size='300h') {//used as decoration - height 300px
		$filestr=sprintf('%1$s%2$09d_300h', $path,$id);
	} else if ($size='orig') {//original size
		$filestr=sprintf('%1$s%2$09d', $path,$id);		
	} else {//this size doesn't exist
		return false; 
	}
		
	if (file_exists($filestr.".jpg")) {
		$link_thumb = $filestr.".jpg";
	} else if (file_exists($filestr.".png")) {
		$link_thumb = $filestr.".png";
	} else if (file_exists($filestr.".gif")) {
		$link_thumb = $filestr.".gif";
	} else {
		$link_thumb = false;
	}
	
	return $link_thumb;
}

function logme($message) {
	if (is_array($message) || is_object($message)) {
        error_log(print_r($message, true));
    } else {
        error_log($message);
    }
}

function logmeline($message) {
	
}
			
function form_date($date,$long=false) {
	//stupid formatting shiv. should be done somewhere else, not sure where tho. On db load?
	$date_format = "Y/m/d";
	$slashed = strpos($date,"/");
	if ($slashed === false) {
		//empty, or weird format
		return $date;
	} else {
		$date_array = explode("/", $date);
		if ($date_array[1]=='00') {
			$year = $date_array[0];
			if (isset($year[0]) && $year[0] == "-") {
				return substr($year,1,strlen($year))."&nbsp;BCE";
			} else {
				return $year."&nbsp;CE";
			}
		} else {
			$datetime = date_create_from_format($date_format, $date);
			if ($long) {
				$datestr = date_format($datetime, "jS F Y");
			} else {
				$datestr = date_format($datetime,"Y");
			}			
			return $datestr;
		}
	}
}

function format_date_place($woman,$form='short') {
	
	
	if ($form=='short') {
		$db=form_date($woman['date_born']);
	 $pb=$woman['place_born'];
	 $dd=form_date($woman['date_died']);
	 $pd=$woman['place_died'];
	
		if (is_null($db)) {
		 	$date_place = "";
			// 0 0
		} elseif (is_null($dd)) {
			$date_place = "$db";
			//1 0
		} else {
			$date_place = "$db – $dd";
		}
	} elseif ($form=='long') {
		$db=form_date($woman['date_born'],true);
	 $pb=$woman['place_born'];
	 $dd=form_date($woman['date_died'],true);
	 $pd=$woman['place_died'];
	
		if (is_null($db)) {
		 	$date_place = "";
			// 0 0 0 0
		 } elseif (is_null($pb)) {
		 	$date_place ="$db";
			// 1 0 0 0
			if (!is_null($dd)) {
				$date_place .=" – $dd";
				// 1 0 1 0
			}
		 } elseif (is_null($dd)) {
		 	$date_place = "$db, $pb";
			// 1 1 0 0
		 } elseif (is_null($pd)) {
		 	$date_place = "$db – $dd, $db";
			// 1 1 1 0
		 } else {
		 	$date_place = "$db, $pb – $dd, $pd";
			// 1 1 1 1
		 };
	} 
	
	return $date_place;
	 
}

?>
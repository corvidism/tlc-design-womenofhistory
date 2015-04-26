<?php

function get_image($path,$id) {
	$filestr=sprintf('%1$s%2$09d', $path,$id);
	error_log($filestr);
	if (file_exists($filestr.".jpg")) {
		$link_thumb = $filestr.".jpg";
	} else if (file_exists($filestr.".png")) {
		$link_thumb = $filestr.".png";
	} else if (file_exists($filestr.".gif")) {
		$link_thumb = $filestr.".gif";
	} else {
		$link_thumb = "default.jpg";
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
			
function form_date($date) {
	//stupid formatting shiv. should be done somewhere else, not sure where tho. On db load?
	
	$date_array = explode("/", $date);
	
	//see if the format is "*/00/00" - if so, strip the last part, it's just a year.
	//if not, turn this into a proper PHP date, then use PHP formatting to spit it out properly
	
	$year = $date_array[0];
	if (isset($year[0]) && $year[0] == "-") {
		return substr($year,1,strlen($year))."BCE";
	} else {
		return $year."CE";
	}
	
	//don't echo empty year - if the second date is empty, echo only the first one
}


?>
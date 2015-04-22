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

?>
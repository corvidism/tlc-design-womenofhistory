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

?>
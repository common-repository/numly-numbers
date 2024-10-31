<?php

/* $Id: numly_functions.php 291470 2010-09-19 23:45:56Z sgrayban $ */

function numly_url_get($url) {
	// user send_to_host whenever possible, it's better.
	$return_value = '';
	$elements = parse_url($url);
	if ($fp = @fsockopen($elements['host'],80)) {
		fputs($fp, sprintf("GET %s HTTP/1.0\r\n" . "Host: %s\r\n\r\n", $elements['path'] . (isset ($elements['query']) ? '?'. $elements['query'] : ''), $elements['host']));
		while (!feof($fp)) $line .= fgets($fp, 4096);
		fclose($fp);
		$line       = urldecode(trim(strtr($line,"\n\r\t\0","    ")));
		$work_array = explode("  ",$line);
		/*
		 * This does not allow for any additional messages to be passed. It
		 * assumes that the last time coming in is the version #.
		 */
		$return_value = $work_array[count($work_array)-1];
	} // if ($fp)
return $return_value;
} // function numly_url_fetch($url)


function numly_get_version($file_name) {
	if (!empty($file_name)) {
		/*
		 * Ripped out of WordPress Not sure if I'll ever use any more of this but I'll
		 * leave them in just for fun.
		 */
		$plugin_data = implode('', file($file_name));
		if (preg_match("|Version:(.*)|i", $plugin_data, $version)) {
				$version = $version[1];
		} // if (preg_match("|Version:(.*)|i", $plugin_data, $version))
	} // if (!empty($filename))
	return $version;
} // function numly_get_version($file_name)


function numly_send_to_host($host,$method,$path,$data,$return_full_headers=false)
{

    $method = empty($method)?'GET':strtoupper($method);
    if ($method == 'GET') $path .= '?' . $data;
    $output  = '';
    $output .= $method." ".$path." HTTP/1.1\r\n";
    $output .= "Host: ".$host."\r\n";
    $output .= "Content-type: application/x-www-form-urlencoded\r\n";
    $output .= "Content-length: ".strlen($data)."\r\n";
    $output .= "Connection: close\r\n\r\n";
    $output .= ($method=='POST'?$data:'')."\n";

    $fp = fsockopen($host, 80);
	$switch = false;
	fputs($fp,$output);
	/*
	 * Change this to store headers in one array and lines in another. If
	 * return full headers is true then concat before returning.
	 */
	while (!feof($fp)) {
		$line = strtr(fgets($fp,128),array("\n"=>"","\r"=>""));
		if (!$switch and empty($line)) {
			$switch = (!$switch);
		} else if ($switch) {
			$buf .= $line;
		} // if (!$switch and empty($line))
	} // while (!feof($fp))
    fclose($fp);
    return $buf;
}	// function numly_sendToHost($host,$method,$path,$data,$useragent=0)

function numly_fetch_options($prefix='numly') {
	$output = array();
   	$output=get_option($prefix.'_options');
	return $output;
}

function numly_post_options($prefix='numly',$source_array) {
	update_option($prefix.'_options',$source_array);
	return;
}

?>
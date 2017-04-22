<?php
/*
 Plugin Name: WP-Flash
 Version: Review
 Author: CyberSEO.net
 Author URI: http://www.cyberseo.net/
 Plugin URI: https://wordpress.org/plugins/wp-flash/
 Description: This plugin was developed by cyberseo.net, please do not delete the author's credits. Innserts the Adobe Flash animation into WordPress blog posts, pages and RSS feeds, using the following tag style: <strong>[swf:url width height bgcolor wmode]</strong>. Where <strong>url</strong> - URL of the flash object (SWF file) you want to embed; <strong>width</strong> - width of the flash object; <strong>height</strong> - height of the flash object; <strong>bgcolor</strong> - background color (optional); <strong>wmode</strong> - wmode, e.g. transparent (optional).
 */

if (!function_exists("add_filter")) {
	die();
}

function wpFlashParseMacro($string) {
	@list($url, $width, $height, $bgcolor, $wmode) = explode(" ", $string);
	$param = $obj = '';
	if (isset($bgcolor)) {
		$obj .= ' bgcolor="' . $bgcolor . '"';
		$param .= '<PARAM NAME=bgcolor VALUE="' . $bgcolor . '">';
	}
	if (isset($wmode)) {
		$obj .= ' wmode="' . $wmode . '"';
		$param .= '<PARAM NAME=wmode VALUE="' . $wmode . '">';
	}
	return "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"$obj width=\"$width\" height=\"$height\" id=\"$url\" align=\"\">$param<PARAM NAME=movie VALUE=\"$url\"><PARAM NAME=quality VALUE=high><EMBED src=\"$url\" quality=high  WIDTH=\"$width\" HEIGHT=\"$height\" NAME=\"$url\" TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED></OBJECT>";
}

function wpFlashInsertSwf($content) {
	return preg_replace("'\[swf:(.*?)\]'ie", "stripslashes(wpFlashParseMacro('\\1'))", $content);
}

add_filter('the_content', 'wpFlashInsertSwf');
add_filter('the_excerpt', 'wpFlashInsertSwf');
?>

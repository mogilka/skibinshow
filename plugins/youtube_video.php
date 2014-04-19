<?php
/*
Plugin Name: Hello World
Description: Echos "Hello World" in footer of theme
Version: 1.0
Author: Chris Cagle
Author URI: http://www.cagintranet.com/
*/

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

// register plugin
register_plugin(
	$thisfile,	// ID of plugin, should be filename minus php
	'Youtube Video Display',	# Title of plugin
	'1.5',	// Version of plugin
	'Raul Dominguez - Luar',	// Author of plugin
	'rauldominguez.host22.com',	// Author URL
	'Add a Youtube Video on the page from the youtube video ID.',	// Plugin Description
	'plugin',	// Page type of plugin
	'youtube_video_display'	// Function that displays content
);

# activate filter
add_filter('content','youtube_video_display');

/**
 * Parses the content on a page and matches it to a gallery if one exists.
 *
 * @param string $content - Content of Page
 * @return string;
 */
function youtube_video_display($content)
{
	$found = preg_match_all('/\{youtube_(\w+)\}/', $content, $match);

	for ($i=0; $i<=$found; $i++)
	{
		$sVideo = '';
		if (isset($match[1][$i]))
		{
                    $sVideo = $match[1][$i];
                    $aVideoParams = explode('_', $match[1][$i]);
                    $eVid = $aVideoParams[0];
                    $sType = $aVideoParams[1];
                    $iWidth = $aVideoParams[2];
                    $iHeight = $aVideoParams[3];
		}
		else
		{
                    return $content;
		}

		$video = youtube_video_embed($eVid,$sType,$iWidth,$iHeight);

		$content = preg_replace('/\{youtube_'.$sVideo.'\}/', $video, $content);
	}

	return $content;
}

function youtube_video_embed($id, $type = "standard", $w = 320, $h = 260){
    if ($type == '') $type = "standard";
    if ($w == '') $w = 320;
    if ($h == '') $h = 260;
    switch($type){
    case "standard":
    return('<object width="'.$w.'" height="'.$h.'">
        <param name="movie" value="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US&amp;rel=0"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowscriptaccess" value="always"></param>
        <embed src="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$w.'" height="'.$h.'"></embed>
        </object>');
    break;

    case "valid":
    return('<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US&amp;rel=0" width="'.$w.'px" height="'.$h.'px">
      <param name="movie" value="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US&amp;rel=0" />
      <param name="quality" value="high" />
      <param name="wmode" value="transparent" />
      <param name="align" value="TC" />
      <param name="scale" value="exactfit" />
    </object>');
    break;

    case "iframe":
    return('<iframe class="youtube-player" type="text/html" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$id.'"></iframe>');
    break;
    }
}

?>
<?php

$ARG['language'] = 'en';  // the language of the guestbook,for example it,en
$ARG['host'] = $SITEURL;  // insert the url of the host,for example 'http://www.mysite.com/'
$ARG['ARGfiles'] = GSROOTPATH.'ARGuestbook_Files/'; // the path of the folder ARGuestbook_Files
$ARG['langpath'] = $ARG['ARGfiles'].'lang/';
$ARG['comments'] = $ARG['ARGfiles'].'Pages_comments/';
$ARG['nmcomments'] = $ARG['ARGfiles'].'Articles_comments/';
$ARG['formact'] = $ARG['host'].'ARGuestbook_Files/salva_commenti.php';
$ARG['smilesDir'] = $ARG['host'].'ARGuestbook_Files/emotions/';
$ARG['smilesFile'] = $ARG['ARGfiles'].'smiles.ini';
$ARG['colortd'] = '#f8e8c4'; // the color of comment tab
$ARG['colortdhead'] = '#6e4d06'; // the color of comment header
$ARG['colorgb_td'] = '#f8e8c4';  //the color of guestbook tab
$ARG['colorgb_head'] = '#6e4d06';  //the color of guestbook header
$ARG['inipath'] = $ARG['ARGfiles'].'User_config.ini';
$ARG['newsmanager'];

// LOAD SETTINGS FROM User_config.ini
$file = file($ARG['inipath'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach($file as $line){
   $splitted = preg_split("/[|]/", $line, -1, PREG_SPLIT_NO_EMPTY);
	if(count($splitted) != 6)
	  continue;
	  $ARG['language'] = $splitted[0];
	  $ARG['colortd'] = $splitted[1];
	  $ARG['colortdhead'] = $splitted[2];
	  $ARG['colorgb_td'] = $splitted[3];
	  $ARG['colorgb_head'] = $splitted[4];
	  $ARG['newsmanager'] = $splitted[5];
}
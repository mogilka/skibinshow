<?php

require_once GSROOTPATH.'/ARGuestbook_Files/Settings.php';

class smile{
public $name;
public $src;

function __construct($name,$src){
$this->name=$name;
$this->src=$src;
}

}

class emoticons{

//global $ARG;
public $smilesDir;
public $smilesArray;


function __construct(){
global $ARG;
$this->smilesDir=$ARG['smilesDir'];
$this->smilesArray = array();
}

function load_emoticons(){
global $ARG;
$a="<img src=\"$this->smilesDir";
$b="\" title=\"";
$c="\" />";
$file = file($ARG['smilesFile'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach($file as $line)
{
    $splitted = preg_split("/[!]/", $line, -1, PREG_SPLIT_NO_EMPTY); 
	array_push($this->smilesArray,new smile($splitted[0],$a.$splitted[1].$b.$splitted[0].$c));
	if(count($splitted) != 2)
	  continue; //ignore malformed lines
}
}

}
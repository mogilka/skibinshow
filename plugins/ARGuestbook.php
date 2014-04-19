<?php
/*
Plugin Name: ARGuestbook 
Description: A Guestbook for your site
Version: 1.1.9
Author: Alessio_romaTM
Author URI: http://www.lafucinadiharad.tk
*/
define("VERSION", '1.1.9');
if(!isset($_SESSION)){ 
    session_start();
   }

require_once GSROOTPATH.'/ARGuestbook_Files/Settings.php';
require_once GSROOTPATH.'/ARGuestbook_Files/smile.php';



class Commento
{
public $nick;
public $comm;
public $data;
public $ip;

function __construct($nickname,$commento,$data,$ip){
$this->nick=$nickname;
$this->comm=$commento;
$this->data=$data;
$this->ip=$ip;
}
}

class NomeFile{
public static $nomefile;
}

class Language{
public static $GSbook_header;
public static $GSbook_nick;
public static $GSbook_msg;
public static $GSbook_sendbutton;
public static $GSbook_wrote;
public static $GSbook_empty;
public static $GSbook_nicktext;
public static $GSbook_textarea;
public static $GSbook_writecode;
public static $GSbook_notposts;
public static $GSbook_select;
public static $GSbook_delete;
public static $GSbook_success;
}

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile, 
	'ARGuestbook', 	
	VERSION, 		
	'Alessio_romaTM',
	'http://harad.altervista.org', 
	'A Guestbook for your site with "news manager mod" plugin support',
	'plugins',
	'squareit_setup_tabloader'  
);

# activate filter
add_action('index-pretemplate','Inizializza',array(&NomeFile::$nomefile));
add_action('index-pretemplate','guestbook_check',array());
add_action('nav-tab','sqr_createNavTab',array($thisfile,'ARGuestbook'));
add_action($thisfile.'-sidebar','sqr_createSideMenu',array($thisfile, $thisfile,'Posts management'));


# functions
function Inizializza($nomefile) {
global $ARG;
global $url;
if($ARG['newsmanager'] == 'off') {
$_SESSION['pageurl']=$ARG['host']."index.php?id=".$url;
$_SESSION['slug']="$url";
$_SESSION['path']= $ARG['comments'];
}
if($ARG['newsmanager'] == 'on') $_SESSION['path']= $ARG['nmcomments'];
$_SESSION['data']=date("d M Y")." - ".date("G:i");
$_SESSION['pagina']=return_page_title();

if(!isset($nomefile)) {
  NomeFile::$nomefile=$_SESSION['path'].$_SESSION['slug'].".txt";
  }
  language(); // load the language file
}

function showGuestbook($id = null,$title = null){
global $ARG;
global $url;
if($id != null && $ARG['newsmanager'] == 'on') {
 $_SESSION['pageurl']=$ARG['host']."?post=".$id;
 $_SESSION['slug']=$id;
 NomeFile::$nomefile=$_SESSION['path'].$_SESSION['slug'].".txt";
}
$prova=new Guestbook;
$prova->ARGuestbook();
$prova->caricaT();
$prova->visualizzaT(0);
}

function language(){
global $ARG;
    if(!isset($ARG['language']))$ARG['language'] = 'en';
	$lgpath=$ARG['langpath'].$ARG['language'].'.txt';
	if(is_file($lgpath)){
	$file = file($lgpath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach($file as $line){
    $splitted = preg_split("/[|]/", $line, -1, PREG_SPLIT_NO_EMPTY);
	if(count($splitted) != 13)
	  continue;
	Language::$GSbook_header = $splitted[0];
	Language::$GSbook_nick = $splitted[1];
	Language::$GSbook_msg = $splitted[2];
	Language::$GSbook_sendbutton = $splitted[3];
	Language::$GSbook_wrote = $splitted[4];
	Language::$GSbook_empty = $splitted[5];
	Language::$GSbook_nicktext = $splitted[6];
	Language::$GSbook_textarea = $splitted[7];
	Language::$GSbook_writecode = $splitted[8];
	Language::$GSbook_notposts = $splitted[9];
	Language::$GSbook_select = $splitted[10];
	Language::$GSbook_delete = $splitted[11];
	Language::$GSbook_success = $splitted[12];
	}
	}
}

// TAB

//side menu item
add_action($thisfile.'-sidebar','sqr_createSideMenu',array($thisfile, 'settings_page','Settings'));
function settings_page()
{
	global $ARG;
	echo "<font color=red>Settings</font>";
	$dir_lang = opendir($ARG['langpath']);
	$DIR = array();
	while($file=readdir($dir_lang)){
	if($file!="." && $file!="..") {
		array_push($DIR,$file);
	}
	}
	closedir($dir_lang);
	echo "<form name=\"form\" action=\"loadtab.php?id=ARGuestbook&item=settings_page\" method=\"POST\">";
	echo "<BR/>Language:<BR/><select name=language>";
	foreach($DIR as $value){
	$value_ = str_replace(".txt","",$value);
	echo "<option>$value_</option>";
	}
	echo "</select><BR/>";
	$stampa = "Color Picker:";
	?>
	<head>
	<STYLE TYPE="text/css">
.spoiler {
    border:1px solid #ddd;
    width: auto;
	 }
.spoiler .inner {
    padding:1px; }
</style>
</head>
<script type="text/javascript" language="JavaScript">
//<!--
bloc = true;
num = 0;
function hexa(couleur)
{
	if(bloc){
		if(num == 0) document.form.hexval.value = couleur;
		if(num == 1) document.form.hexval2.value = couleur;
		if(num == 2) document.form.hexval3.value = couleur;
		if(num == 3) document.form.hexval4.value = couleur;
	}
}
function palette() { 
document.write("<TABLE border='0' cellpadding='0' cellspacing='0' ><TR>"); 
var h=new Array('00','33','66','99','CC','FF'); 
var col="";
var num=1; 
for(var i=0;i<6;i++) { 
for(var j=0;j<6;j++) { 
for(var k=0;k<6;k++) { 
col="#"+h[i]+h[j]+h[k]; 
document.write("<TD width='10' height='10' bgcolor='"+col+"' onMouseOver=\"hexa('"+col+"')\" onClick=\"if(num<3) { num++;} else { bloc = false; }\"></TD>"); 
} 
} 
document.write("</tr>"); 
} 
document.write("</TABLE>"); 
}

function showSpoiler(obj)
    {
    var inner = obj.parentNode.getElementsByTagName("div")[0];
    if (inner.style.display == "none")
        inner.style.display = "";
    else
        inner.style.display = "none"; }

//-->
</script>
<BR /><div class="spoiler">
<a href="#" onclick="showSpoiler(this); return false"><?php echo $stampa; ?></a>
<div class="inner" style="display:none;">
<SCRIPT language="JavaScript"> 
palette(); 
</SCRIPT>
</div></div>
<?php
//echo "<form name=\"form\">";
echo "<BR />Guestbook header bgcolor:<BR /><input type=\"text\" name=\"hexval\" size=\"9\" value=\"".$ARG['colorgb_head']."\"><BR />";
echo "Guestbook form bgcolor:<BR /><input type=\"text\" name=\"hexval2\" size=\"9\" value=\"".$ARG['colorgb_td']."\"><BR />";
echo "Header post bgcolor:<BR /><input type=\"text\" name=\"hexval3\" size=\"9\" value=\"".$ARG['colortdhead']."\"><BR />";
echo "Post bgcolor:<BR /><input type=\"text\" name=\"hexval4\" size=\"9\" value=\"".$ARG['colortd']."\"><BR />";
echo "<BR />News Manager:&nbsp;<input type=\"radio\" name=\"nm\" value=\"on\"";
if($ARG['newsmanager'] == 'on') echo "CHECKED />";
else echo "/>";
echo "ON";
echo "&nbsp;<input type=\"radio\" name=\"nm\" value=\"off\"";
if($ARG['newsmanager'] == 'off') echo "CHECKED />";
else echo "/>";
echo "OFF";
echo "<BR /><BR /><input type=\"submit\" value=\"ok\" />";
echo "</form>";
if(isset($_POST['language'])){ 
	$ARG['language'] = $_POST['language'];
	$file= fopen($ARG['inipath'],"w");
	if(isset($_POST['hexval'])) $ARG['colorgb_head'] = $_POST['hexval'];
	if(isset($_POST['hexval2'])) $ARG['colorgb_td'] = $_POST['hexval2'];
	if(isset($_POST['hexval3'])) $ARG['colortdhead'] = $_POST['hexval3'];
	if(isset($_POST['hexval4'])) $ARG['colortd'] = $_POST['hexval4'];
	//if(isset($_POST['nm'])) $ARG['newsmanger'] = $_POST['nm'];
	fwrite($file,$ARG['language']."|".$ARG['colortd']."|".$ARG['colortdhead']."|".$ARG['colorgb_td']."|".$ARG['colorgb_head']."|".$_POST['nm']);
	}
}


//SIDEBAR extra hook
add_action($thisfile.'-sidebar-extra', 'squareit_tabloader_extrasidetext', array());
function squareit_tabloader_extrasidetext()
{
	?>
	<div style="text-align:center; font-size:11px;">
	ARGuestbook by <a href="http://www.lafucinadiharad.tk">Alessio_romaTM</a>
	</div>
	<?php
}

// SCHEDA GESTIONE COMMENTI
function squareit_setup_tabloader(){
global $ARG;
language();

if($ARG['newsmanager'] == 'off'){
$dir_pages = opendir(GSDATAPAGESPATH);
$dir_commenti = opendir($ARG['comments']);
}
else {
$dir_pages = opendir(GSDATAPATH.'posts/');
$dir_commenti = opendir($ARG['nmcomments']);
}
$DIR = array();
$DIR2 = array();
while($file=readdir($dir_pages)){
if($file!="." && $file!="..") {
		if(strpos($file, ".xml") == true) $file=str_replace(".xml",".txt",$file);
		array_push($DIR2,$file);
	}
}
while($file=readdir($dir_commenti)){
	if($file!="." && $file!="..") {
		array_push($DIR,$file);
	}
	}
closedir($dir_commenti);
closedir($dir_pages);
$DIR = delete_pages($DIR,$DIR2);	
echo "<font color=\"red\" size=\"3\">ARGuestbook</font><BR/><BR/>";
if(count($DIR) == 0) echo Language::$GSbook_notposts;
else {echo "<table class=\"highlight\">";
echo "<form action=loadtab.php?id=ARGuestbook&item=ARGuestbook method=\"POST\">";

foreach($DIR as $value){

echo "<tr><td>";
$value_ = str_replace(".txt","",$value);
if($ARG['newsmanager'] == 'on'){
$file = GSDATAPATH.'posts/'.$value_.'.xml';
$data = getXML($file);
$title = strip_tags(strip_decode($data->title)); //stripslashes(htmlspecialchars_decode($data->title, ENT_QUOTES));
}
else $title = $value_; 
echo "<input type=\"radio\" name=\"nomepag\" value=\"$value\" /> ".$title."<BR/>";
echo "</td></tr>";
}
echo "</table>";
echo "<input type=\"submit\" value=\"".Language::$GSbook_select."\" /><BR/>";
echo '</form>';

}
$prova2=new Guestbook;
if(isset($_POST['nomepag'])) {
if($ARG['newsmanager'] == 'off') NomeFile::$nomefile = $ARG['comments'].$_POST['nomepag'];
else NomeFile::$nomefile = $ARG['nmcomments'].$_POST['nomepag'];
$junkposts=array();
$prova2->caricaT();
$prova2->visualizzaT(1);
}
$post = $_POST['post'];
if(isset($post)){
$junkposts = array();
foreach($post as $a){
if(!empty($a)) array_push($junkposts,$a);
}
delete_junkposts($junkposts);
unset($_POST['post']);
echo "<BR/>".Language::$GSbook_success;
}
}

// elimina i commenti selezionati
function delete_junkposts($array){
global $ARG;
NomeFile::$nomefile = $_SESSION['nomefile'];
$new_posts = array();
$posts = new Guestbook;
$posts->caricaT();
$flag = 0;
$dim = count($posts->listacommenti);
for($i=0;$i<$dim;$i++){
$flag = 0;
foreach($array as $b) {
	if($i == $b-1) {
		$flag = 1;
		break;
	}
}
if($flag == 0) array_push($new_posts,$posts->listacommenti[$i]);
}
$posts->listacommenti = $new_posts;
$posts->rewrite();
}

function delete_pages($array_posts,$array_pages){
global $ARG;
$array_app = array();
$flag = 0;
foreach($array_posts as $posts){
	$flag = 0;
	foreach($array_pages as $page){
	if($posts == $page) {
	array_push($array_app,$posts);
	$flag = 1;
	break;
	}
	}
	if($flag == 0){
	$path = $ARG['comments'].$posts;
	unlink($path);
	}
}
return $array_app;
}

// END TAB

function guestbook_check($n = null,$excerpt = false)
{
	global $data_index;
	global $ARG;
	if($n == null && $ARG['newsmanager']=='off'){
	if (strpos($data_index->content, '{guestbook') === false)
	{
		return false;
	}
	$data_index->content = str_replace("{guestbook}","",$data_index->content);
	add_action('content-bottom','showGuestbook',array());
	}
	else if (strpos($n, '{guestbook') === false)
	{
		return false;
	}
	$n = str_replace("{guestbook}","",$n);
	if($excerpt == true) return false; //se si tratta dell'anteprima dell'articolo il guestbook non viene visualizzato
	if($ARG['newsmanager'] == 'on') return true; //se nell'articolo и presente la stringa {guestbook} e l'opzione и su on
	else return false;
}



// CLASSE GUESTBOOK

class Guestbook {

public $listacommenti = NULL;
public $nickname;
public $commento;
public $data;
public $ip;
public $smilesArray;

public function __construct(){
 $this->listacommenti= array();
}


function ARGuestbook() {
global $ARG;
$form_action=$ARG['formact'];
$nicktext=Language::$GSbook_nicktext;
$_SESSION['nicktext']=$nicktext;
$_SESSION['textarea']=Language::$GSbook_textarea;
//$antispam=rand(1000,9999);
$a=rand(1,5);
$b=rand(1,5);
//$_SESSION['antispam']=$antispam;
$_SESSION['a'] = $a;
$_SESSION['b'] = $b;
?>
<STYLE TYPE="text/css">
 .gb_td{
  height: 180px;
  width: 400px;
  background-color: <?php echo $ARG['colorgb_td']; ?>;
  border-left: 1px solid;
  border-right: 1px solid;
  border-bottom: 1px solid;
  border-radius: 0px 0px 10px 10px;
  -khtml-border-radius: 0px 0px 10px 10px;
  -moz-border-radius: 0px 0px 10px 10px;
  -webkit-border-radius: 0px 0px 10px 10px;
 }
 .gb_td_header{
  height: 20px;
  width: 400px;
  border-top: 1px solid;
  border-left: 1px solid;
  border-right: 1px solid;
  background-color: <?php echo $ARG['colorgb_head']; ?>;
  border-radius: 10px 10px 0px 0px;
  -khtml-border-radius: 10px 10px 0px 0px;
  -moz-border-radius: 10px 10px 0px 0px;
  -webkit-border-radius: 10px 10px 0px 0px;
 }

</style>
<?php
// FORM
echo "<center>";
echo "<div class=\"gb_td_header\" valign=\"center\" align=\"center\"><B>".Language::$GSbook_header."</B></div>";
echo "<div class=\"gb_td\" valign=\"center\" align=\"center\">";
echo "<form name=\"modulo\" action=\"$form_action\" method=\"POST\">";
echo Language::$GSbook_nick.":<BR />";
echo "<input type=\"text\" name=\"nick\" maxlength=\"20\" value=\"$nicktext\"><BR />";
echo Language::$GSbook_msg.":<BR />";
echo "<TEXTAREA NAME=\"commenti\" ROWS=\"3\" COLS=\"30\">".Language::$GSbook_textarea."</TEXTAREA><BR />";
echo "<i>".Language::$GSbook_writecode."<b> $a,$b</b></i> =";
echo "<input type=\"text\" name=\"code\" maxlength=\"4\" size=\"4\">";
echo "<input type='submit' value=".Language::$GSbook_sendbutton."><br />";
echo "<FONT SIZE='1'>ARGuestbook ".VERSION."</FONT>";
echo "</form>";
echo "</div></center>";
}

//FUNZIONI

//inserimento commenti
function inserisci_commento(){
$obj=new Commento($this->nickname,$this->commento,$this->data,$this->ip);
array_push($this->listacommenti, $obj);
}

//conta commenti
function conta_commenti(){
return(count($this->listacommenti));
}

//carica con data
function caricaT(){
if(isset(NomeFile::$nomefile)) {
$file = file(NomeFile::$nomefile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//if(is_file($file)) echo "esiste";
foreach($file as $line)
{
    $splitted = preg_split("/[|]/", $line, -1, PREG_SPLIT_NO_EMPTY); 
	$this->nickname=$splitted[0];
	$this->commento=$splitted[1];
	$this->data=$splitted[2];
	$this->ip=$splitted[3];
   if(count($splitted) != 4)
	  continue; //ignore malformed lines
   $this->inserisci_commento();
}
}
}

//visualizza commenti con data
function visualizzaT($n){
global $ARG; 
?>
<head>
<script type="text/javascript" src="<?php echo $SITEURL.'ARGuestbook_Files/'; ?>virtualpaginate.js" ></script>
<STYLE TYPE="text/css">
.paginationstyle{ /*Style for demo pagination divs*/
width: 250px;
text-align: center;
padding: 2px 0;
margin: 10px 0;
}

.paginationstyle select{ /*Style for demo pagination divs' select menu*/
border: 1px solid navy;
margin: 0 15px;
}

.paginationstyle a{ /*Pagination links style*/
padding: 0 5px;
text-decoration: none;
border: 1px solid black;
color: navy;
background-color: white;
}

.paginationstyle a:hover, .paginationstyle a.selected{
color: #000;
background-color: #FEE496;
}

.paginationstyle a.disabled, .paginationstyle a.disabled:hover{ /*Style for "disabled" previous or next link*/
background-color: white;
cursor: default;
color: #929292;
border-color: transparent;
}

.paginationstyle a.imglinks{ /*Pagination Image links style (class="imglinks") */
border: 0;
padding: 0;
}

.paginationstyle a.imglinks img{
vertical-align: bottom;
border: 0;
}

.paginationstyle a.imglinks a:hover{
background: none;
}

.paginationstyle .flatview a:hover, .paginationstyle .flatview a.selected{ /*Pagination div "flatview" links style*/
color: #000;
background-color: yellow;
}

.div_bottom{
  height: auto;
  width: 400px;
  border-left: 1px solid;
  border-right: 1px solid;
  border-bottom: 1px solid;
  margin-bottom:5px;
  background-color: <?php echo $ARG['colortd']; ?>;
  border-radius: 0px 0px 10px 10px;
  -moz-border-radius: 0px 0px 10px 10px;
  -webkit-border-radius: 0px 0px 10px 10px;
 }
.div_header{
  display: table-cell;
  height: 20px;
  width: 400px;
   border-left: 1px solid;
  border-right: 1px solid;
  border-top: 1px solid;
  text-align: left;
  vertical-align: bottom;
  background-color: <?php echo $ARG['colortdhead']; ?>;
  border-radius: 10px 10px 0px 0px;
  -moz-border-radius: 10px 10px 0px 0px;
  -webkit-border-radius: 10px 10px 0px 0px;
 }

</style>
</head>
<?php
$this->check_smile();
if($n==0) $this->view_smiles();
if($this->listacommenti) {
$cont = count($this->listacommenti);
if($n==1) $_SESSION['nomefile'] = NomeFile::$nomefile;
if($n==1) echo "<form action=loadtab.php?id=ARGuestbook&item=ARGuestbook method=\"POST\">";
$listacomm_rev = array_reverse($this->listacommenti);
echo "<center>";
echo "<div id=\"gallerypaginate2\" class=\"paginationstyle\"></div>";
foreach($listacomm_rev as $commento){
echo '<div class="virtualpage hidepiece" style="margin-bottom:5px;">';
echo "<div class=\"div_header\">";
if($n==1) echo "&nbsp;<input type = checkbox name=\"post[$cont]\" value=\"$cont\">";
echo "<B>&nbsp;#$cont ".$commento->nick."</B> ".Language::$GSbook_wrote.":</div>";
echo "<div class=\"div_bottom\"><BR />&#171;".$commento->comm."&#187;"."<font size=1><b><BR /><center>".$commento->data."</center></b></font>";
echo "</div></div>";
$cont--;
}
?>
<div id="gallerypaginate" class="paginationstyle">
<?php if(count($this->listacommenti) > 5) ?>
<a href="#" rel="previous">Prev</a> <span class="flatview"></span> <a href="#" rel="next">Next</a>
</div>
</center>
<script type="text/javascript">

var gallery=new virtualpaginate({
	piececlass: "virtualpage", //class of container for each piece of content
	piececontainer: 'div', //container element type (ie: "div", "p" etc)
	pieces_per_page: 5, //Pieces of content to show per page (1=1 piece, 2=2 pieces etc)
	defaultpage: 0, //Default page selected (0=1st page, 1=2nd page etc). Persistence if enabled overrides this setting.
	wraparound: false,
	persist: false //Remember last viewed page and recall it when user returns within a browser session?
})

gallery.buildpagination(["gallerypaginate", "gallerypaginate2"])

</script>
<?php
//echo "</table></center>";
if($n==1) echo "<center><input type=\"submit\" value=\"".Language::$GSbook_delete."\" /></center><br />"; //tasto elimina da tab admin
}
else {
echo "<center>".Language::$GSbook_empty."</center>";
if(file_exists(NomeFile::$nomefile)) unlink(NomeFile::$nomefile);
}
if($n == 0) echo "<BR />";
}

function rewrite(){
$p_file = fopen(NomeFile::$nomefile,"w");
foreach($this->listacommenti as $commento){
$scrivicommento = fwrite($p_file,$commento->nick."|".$commento->comm."|".$commento->data."|".$commento->ip."\r\n");
}
fclose($p_file);
}

function check_smile(){
$emoticons = new emoticons();
$emoticons->load_emoticons();
$this->smilesArray = $emoticons->smilesArray;
foreach($this->listacommenti as $commento){
	foreach($this->smilesArray as $smile){
		if(strpos($commento->comm, $smile->name) == true)
			{
			$commento->comm = str_replace($smile->name,$smile->src,$commento->comm);
			}
	
	}
}
}

function view_smiles(){
if(count($this->smilesArray)!=0){ // if the array of smiles is not empty
echo "<center><font size=\"1\"><b>SMILIES</b></font><BR />";
$cont=0;
$limit=10;
echo "<table>";
foreach($this->smilesArray as $smile){
if($cont == $limit){
echo "</tr><tr>";
$cont = 0;
} 
?>
<script language="javascript">
 function AddSmile(smile){
 document.forms['modulo'].elements['commenti'].value= document.forms['modulo'].elements['commenti'].value + smile;
 }
</script>
<?php
if($cont == 0) echo "<tr>";
echo "<td><a href=\"javascript:AddSmile('$smile->name')\">".$smile->src."</a></td>"; // show the smile
$cont++;
}
echo "</tr></table></center>";
}
}

}


?>
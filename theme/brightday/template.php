<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }

/****************************************************
*
* @File: 		tempate.php
* @Package:		GetSimple
* @Action:		BrightDay theme for the GetSimple 3.0
*
*****************************************************/

# Get this theme's settings based on what was entered within it's plugin. 
# This function is in functions.php 
Innovation_Settings();

# Include the header template
include('header.php'); 
?>
	
<div class="wrapper clearfix">
	<article>
		<section>
			<h1><?php get_page_title(); ?></h1>
			<?php get_page_content(); ?>
		</section>
	</article>
</div>
<?php include('footer.php'); ?>

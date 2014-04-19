<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); } 

/****************************************************
*
* @File: 		footer.php
* @Package:		GetSimple
* @Action:		BrightDay theme for the GetSimple 3.0
*
*****************************************************/
?>

<footer class="clearfix" >
	<?php get_footer(); ?>
 	<div class="wrapper">
		<div class="left">
			&copy; 2010-<?php echo date('Y'); ?>
			<a href="<?php get_site_url(); ?>" ><?php get_site_name(); ?></a>
			<br><?php get_component('tagline'); ?>
			<br><div class="social">
			    <div class="social-item">
			      <a href="http://www.facebook.com/sharer.php?u=http://skibinshow.kz" target="_blank">
				<img src="data/uploads/social/facebook.gif" alt="facebook" title="Поделиться в Facebook"></a>
			    </div>
			    <div class="social-item">
			      <a href="http://vkontakte.ru/share.php?url=http://skibinshow.kz" target="_blank">
				<img src="data/uploads/social/vkontakte.gif" alt="ВКонтакте" title="Поделиться ВКонтакте"></a>
			    </div>
			    <div class="social-item">
			      <a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=http://skibinshow.kz&st.comments=<?php get_site_name(); ?> - <?php get_component('tagline'); ?>" target="_blank">
				<img src="data/uploads/social/odnoklassniki.gif" alt="Одноклассники" title="Поделиться в Одноклассниках"></a>
			    </div>
			    <div class="social-item">
			      <a href="http://connect.mail.ru/share?url=http://skibinshow.kz" target="_blank">
				<img src="data/uploads/social/mailru.gif" alt="Мой мир" title="Поделиться в Моём Мире"></a>
			    </div>
			    <div class="social-item">
			      <a href="http://twitter.com/share?url=http://skibinshow.kz" target="_blank">
				 <img src="data/uploads/social/twitter.gif" alt="Twitter" title="Поделиться в Twitter"></a>
			    </div>
			</div>
		</div>
		<div class="right">
			<a href="http://zvezdochet.kz/webstudio/" target="_blank"><img src="data/uploads/banner/zvezdochet.gif" alt="Веб-студия Звездочёт" title="Веб-студия Звездочёт"></a>
		</div>
	</div>
</footer>
</body>
</html>

<?php if(!$home_select) { ?>
<ul id="ullistcat" style="border-top:5px solid #ED2123;">
  <?php for ($j = 0; $j < sizeof($cats); $j++) { ?>
	  <li><a href="<?php echo $cats[$j]['href']; ?>"><?php echo $cats[$j]['name']; ?></a></li>
  <?php } ?>
	<li><a href="<?php echo $dichvu; ?>">Dịch vụ</a></li>
	<li><a href="<?php echo $tintuc; ?>">Tin tức</a></li>
</ul>
<?php } ?>
<div id="footer">
  <div class="div1">
	<div class="fd_title">
		<h3><?php echo $footer_title; ?></h3>
	</div>
	<div class="fd_middle">
	  <?php echo str_replace('http://widgets.amung.us/tab.js','',$footer); ?>
	</div>
  </div>
  <div class="div4">
  <div class="div2">
	<div class="ft_menu">
		<a class="ft_top"></a>
	</div>
	<div class="ft_logo">
		<a href="<?php echo $home; ?>"><img height="35" src="<?php echo $logo; ?>" /></a>
	</div>
  </div>
  <div class="ft_copyright"><?php echo $text_powered; ?></div>
  <div class="div3">
	<a onclick="location.href='<?php echo $href_full; ?>'"><span class="ic_com"><img src="<?php echo $icon_comp; ?>" /><span>Xem phiên bản đầy đủ</span></span></a>
  </div>
  </div>
</div>
</div>
</div>
<script type='text/javascript'>$('.ft_top').click(function(){$('body,html').animate({scrollTop:0},800);});</script>
</body></html>
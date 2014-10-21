<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/home.css" media="all" />
<script src="catalog/view/javascript/jquery.touchslider.js"></script>

<div id="content">
  <div class="menu_home">
	<table  cellspacing="0" cellpadding="0">
	<?php for ($i = 0; $i < sizeof($categories) && $i < 5; $i = $i + 3) { ?>
		<tr>
			<?php for ($j = $i; $j < ($i + 3); $j++) { ?>
				<td align="center" class="td<?php echo $j; ?>">
				<?php if (isset($categories[$j])) { ?>
				  <a class="mh_url" href="<?php echo $categories[$j]['href']; ?>">
					<span class="mh_image"><img src="<?php echo $categories[$j]['image']; ?>" alt="<?php echo $categories[$j]['name']; ?>" /></span>
					<span class="mh_name"><?php echo $categories[$j]['name']; ?></span>
				  </a>
				<?php } else { ?>
				  <a class="mh_url" href="<?php echo $dichvu_url; ?>">
					<span class="mh_image"><img src="<?php echo $dichvu_image; ?>" alt="Dịch vụ" /></span>
					<span class="mh_name">Dịch vụ</span>
				  </a>
				<?php } ?>
				</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</table>
  </div>
</div>

<div id="cthome">
	<div class="cth_left">
		<a href="product/khuyenmai/">Khuyến mãi</a>
	</div>
	<div class="cth_right">
		<a href="thong-tin/34/hd-mua-tra-gop-ppf.html">Trả góp</a>
	</div>	
</div>

<div id="cthome" class="iconhome">
	<div class="cth_left iconmxh">
		<div class="icon_facebook"><a href=""></a></div>
		<div class="icon_youtube"><a href=""></a></div>
		<div class="icon_forum"><a href="">Diễn đàn</a></div>
	</div>
	<div class="cth_right goldenone">
		<a href="san-pham/371/golden-one/"></a>
	</div>	
</div>

<script>
jQuery(function($) {
    $(".ct_slide").touchSlider({
		autoplay: true
	});
});
</script>
<div id="content">
  <div class="middle home">
	<div class="ct_slide">
		<div class="touchslider-viewport">
		  <div>
			<?php foreach ($toplefts as $topleft) { ?>
			  <div class="touchslider-item">
			    <div class="ct_image">
				<?php if($topleft['linkwebsite']) { ?>
					<a href="<?php echo str_replace('www','m',$topleft['linkwebsite']); ?>"><img src='<?php echo $topleft['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $topleft['image']; ?>' />
				<?php } ?>
				</div>
			  </div>
			<?php } ?>
		  </div>
		</div>
	</div>
  </div>
</div>


<script>
jQuery(function($) {
    $(".ct_news").touchSlider({/*options*/});
});
</script>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1>Tin tức mới</h1>
    </div>
  </div>
  <div class="middle home">
	<div class="ct_news">
		<a class="ct_xemthem" href="<?php echo $tintuc; ?>">Xem thêm</a>
		<div class="touchslider-viewport">
		  <div>
			<?php foreach ($newss as $news) { ?>
				<div class="touchslider-item">
					<a href="<?php echo $news['href']; ?>">
						<div class="ct_image"><img alt="<?php echo $news['title']; ?>" src="<?php echo $news['image']; ?>" /></div>
						<div class="ct_name"><?php echo $news['title']; ?>
						<?php if($news['date_added']) { ?><span class="ct_date_added"> - <?php echo $news['date_added']; ?></span><?php } ?></div>
					</a>
				</div>
			<?php } ?>
		  </div>
		</div>

		<div>
			<span class="touchslider-prev"></span>
			<span class="touchslider-next"></span>
		</div>
	</div>
  </div>
</div>
<?php foreach ($danhmuchomes as $danhmuchome) { ?>
<?php if($danhmuchome['products']) { ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $danhmuchome['name']; ?> </h1>
    </div>
  </div>
  <div class="middle home">
    <div class="listpro divh<?php echo $danhmuchome['danhmuchome_id']; ?>">
	  <div class="touchslider-viewport"><div>
		<?php for ($i = 0; $i < sizeof($danhmuchome['products']); $i = $i + 2) { ?>
		  <div class="touchslider-item">
			<?php for ($j = $i; $j < ($i + 2); $j++) { ?>
			<?php if (isset($danhmuchome['products'][$j])) { ?>
				<div class="tdproduct">
				  <a href="<?php echo $danhmuchome['products'][$j]['href']; ?>"><img class="tdimage" src="<?php echo $danhmuchome['products'][$j]['thumb']; ?>"  alt="<?php echo $danhmuchome['products'][$j]['name']; ?>" /></a>
				  <div class="product_name"><a href="<?php echo $danhmuchome['products'][$j]['href']; ?>"><?php echo $danhmuchome['products'][$j]['name']; ?></a></div>
				  <?php if ($display_price) { ?>
				  <?php if (!$danhmuchome['products'][$j]['special']) { ?>
				  <span style="color: #F00; font-weight: bold;"><?php echo $danhmuchome['products'][$j]['price']; ?></span><br />
				  <?php } else { ?>
				  <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $danhmuchome['products'][$j]['price']; ?></span><br/>
				  <span style="color: #F00;"><?php echo $danhmuchome['products'][$j]['special']; ?></span> <br/>
				  <?php } ?>
				  <?php } ?>
				</div>
			  <?php } ?>
			<?php } ?>
		  </div>
		<?php } ?>
      </div></div>
	  
	  <div>
		<span class="touchslider-prev"></span>
		<span class="touchslider-next"></span>
	  </div>
	</div>
  </div>
</div>
<script>
jQuery(function($) {
    $(".listpro.divh<?php echo $danhmuchome['danhmuchome_id']; ?>").touchSlider({/*options*/});
});
</script>
<?php } ?>
<?php } ?>
<?php echo $footer; ?> 
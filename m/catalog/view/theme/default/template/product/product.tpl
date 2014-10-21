<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/product.css" media="all" />
<script src="catalog/view/javascript/jquery.touchslider.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/tab.js"></script>
<div id="content-top">
<div id="content" style="margin-bottom:0;" class="cttop_pro">
  <div class="middle">
	<h1 class="product"><?php echo $heading_title; ?></h1>
    <div class="product_info">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td align="center" width="50%" valign="top">
			<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" style="margin-bottom: 3px;" />
              <?php if ($display_price) { ?>
				<div class="pi_price">
					<b>Giá bán:</b>
					<?php if (!$special) { ?>
					  <span style="color: #F00; font-weight: bold;"><?php echo $price; ?></span>
					<?php } else { ?>
					  <span style="color: #900; font-weight: bold;text-decoration: line-through;"><?php echo $price; ?></span> <br/>
					  <span style="color: #F00;font-weight: bold;"><?php echo $special; ?></span>
					<?php } ?>
				</div>
              <?php } ?>
			  <?php if ($tax_price) { ?>
				<div class="pi_price_vat">
					<b>Giá VAT: </b><span style="color: #00F; font-weight: bold;"><?php echo $tax_price; ?></span>
				</div>
			  <?php } ?>
			  <?php if (!$tax_price) { ?>
				<?php if($text_tax) { ?><span class="price_info"><?php echo $text_tax; ?></span><?php } ?>
			  <?php } ?>
		  </td>
          <td style="vertical-align: top;padding-right:10px;">
			<ul class="pi_listinfo">
				<li class="pi_stock">
					<a class="pi_a"><font class="pi_font"><?php echo $stock; ?></font><span class="pi_span">Tại cửa hàng TechOne</span></a>
					<div class="pi_li_desce">
						<div class="pi_middle">
							<div class="pi_close pitop"></div>
							<?php echo $contact; ?>
						</div>
					</div>
				</li>
				<li class="pi_khuyenmai">
					<a class="pi_a"><font class="pi_font">Khuyến mãi</font><span class="pi_span">Quà tặng cho sp này</span></a>
					<div class="pi_li_desce">
						<div class="pi_middle">
							<div class="pi_close pitop"></div>
							<?php echo $khuyenmai; ?>
						</div>
					</div>
				</li>
				<li class="pi_online">
					<a class="pi_a"><font class="pi_font">Mua hàng online</font><span class="pi_span">Gọi: <?php echo $telephone; ?></span></a>
				</li>
			    <?php foreach ($informations as $information) { ?>
					<li class="pi_information">
						<a class="pi_a"><font class="pi_font"><?php echo $information['title']; ?></font><span class="pi_span">Thông tin mua hàng</span></a>
						<div class="pi_li_desce">
							<div class="pi_middle">
								<div class="pi_close pitop"></div>
								<?php echo $information['description']; ?>
							</div>
						</div>
					</li>
			    <?php } ?>
			</ul>
		  </td>
        </tr>
      </table>
    </div>
	</div>
</div>	
<script language="javascript"> 
$('.pi_listinfo li').click(function(event) {
	if ($(this).hasClass('active')) {
		$('.pi_listinfo li').removeClass('active');
	} else {
		$(this).addClass('active');
	}
	return false;
});
$('.pi_listinfo li .pi_li_desce').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$('.pi_listinfo li').removeClass('active');
});
$('.pi_close').click(function() {
	$('.pi_listinfo li').removeClass('active');
});
</script>
<?php if($khuyenmaihotro_code) { ?>
<div class="khuyenmaihotro">
	<div class="kmht_top">
		<?php echo $khuyenmaihotro_title; ?>
	</div>
	<div class="kmht_bottom">
		<?php echo $khuyenmaihotro_code; ?>
	</div>
</div>
<?php } ?>
<ul id="ullistcat" style="margin-bottom:10px;" class="tabs">
	<?php if($description) { ?><li><a tab=".tab_tongquan">Tổng quan</a></li><?php } ?>
	<?php if($kythuat) { ?><li><a tab=".tab_kythuat">Thông số kỹ thuật</a></li><?php } ?>
	<?php if($images) { ?><li><a tab=".tab_image">Hình ảnh</a></li><?php } ?>
	<?php if($videos) { ?><li><a tab=".tab_video">Video</a></li><?php } ?>
	<?php if ($phukiens) { ?><li><a tab=".tab_phukien">Phụ kiện tương thích</a></li><?php } ?>
	<?php if ($products) { ?><li><a tab=".tab_related">Sản phẩm cùng loại</a></li><?php } ?>
</ul>
<script type='text/javascript'>
	$('#ullistcat li a').click(function(event) {
		$('html, body').animate({ scrollTop: $('#content-middle').offset().top}, 'slow');
	});
</script>
</div>
<div id="content-middle">
<?php if($description) { ?>
<div id="content" class="tab_tongquan tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3><?php echo $tab_description; ?></h3>
    </div>
  </div>
<div class="middle cm_info item_pro">  
<?php echo $description; ?>
</div>
</div>
<?php } ?>

<?php if($kythuat) { ?>
<div id="content" class="tab_kythuat tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3><?php echo $tab_kythuat; ?></h3>
    </div>
  </div>
<div class="middle cm_info item_pro" style="padding:10px;">
<?php echo str_replace('background-color','rel',str_replace('width="','max-width="',str_replace('height="','max-height="',str_replace('height:','max-height:',str_replace('width:','max-width:',$kythuat))))); ?>
</div>
</div>
<?php } ?>

<?php if($images) { ?>
<div id="content" class="tab_image tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3><?php echo $tab_image; ?></h3>
    </div>
  </div>
<div class="middle cm_info" style="padding:10px;">
	<?php foreach ($images as $image) { ?>
	<img class="ti_image" src="<?php echo $image['thumb']; ?>" alt="<?php echo $heading_title; ?>" />
	<?php } ?>
</div>
</div>
<?php } ?>

<?php if($videos) { ?>
<div id="content" class="tab_video tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3>Video</h3>
    </div>
  </div>
<div class="middle" style="padding:10px;">
	<?php foreach ($videos as $video) { ?>
		<div class="ti_videos">
			<object width="100%" style="max-width:560px;display:block;margin:auto;" height="315"><param name="movie" value="http://www.youtube.com/v/<?php echo $video['video_id']; ?>?hl=vi_VN&amp;version=3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?php echo $video['video_id']; ?>?hl=vi_VN&amp;version=3" type="application/x-shockwave-flash" style="max-width:560px;" width="100%" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>
		</div>
	<?php } ?>
</div>
</div>
<?php } ?>

<?php if ($phukiens) { ?>
<div id="content" class="tab_phukien tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3>Phụ kiện</h3>
    </div>
  </div>
<div class="middle">
    <div class="listpro lpk">
	  <div class="touchslider-viewport"><div>
		<?php for ($i = 0; $i < sizeof($phukiens); $i = $i + 2) { ?>
		  <div class="touchslider-item">
			<?php for ($j = $i; $j < ($i + 2); $j++) { ?>
			<?php if (isset($phukiens[$j])) { ?>
				<div class="tdproduct">
				  <a href="<?php echo $phukiens[$j]['href']; ?>"><img class="tdimage" src="<?php echo $phukiens[$j]['thumb']; ?>"  alt="<?php echo $phukiens[$j]['name']; ?>" /></a>
				  <div class="product_name"><a href="<?php echo $phukiens[$j]['href']; ?>"><?php echo $phukiens[$j]['name']; ?></a></div>
				  <?php if ($display_price) { ?>
				  <?php if (!$phukiens[$j]['special']) { ?>
				  <span style="color: #F00; font-weight: bold;"><?php echo $phukiens[$j]['price']; ?></span><br />
				  <?php } else { ?>
				  <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $phukiens[$j]['price']; ?></span><br/>
				  <span style="color: #F00;"><?php echo $phukiens[$j]['special']; ?></span> <br/>
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
<?php } ?>

<?php if ($products) { ?>
<div id="content" class="tab_related tab_page">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h3>SP Cùng loại</h3>
    </div>
  </div>
<div class="middle">
	<a class="ct_xemthem cxpro" href="<?php echo $xemtatca; ?>">Xem thêm</a>
    <div class="listpro">
	  <div class="touchslider-viewport"><div>
		<?php for ($i = 0; $i < sizeof($products); $i = $i + 2) { ?>
		  <div class="touchslider-item">
			<?php for ($j = $i; $j < ($i + 2); $j++) { ?>
			<?php if (isset($products[$j])) { ?>
				<div class="tdproduct">
				  <a href="<?php echo $products[$j]['href']; ?>"><img class="tdimage" src="<?php echo $products[$j]['thumb']; ?>"  alt="<?php echo $products[$j]['name']; ?>" /></a>
				  <div class="product_name"><a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a></div>
				  <?php if ($display_price) { ?>
				  <?php if (!$products[$j]['special']) { ?>
				  <span style="color: #F00; font-weight: bold;"><?php echo $products[$j]['price']; ?></span><br />
				  <?php } else { ?>
				  <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span><br/>
				  <span style="color: #F00;"><?php echo $products[$j]['special']; ?></span> <br/>
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
<?php } ?>
<script>
jQuery(function($) {
    $(".listpro").touchSlider({/*options*/});
	$(".listpro.lpk").touchSlider({/*options*/});
});
</script>
<div class="icon_back">
	<a class="back_menu"><span>Trở lại</span></a>
	<a class="back_top"><span>Lên trên</span></a>
</div>
<script type='text/javascript'>
	$('.back_top').click(function(){$('body,html').animate({scrollTop:0},800);});
	$('.back_menu').click(function(event) {
		$('html, body').animate({ scrollTop: $('#ullistcat').offset().top}, 'slow');
	});
</script>
</div>
<?php if($tags) { ?>
	<div class="pro_tags">
	<?php for ($i=0; $i < sizeof($tags); $i++) { ?>
		<?php if($i==0 && $tags[$i]['keyword']) { echo "<b>Tags:</b>"; } elseif($i!=0) { echo ", "; } ?>
		<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['keyword']; ?></a>
	<?php } ?>
	</div>
<?php } ?>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?> 
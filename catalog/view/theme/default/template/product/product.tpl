<?php echo $header; ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.iosslider.js"></script>
<div id="colp_right">
    <div class="crpdiv pinfo">
		<div class="pi_content">
		<div class="ptitle"><h1><?php echo $heading_title; ?></h1></div>
		<div class="pi_mtn">
			<span class="piStock"><b><?php echo $text_availability; ?></b> <?php echo $stock; ?></span>
		</div>
		<?php if ($zones) { ?>
		<div class="pzone">
		<span>Giá bán tại</span>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="zone_form">
          <div class="pswitcher">
            <?php foreach ($zones as $zone) { ?>
            <?php if ($zone['code'] == $zone_code) { ?>
            <div class="selected"><a><?php echo $zone['name']; ?></a></div>
            <?php } ?>
            <?php } ?>
            <div class="option">
              <?php foreach ($zones as $zone) { ?>
              <a onclick="$('input[name=\'zone_code\']').attr('value', '<?php echo $zone['code']; ?>'); $('#zone_form').submit();"><?php echo $zone['name']; ?></a>
              <?php } ?>
            </div>
          </div>
          <input type="hidden" name="zone_code" value="" />
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        </form>
		</div>
<script language="javascript"> 
$('.pzone .pswitcher').click(function(event) {
	if ($('.pzone .pswitcher').hasClass('active')) {
		$('.pzone .pswitcher').removeClass('active');
	} else {
		$('.pzone .pswitcher').addClass('active');
	}
	return false;
});
$('.pzone .pswitcher .option').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$(".pzone .pswitcher").removeClass("active");
});
</script>
		<?php } ?>
		<div class="pprice">
			<?php if ($display_price) { ?>
			<?php if (!$special_price) { ?>
			  <span class="price"><?php echo $price; ?></span><br/> <span class="ptax">(<?php echo $tax; ?>)</span>
			  <?php } else { ?>
			  <span class="special"><?php echo $price; ?></span><br/>
			  <span class="price"><?php echo $special_price; ?></span><br/> <span class="ptax">(<?php echo $tax; ?>)</span>
			  <?php } ?>
			<?php } ?>
		</div>
		<div class="pManuWar">
			<?php if ($manufacturer) { ?>
				<b><?php echo $text_manufacturer; ?></b> <a target="_blank" href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a> / 
			<?php } ?>
			<?php if ($warranty) { ?>
				<b>Bảo hành:</b>
					<?php if(strlen($warranty) > 2) { ?>
						<?php echo $warranty; ?>
					<?php } else { ?>
						<?php echo $warranty; ?> tháng
					<?php } ?>
			<?php } ?>
		</div>
		<?php if ($promotion) { ?>
		  <div class="piPromotion"><div class="piTprom"><?php echo $total_promotion; ?></div> <div class="piProm"><?php echo $promotion; ?></div></div>
		<?php } ?>
		</div>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="product">
		  <?php if ($display_price) { ?>
		  <?php if ($options) { ?>
		  <b><?php echo $text_options; ?></b><br />
		  <div class="content">
			<table style="width: 100%;">
			  <?php foreach ($options as $option) { ?>
			  <tr>
				<td><?php echo $option['name']; ?>:<br />
				  <select name="option[<?php echo $option['option_id']; ?>]">
					<?php foreach ($option['option_value'] as $option_value) { ?>
					<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
					<?php if ($option_value['price']) { ?>
					<?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
					<?php } ?>
					</option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <?php } ?>
			</table>
		  </div>
		  <?php } ?>
		  <?php } ?>
		  <div class="pinfo_cart">
			<a onclick="<?php echo $checkout; ?>" class="colorboxCart btcart btcColor1 btcspan">MUA NGAY, GIAO TẬN NƠI<span>(xem hàng, không mua không sao)</span></a>
			<a class="btcart btcColor2 btcspan" href="info/68/huong-dan-mua-tra-gop.html">MUA TRẢ GÓP<span>(từ 570.000₫/tháng)</span></a>
		  </div>
		  <div class="pihotline">Gọi điện thoại đặt mua: <span><?php echo $hotline; ?></span></div>
		</form>
	</div>
	<div id="pdinformation">
		<ul>
		  <?php foreach ($informations as $information) { ?>
			<li><a target="_blank" href="<?php if($information['link']){ echo $information['link']; } else { echo $information['href']; } ?>"><?php echo $information['name']; ?></a></li>
		  <?php } ?>
		</ul>
	</div>
	
	<?php if ($phukiens) { ?>
	<div class="phukien">
		<h4 class="pk_title">Phụ kiện <strong><?php echo $heading_title; ?></strong></h4>
		<ul class="listPinfo">
		  <?php foreach ($phukiens as $product) { ?>
			<li class="lpili">
				<div class="lpidiv">
				  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"  alt="<?php echo $product['name']; ?>" /></a>
				  <div class="ltitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				  <?php if ($display_price) { ?>
					  <div class="lprice">
					  <?php if (!$product['special']) { ?>
					  <span class="price"><?php echo $product['price']; ?></span><br />
					  <?php } else { ?>
					  <span class="lspecial"><?php echo $product['price']; ?></span><br/>
					  <span class="price"><?php echo $product['special']; ?></span>
					  <?php } ?>
					  </div>
				  <?php } ?>
				</div>
			</li>
		  <?php } ?>
		</ul>
	</div>
	 <?php } ?>
	 
    <?php if ($products) { ?>
	<div class="pRelated">
		<h4 class="pk_title">Cùng loại <strong><?php echo $heading_title; ?></strong></h4>
		<ul class="listPinfo">
		  <?php foreach ($products as $product) { ?>
			<li class="lpili">
				<div class="lpidiv">
				  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"  alt="<?php echo $product['name']; ?>" /></a>
				  <div class="ltitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				  <?php if ($display_price) { ?>
					  <div class="lprice">
					  <?php if (!$product['special']) { ?>
					  <span class="price"><?php echo $product['price']; ?></span><br />
					  <?php } else { ?>
					  <span class="lspecial"><?php echo $product['price']; ?></span><br/>
					  <span class="price"><?php echo $product['special']; ?></span>
					  <?php } ?>
					  </div>
				  <?php } ?>
				</div>
			</li>
		  <?php } ?>
		</ul>
		<p class="pbutton" align="right"><a href="<?php echo $xemtatca; ?>" class="prxemthem"><span><?php echo $text_xemtatca; ?> »</span></a></p>
	</div>
    <?php } ?>
	
	<?php if($khuyenmaihotro_code) { ?>
	<div class="khuyenmaihotro">
		<h4 class="pk_title">
			<?php echo $khuyenmaihotro_title; ?>
		</h4>
		<div class="kmht_bottom">
			<?php echo $khuyenmaihotro_code; ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if($tags) { ?>
	<div class="ptags">
		<?php for ($i=0; $i < sizeof($tags); $i++) { ?>
			<?php if($i==0 && $tags[$i]['keyword']) { echo "<b>Tags:</b>"; } elseif($i!=0) { echo ", "; } ?>
			<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['keyword']; ?></a>
		<?php } ?>
	</div>
	<?php } ?>
</div>		  
			  
<div id="content" class="col_right">
	<div class="ctp_slider">
	  <script type="text/javascript" charset="utf-8">	
		 $(document).ready(function() { 
			$('.csSlider').oneByOne({
				className: 'oneByOne',	             
				easeType: 'random',
				slideShow: false
			});  
		 });
	  </script> 
	  <div class="ctptab">
		<div class="csliderct" id="tabI_slider">
		<?php if($slideshows) { ?>
		<div class="csSlider">
		  <?php foreach ($slideshows as $slideshow) { ?>
			<div class="oneByOne_item">     							
				<img alt="<?php echo $slideshow['title_image']; ?>" src="<?php echo $slideshow['image']; ?>" class="bigImage" data-animate="bounceIn" />
				<span class="slide2Txt1">
					<p><strong><?php echo $slideshow['title_image']; ?></strong></p>
					<p><?php echo $slideshow['description_image']; ?></p>
				</span>
			</div>
		  <?php } ?>		
		</div>
		<?php } else { ?>
			<img src="<?php echo $thumb; ?>" />
		<?php } ?>
		</div>
		<?php if($images) { ?>
        <div class="cImagect" id="tabI_image">
		  
			<div class = "doubleSlider-1 cImgSlider-1">	
				<div class = "slider">
					<?php for($i = 0; $i < sizeof($images); $i++) { ?>
						<div class="item item<?php echo $i+1; ?>">
							<img alt="<?php echo $heading_title; ?>" src="<?php echo $images[$i]['popup']; ?>" />
						</div>
					<?php } ?>
				</div>
			</div>
			<div class = "doubleSliderNextButton"></div>
			<div class = "doubleSliderPrevButton"></div>
			
			<div class="dbs2">
			<div class = "NextButton"></div>
			<div class = "doubleSlider-2 cImgSlider-2">
				<div class = "slider">
					<?php for($i = 0; $i < sizeof($images); $i++) { ?>
						<div class="buttonsl item<?php echo $i+1; ?>">
							<div class="bordersl"><img alt="<?php echo $heading_title; ?>" src="<?php echo $images[$i]['thumb']; ?>" /></div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class = "PrevButton"></div>
			</div>
		  
			<script type="text/javascript">
				$(document).ready(function() {
				
					$('.cImgSlider-1').iosSlider({
						scrollbar: false,
						snapToChildren: true,
						desktopClickDrag: true,
						infiniteSlider: false,
						navPrevSelector: $('.doubleSliderPrevButton'),
						navNextSelector: $('.doubleSliderNextButton'),
						scrollbarHeight: '2',
						scrollbarBorderRadius: '0',
						scrollbarOpacity: '0.5',
						onSliderLoaded: doubleSlider2Load,
						onSlideChange: doubleSlider2Load
					});
					
					$('.cImgSlider-2 .buttonsl').each(function(i) {
					
						$(this).bind('click', function() {

							$('.cImgSlider-1').iosSlider('goToSlide', i+1);
							
						});
					
					});
					
					$('.cImgSlider-2').iosSlider({
						navPrevSelector: $('.PrevButton'),
						navNextSelector: $('.NextButton'),
						desktopClickDrag: true,
						snapToChildren: true,
						snapSlideCenter: false,
						infiniteSlider: false,
					});
					
					function doubleSlider2Load(args) {
						
						//currentSlide = args.currentSlideNumber;
						$('.cImgSlider-2').iosSlider('goToSlide', args.currentSlideNumber);
						
						/* update indicator */
						$('.cImgSlider-2 .buttonsl').removeClass('selected');
						$('.cImgSlider-2 .buttonsl:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
						
					}
					
				});
			</script>
		</div>
		<?php } ?>
		
		<?php if($videos) { ?>
        <div class="cVideoct" id="tabI_video">
		  
			<div class = "cVidTab">	
				<?php $i = 0; foreach($videos as $video) { ?>
					<?php $i++; ?>
					<div class="videos" id="vds<?php echo $i; ?>">
						<object width="700" height="390"><param name="movie" value="http://www.youtube.com/v/<?php echo $video['video_id']; ?>?hl=vi_VN&amp;version=3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?php echo $video['video_id']; ?>?hl=vi_VN&amp;version=3" type="application/x-shockwave-flash" width="700" height="390" allowscriptaccess="always" allowfullscreen="true"></embed></object>
					</div>
				<?php } ?>
			</div>
			<div class="dbs2">
			<div class = "VNextButton"></div>
			<div class = "doubleSlider-2 cVidSlider">
				<div class = "slider">
					<?php $i = 0; foreach($videos as $video) { ?>
						<?php $i++; ?>
						<div class="buttonsl">
							<div tab="#vds<?php echo $i; ?>" class="bordersl cvtab"><img alt="<?php echo $heading_title; ?>" src="<?php echo $video['iconVid']; ?>" />
							<div class="iconplay"></div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class = "VPrevButton"></div>
			</div>
			<script type="text/javascript">
				$(document).ready(function() {
				
					$('.cVidSlider').iosSlider({
						scrollbar: false,
						snapToChildren: true,
						desktopClickDrag: true,
						scrollbarMargin: '5px 40px 0 40px',
						scrollbarBorderRadius: 0,
						scrollbarHeight: '2px',
						navPrevSelector: $('.VPrevButton'),
						navNextSelector: $('.VNextButton')
					});
					
				});
				$.tabs('.cVidSlider .cvtab'); 
			</script>
		</div>
		<?php } ?>
		
	  </div>
		
		<div class="tabCb">
			<div tab="#tabI_slider" class="piSlider tabItem"></div>
			
			<?php if($images) { ?>
			<div tab="#tabI_image" class="piImage tabItem">
				<img src="<?php echo $iconImg; ?>" alt="<?php echo $heading_title; ?>" id="pImg" />
				<span class="piItext">Hình ảnh</span>
				<span class="iconArrow"></span>
			</div>
			<?php } ?>
			
			<?php if($videos) { ?>
			<div tab="#tabI_video" class="piVideo tabItem">
				<img src="<?php echo $iconVid; ?>" alt="<?php echo $heading_title; ?>" id="pVid" />
				<div class="iconplay2"></div>
				<span class="piVtext">Video</span>
				<span class="iconArrow"></span>
			</div>
			<?php } ?>
			
			<div class="piAverage">
				<img src="catalog/view/theme/default/image/stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" style="margin-top: 2px;" /> <br/><a class="pia_text"><?php echo $review; ?> bình luận</a>
				<script type="text/javascript"><!--
				$('.piAverage').click(function(event) {
					$('html, body').animate({ scrollTop: $('#tab_review').offset().top -0}, 1000);
				});
				//--></script>
			</div>
			<div class="piDesc">
				<div class="viewDesc">Xem đánh giá chi tiết</div>
				<div class="CloseDesc">Đóng đánh giá chi tiết</div>
			</div>
			<script type="text/javascript"><!--
			$('.piDesc .viewDesc').click(function(event) {
				$('#tab_description').addClass('active');
				$('.piDesc').addClass('selected');
				$('html, body').animate({ scrollTop: $('.piDesc').offset().top -0}, 700);
			});
			
			$('.piDesc .CloseDesc').click(function(event) {
				$('#tab_description').removeClass('active');
				$('.piDesc').removeClass('selected');
			});
			
			$('a.CloseDesc').click(function(event) {
				$('#tab_description').removeClass('active');
				$('.piDesc').removeClass('selected');
			});
			//--></script>
		</div>
	</div>

    <?php if($description) { ?><div id="tab_description" class="ctpage"><span class="cdarrow"></span><?php echo $description; ?><a class="CloseDesc">Đóng đánh giá chi tiết</a></div><?php } ?>
	
	<script type="text/javascript"><!--
	$('a.CloseDesc').click(function(event) {
		$('#tab_description').removeClass('active');
		$('.piDesc').removeClass('selected');
		
		$('html, body').animate({ scrollTop: $('.piDesc').offset().top -0}, 1000);
	});
	//--></script>
	
	<div id="tab_brief_description" class="ctpage">
	  <div class="tbd_technical">
		<div class="tbd_title"><b>Thông số, cấu hình</b> <?php echo $heading_title; ?></div>
		<table border="0" cellpadding="0" cellspacing="0" class="tbdrutgon" style="width: 100%;">
		<?php $ii = 0; ?>
		<?php foreach($attributes as $attribute) { ?>
			<?php $ii++; ?>
			<tr class="<?php echo 'tbd' . $ii%2; ?>">
				<td class="tbdrg_name"><?php echo $attribute['name']; ?></td>
				<td class="tbdrg_text"><?php echo $attribute['text']; ?></td>
			</tr>
		<?php } ?>
		</table>
		<div class="tbd_cauhinh">
			<a class="tbda_show">Xem cấu hình chi tiết</a>
			<a class="tbda_close">Đóng cấu hình chi tiết</a>
		</div>
		<script type="text/javascript"><!--
		$('.tbd_cauhinh .tbda_show').click(function(event) {
			$('#tab_technical_description').addClass('active');
			$('.tbd_cauhinh').addClass('selected');
			$('html, body').animate({ scrollTop: $('.tbd_cauhinh').offset().top -0}, 700);
		});
		
		$('.tbd_cauhinh .tbda_close').click(function(event) {
			$('#tab_technical_description').removeClass('active');
			$('.tbd_cauhinh').removeClass('selected');
		});
		
		$('a.tbda_close').click(function(event) {
			$('#tab_technical_description').removeClass('active');
			$('.tbd_cauhinh').removeClass('selected');
		});
		//--></script>
	  </div>
	  
	  <div class="tbd_fullbox">
		<?php if($brief_description) { ?>
		<div class="tbd_title"><b>Bộ sản phẩm đi kèm</b> <?php echo $heading_title; ?></div>
		<?php echo $brief_description; ?>
		<?php } ?>
	  </div>
	  
	</div>
	
	<div id="tab_technical_description" class="ctpage">
		<span class="cdarrow"></span>
		<?php if($technical_description) { ?><div class="top_tdesc"><?php echo $technical_description; ?></div><?php } ?>
		<table border="0" cellpadding="0" cellspacing="0" class="agtb" style="width: 100%;">
			<tbody>
			<?php for($i = 0; $i < sizeof($attribute_groups); $i++) { ?>
			  <tr>
				<td valign="top" class="agtdl<?php echo ' agtlTop' . ($i+1); ?>"><?php echo $attribute_groups[$i]['name']; ?></td>
				<td class="agtdr<?php echo ' agtrTop' . ($i+1); ?>"><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" class="atb"><tbody>
				<?php $attribute = $attribute_groups[$i]['attributes']; ?>
				<?php for($j = 0; $j < sizeof($attribute); $j++) { ?>
					<tr>
						<td class="atdl<?php echo ' atlTop' . ($j+1); ?>"><?php echo $attribute[$j]['name']; ?></td>
						<td class="atdr<?php echo ' atrTop' . ($j+1); ?>"><?php echo $attribute[$j]['text']; ?></td>
					</tr>
				<?php } ?>
				</tbody></table></td>
			  </tr>
			<?php } ?>
			</tbody>
		</table>
		<a class="tbdClose">Đóng cấu hình chi tiết</a>
	<script type="text/javascript"><!--
	$('a.tbdClose').click(function(event) {
		$('#tab_technical_description').removeClass('active');
		$('.tbd_cauhinh').removeClass('selected');
		
		$('html, body').animate({ scrollTop: $('.tbd_cauhinh').offset().top -0}, 1000);
	});
	//--></script>
	</div>

    <div id="tab_review" class="ctpage">
      <div class="tbd_title"><b>Bình luận và đánh giá </b> <?php echo $heading_title; ?></div>
      <div class="content binhluan">
		<?php if($logged) { ?>
			<div class="puser">
				<div class="pu_avatar"><img alt="<?php echo $customername; ?>" title="<?php echo $customername; ?>" src="image/avatar/avatar_default.png" /></div>
			</div>
			<div class="ptextarea"><textarea name="text" class="p_review haslogin"></textarea></div>
			
			<div class="reviewBt">
			<input type="hidden" name="name" value="<?php echo $customername; ?>" />
		<?php } else { ?>
			<textarea name="text" class="p_review"></textarea>
			
			<div class="reviewBt">
				<div class="rbname">
					<div class="rbntext"><b><?php echo $entry_name; ?></b></div>
					<div class="rbninput"><input type="text" name="name" value="" /></div>
				</div>
		<?php } ?>
        <div class="rbrating">
			<div class="rbrtext"><b><?php echo $entry_rating; ?></b></div>
			<div class="rbrinput"><span><?php echo $entry_bad; ?></span>
			<input type="radio" name="rating" value="1" style="margin: 0;" />
			<input type="radio" name="rating" value="2" style="margin: 0;" />
			<input type="radio" name="rating" value="3" style="margin: 0;" />
			<input type="radio" name="rating" value="4" style="margin: 0;" />
			<input type="radio" name="rating" value="5" style="margin: 0;" />
			<span><?php echo $entry_good; ?></span></div>
        </div>
		<div class="rbcontinue">
			<div class="rbcaptcha"><div class="rbctext"><b>Nhập mã xác thực:</b></div>
			<input class="rbcinput" type="text" name="captcha" value="" />
			<div class="loadingcaptcha"><img src="index.php?route=product/product/captcha" id="captcha" /></div>
			<a onclick="review();" class="button"><span>Gửi bình luận</span></a>
		</div>
		</div>
		</div>
	  <script type="text/javascript" charset="utf-8">	
		$( ".p_review" ).focus(function(event) {
		  $('.binhluan').addClass('selected');
		});
		$('.binhluan').click(function(event) {
			event.stopPropagation();
		});
		$(document).click(function() {
			$('.binhluan').removeClass('selected');
		});
	  </script>
	  </div>
	  <span id="review_title"></span>
      <div id="review"></div>
      </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.cproduct').colorbox({
		overlayClose: false,
		escKey: false,
		fixed: false,
		opacity: 0.5
	});
});
//--></script>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');
		
	$('#review').load(this.href);
	
	$('#review').slideDown('slow');
	
	return false;
});
	
function rand(length,current){
 current = current ? current : '';
 return length ? rand( --length , "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz".charAt( Math.floor( Math.random() * 60 ) ) + current ) : current;
}

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

function review() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#review_button').attr('disabled', 'disabled');
			$('#review_title').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#review_button').attr('disabled', '');
			$('.wait').remove();
		},
		success: function(data) {
			if (data.error) {
				$('.loadingcaptcha').html('<img src="index.php?route=product/product/captcha&r='+ rand(5) +'" />');
				$('#review_title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review_title').after('<div class="success">' + data.success + '</div>');
				$('.loadingcaptcha').html('<img src="index.php?route=product/product/captcha'+ rand(5) +'" />');
				$('.binhluan').removeClass('selected');
				$('input[name=\'name\']').val('');
				$('input[name=\'captcha\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']:checked').removeAttr('checked');
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorboxCart').colorbox({
		overlayClose: false,
		escKey: false,
		initialHeight: "598",
		initialWidth: "689",
		opacity: 0.5
	});
});
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabCb .tabItem'); 
//--></script>
<?php echo $footer; ?> 
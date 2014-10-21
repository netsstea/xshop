<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/templateSP1.css" />
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1 itemprop="name"><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <div style="width: 100%;">
     <div class="ctproduct">
        <ul class="ctpul">
          <li class="ctpli pimage">
			<div class="cp_image">
			<?php if($imgSP1) { ?>
				<?php for ($i = 0; $i < sizeof($imgSP1); $i++) { ?>
					<a id="topimg_<?php echo $i; ?>" onclick="<?php echo $imgSP1[$i]['img500x500']; ?>" class="cproduct<?php if($i == 0) { echo ' active'; } ?>" rel="fancybox"><img src="<?php echo $imgSP1[$i]['img300x300']; ?>" alt="<?php echo $heading_title; ?>" /></a>
				<?php } ?>
			<?php } else { ?>
				<a onclick="<?php echo $img500x500; ?>" class="cproduct active"><img src="<?php echo $img300x300; ?>" alt="<?php echo $heading_title; ?>" /></a>
			<?php } ?>
			</div>
			<?php if($imgSP1) { ?>
			<div class="cp_images">
			
			  <ul class="cis_ul">		
				<?php for ($i = 0; $i < sizeof($imgSP1); $i = $i + 4) { ?>
					<li>
					  <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
						<?php if (isset($imgSP1[$j])) { ?>
							<a id="img_<?php echo $j; ?>" class="<?php if($j == $i) { echo 'imgl'; } ?><?php if($j == 0) { echo ' active'; } ?>"><img src="<?php echo $imgSP1[$j]['thumb']; ?>" alt="<?php echo $heading_title; ?>" /></a>
						<?php } ?>
					  <?php } ?>
					</li>
				<?php } ?>
			  </ul>
			  
			</div>
			<?php } ?>
			<script type="text/javascript"><!--
			$(document).ready(function(){
				$('.cis_ul').bxSlider({
				speed: 500,
				displaySlideQty: 1,
				moveSlideQty: 1,
				autoStart: false
				});
			});
			$(document).ready(function () {
				$('.cis_ul li a').each(function(i, element) {
					var idimage = $(element).attr("id");
					$('#' + idimage).click(function () {
						$('.cproduct').removeClass('active');
						$('.cis_ul li a').removeClass('active');
						$('#top' + idimage).addClass('active');
						$(this).addClass('active');
					});
				});
			});
			//--></script>
		  </li>
          <li class="ctpli pinfo">
			<div class="pi_content" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<div class="pi_mtn">
				<?php if ($manufacturer) { ?>
                <b><?php echo $text_manufacturer; ?></b> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a> 
				<?php } ?>
				<?php if ($warranty) { ?>
                 <?php if ($manufacturer) { echo ' / '; } ?> <b>Bảo hành:</b> <?php echo $warranty; ?> tháng
				<?php } ?>
			</div>
			<div class="pi_average">
				<img src="catalog/view/theme/default/image/stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" style="margin-top: 2px;" /> <a class="pia_text"><?php echo $review; ?> đánh giá</a>
				<script type="text/javascript"><!--
				$('.pia_text').click(function(event) {
					$(document).ready(function(){$('#tabreview').click();});
					$('html, body').animate({ scrollTop: $('.tabs').offset().top}, 'slow');
				});
				//--></script>
			</div>
			<div class="pprice">
				<?php if ($display_price) { ?>
                <?php if (!$special_price) { ?>
                  <span class="price" itemprop="price"><?php echo str_replace('đ','</span><span class="price">đ',$price); ?></span><meta itemprop="priceCurrency" content="VND" />
                  <?php } else { ?>
                  <span class="special"><?php echo $price; ?></span><br/>
				  <span class="price" itemprop="price"><?php echo str_replace('đ','</span><span class="price">đ',$special_price); ?></span><meta itemprop="priceCurrency" content="VND" />
                  <?php } ?>
				<?php } ?>
			</div>
			<div class="pi_model"><b><?php echo $text_model; ?></b> <?php echo $model; ?> / <b><?php echo $text_availability; ?></b> <link itemprop="availability" href="http://schema.org/InStock" /><?php echo $stock; ?></div>
			<?php if ($promotion) { ?>
				<div class="pi_khuyenmai">
					<div class="pi_km_new"></div>
					<div class="pi_km_title"><span>Khuyến mãi</span></div>
					<div class="pi_km_info"><?php echo $promotion; ?></div>
				</div>
			<?php } ?>
			</div>
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
              <?php if ($display_price) { ?>
              <?php if ($discounts) { ?>
              <b><?php echo $text_discount; ?></b><br />
              <div class="content">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: right;"><b><?php echo $text_order_quantity; ?></b></td>
                    <td style="text-align: right;"><b><?php echo $text_price_per_item; ?></b></td>
                  </tr>
                  <?php foreach ($discounts as $discount) { ?>
                  <tr>
                    <td style="text-align: right;"><?php echo $discount['quantity']; ?></td>
                    <td style="text-align: right;"><?php echo $discount['price']; ?></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
              <?php } ?>
              <?php } ?>
              <div class="pinfo_cart">
				<a onclick="<?php echo $checkout; ?>" class="buttonCart">MUA NGAY</a>
			  </div>
			<script type="text/javascript"><!--
			$(document).ready(function() {
				$('.buttonCart').colorbox({
					overlayClose: false,
					escKey: false,
					initialHeight: "598",
					initialWidth: "689",
					opacity: 0.5
				});
			});
			//--></script>
			<?php if($brief_description) { ?>
			<div class="pi_bdesc">
				<div class="pibdnb">Đặc điểm nổi bật:</div>
				<h2 class="product"><?php echo $brief_description; ?></h2>
				<a class="pibdesc_xt">Xem thêm »</a>
				<script type="text/javascript"><!--
				$('.pibdesc_xt').click(function(event) {
					$(document).ready(function(){$('#tabdescription').click();});
					$('html, body').animate({ scrollTop: $('.tabs').offset().top}, 'slow');
				});
				//--></script>
			</div>
			<?php } ?>
			</li>
        </ul>
    </div>
    </div>
  </div>
</div>
<div id="content">
	<div class="tab_product">
    <div class="tabs">
		<?php if($description) { ?><a tab="#tab_description" id="tabdescription"><?php echo $tab_description; ?></a><?php } ?>
		<?php if($technical_description) { ?><a tab="#tab_technical_description"><?php echo $tab_technical_description; ?></a><?php } ?>
		<a tab="#tab_related"><?php echo $tab_related; ?></a>
	</div>
	</div>
    <?php if($description) { ?><div id="tab_description" class="tab_page"><?php echo $description; ?></div><?php } ?>
	<?php if($technical_description) { ?><div id="tab_technical_description" class="tab_page"><?php echo $technical_description; ?></div><?php } ?>
    <div id="tab_related" class="tab_page">
      <?php if ($products) { ?>
		<ul class="list">
		  <?php foreach ($products as $product) { ?>
			<li class="lli">
				<a class="lmhref" href="<?php echo $product['href']; ?>">
				<div class="lpro">
				  <img src="<?php echo $product['thumb']; ?>"  alt="<?php echo $product['name']; ?>" />
				  
				<h3 class="lmname"><?php echo $product['name']; ?></h3>
				<?php if ($display_price) { ?>
				  <div class="lprice">
				  <?php if (!$product['special']) { ?>
				  <span class="price"><?php echo $product['price']; ?></span>
				  <?php } else { ?>
				  <span class="price"><?php echo $product['special']; ?></span> <span class="lspecial"><?php echo $product['price']; ?></span>
				  <?php } ?>
				  </div>
				<?php } ?>
				<?php if($product['promotion']) { ?><div class="lmprom"><?php echo $product['promotion']; ?></div><?php } ?>
				</div>
				
				<?php if ($product['attribute_data']) { ?>
				<div class="lmore">
					<div class="lbdesc"><ul>
					  <?php foreach($product['attribute_data'] as $attribute_data) { ?>
						<li><?php echo $attribute_data['name']; ?>: <?php echo $attribute_data['text']; ?></li>
					  <?php } ?>
					</ul></div>
				</div>
				<?php } ?>
				</a>
			</li>
		  <?php } ?>
		</ul>
		<div class="btxemthem">
		  <a href="<?php echo $xemtatca; ?>"><?php echo $text_xemtatca; ?> »</a>
		</div>
      <?php } else { ?>
		<div class="content2" style="margin-top:10px;"><?php echo $text_no_related; ?></div>
      <?php } ?>
	</div>
    <div class="ctpage">
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
	<?php if($tags) { ?>
		<?php for ($i=0; $i < sizeof($tags); $i++) { ?>
			<?php if($i==0 && $tags[$i]['keyword']) { echo "<b>Tags:</b>"; } elseif($i!=0) { echo ", "; } ?>
			<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['keyword']; ?></a>
		<?php } ?>
	<?php } ?>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.cproduct').colorbox({
		overlayClose: false,
		escKey: false,
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
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?> 
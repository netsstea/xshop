<?php if(!$text_error) { ?>
<div id="cartpopup" class="<?php if(sizeof($products) == 2) { echo ' pro_count_2'; } elseif(sizeof($products) > 2) { echo ' pro_count_3'; } ?>">
	<div class="cartpopuptitle"><span class="cp_count"></span>Giỏ hàng
	<div class="div_cart_tb">
    <?php if ($error_warning) { ?>
		<div class="warning wpcart"><div class="warring_arrow"></div><?php echo $error_warning; ?></div>
    <?php } else { ?>
		<div class="text_thongbao"></div>
	<?php } ?>
	<div class="tbc_close"></div>
	</div>
	</div>
	<div id="quantity">
      <table class="cart">
        <tr>
          <th class="column_remove" align="left"><?php echo $column_remove; ?></th>
          <th class="column_image" align="center"><?php echo $column_image; ?></th>
          <th class="column_name" align="center"><?php echo $column_name; ?></th>
          <th class="column_model" align="center"><?php echo $column_model; ?></th>
		  <?php if($display_price) { ?>
          <th class="column_price" align="right"><?php echo $column_price; ?></th>
		  <?php } ?>
          <th class="column_quantity" align="right"><?php echo $column_quantity; ?></th>
		  <?php if($display_price) { ?>
          <th class="column_total" align="right"><?php echo $column_total; ?></th>
		  <?php } ?>
        </tr>
	  </table>
	  <div class="cartcontent<?php if(sizeof($products) > 3) { echo ' cpproducts'; } ?>">
	  <table class="cart">
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        <tr class="<?php echo $class; ?>">
          <td class="column_remove" align="left"><span class="cart_remove" id="remove_<?php echo $product['key']; ?>">&nbsp;</span></td>
          <td class="column_image" align="center"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
          <td class="column_name" align="left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if (!$product['stock']) { ?>
            <span style="color: #FF0000; font-weight: bold;">***</span>
            <?php } ?>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div></td>
          <td class="column_model" align="center"><?php echo $product['model']; ?></td>
		  <?php if($display_price) { ?>
          <td class="column_price" align="right"><?php echo $product['price']; ?></td>
		  <?php } ?>
          <td class="column_quantity" align="right">
			<select name="quantity[<?php echo $product['key']; ?>]" title="Số lượng" style="width:50px;">
				<option <?php if($product['quantity'] == 1) { echo ' selected=""'; } ?> value="1">1</option>
				<option <?php if($product['quantity'] == 2) { echo ' selected=""'; } ?> value="2">2</option>
				<option <?php if($product['quantity'] == 3) { echo ' selected=""'; } ?> value="3">3</option>
				<option <?php if($product['quantity'] == 4) { echo ' selected=""'; } ?> value="4">4</option>
				<option <?php if($product['quantity'] == 5) { echo ' selected=""'; } ?> value="5">5</option>
				<?php if($product['quantity'] > 5) { ?>
				<option <?php if($product['quantity'] > 5) { echo ' selected=""'; } ?> value="$product['quantity']"><?php echo $product['quantity']; ?></option>
				<?php } ?>
            </select>
			</td>
		  <?php if($display_price) { ?>
          <td class="column_total" align="right"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>
	  </div>
	</div>
	  <?php if($display_price) { ?>
	  <div style="width: 100%; display: inline-block;height: 75px;">
			<table style="float: right; display: inline-block;border-collapse: collapse;">
			  <?php $i=0; ?>
			  <?php foreach ($totals as $total) { ?>
			  <?php $i++; ?>
			  <tr class="total<?php if(sizeof($totals) == $i) { echo 'end';} else { echo 'start';} ?>">
				<td align="left" class="total_left"><?php echo $total['title']; ?></td>
				<td align="right" class="total_right"><?php echo $total['text']; ?></td>
			  </tr>
			  <?php } ?>
			  <tr>
			  <td colspan="2" align="right"><div class="cartvat">Bao gồm VAT</div></td>
			  </tr>
			</table>
	  </div>
	  <?php } ?>
      <div class="cartbutton">
        <table>
          <tr>
            <td align="left"><a onclick="$('#quantity').submit();" class="button" id="button_update"><span><?php echo $button_update; ?></span></a></td>
            <td align="center"><a id="button_shopping" class="button"><span><?php echo $button_shopping; ?></span></a></td>
            <td align="right"><a onclick="<?php echo $checkout; ?>" class="colorbox button"><span><?php echo $button_order; ?></span></a></td>
          </tr>
        </table>
      </div>
</div>
<?php } else { ?>
    <div class="cart_empty"><?php echo $text_error; ?></div>
<?php } ?>
<script type="text/javascript"><!--
function getUrlParam(name) {
  var name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  if (results == null)
	return "";
  else
	return results[1];
}
$(document).ready(function () {	
	$('#button_update').click(function () {
		$.ajax({
			type: 'post',
			url: 'index.php?route=checkout/cart/cart_count',
			dataType: 'html',
			data: $('#quantity :input'),
			complete: function() {
				$('.success').remove();
			},
			success: function (html) {
				$('.mr_cart_count').html(html);
				$('.cp_count').load('index.php?route=checkout/cart/cart_count');
				$(this).colorbox({
					opacity: 0.5,
					open: true,
					href: 'checkout/cart&view=cartpopup&tb=update'
				});
				$('.text_thongbao').after('<div class="success spcart"><div class="success_arrow"></div>Thành công! Sản phẩm bạn vừa chọn đã thêm vào giỏ hàng!</div>');
			}
		});			
	});
	$('.cart_remove').live('click', function () {
		$(this).removeClass('cart_remove').addClass('cart_remove_loading');
		$.ajax({
			type: 'post',
			url: 'index.php?route=checkout/cart/cart_count',
			dataType: 'html',
			data: 'remove=' + this.id,
			complete: function() {
				$('.success').remove();
			},
			success: function (html) {
				$('.mr_cart_count').html(html);
				$('.cp_count').load('index.php?route=checkout/cart/cart_count');
				$(this).colorbox({
					opacity: 0.5,
					open: true,
					href: 'checkout/cart&view=cartpopup&tb=update'
				});
				$('.text_thongbao').after('<div class="success spcart"><div class="success_arrow"></div>Thành công! Giỏ hàng của bạn đã được cập nhật!</div>');
				if (getUrlParam('route').indexOf('checkout') != -1) {
					window.location.reload();
				}
			}
		});
	});	
});
//--></script>
<script type="text/javascript"><!--
$('.cp_count').load('index.php?route=checkout/cart/cart_count');
$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
$('#button_shopping').click(function() {
	$(document).ready(function(){$('#cboxClose').click();});
});
setTimeout("$(document).ready(function(){$('.tbc_close').click();})",10000);
$('.tbc_close').click(function() {
	$('.success.spcart').remove();
	$('.warning.wpcart').remove();
});
<?php if ($tb == 'success') { ?>
$('.text_thongbao').after('<div class="success spcart"><div class="success_arrow"></div>Thành công! Sản phẩm bạn vừa chọn đã thêm vào giỏ hàng!</div>');
<?php } elseif($tb == 'update') { ?>
$('.text_thongbao').after('<div class="success spcart"><div class="success_arrow"></div>Thành công! Giỏ hàng của bạn đã được cập nhật!</div>');
<?php } ?>
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: false,
		escKey: false,
		opacity: 0.5
	});
});
//--></script>
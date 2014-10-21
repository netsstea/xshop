<div id="cartpopup">
	<div class="cartpopuptitle iconorder">
		<?php echo $heading_title; ?>
		<div class="div_cart_tb">
			<div id="warning"></div>
			<div class="tbc_close"></div>
		</div>
	</div>
	<div class="popupmiddle ctp_content">
		<b class="bod_title"><?php echo $text_your_details; ?></b>
		<?php if (!$logged) { ?>
		<div class="content dangky">
			<table>
			  <tr>
				<td width="150"><?php echo $entry_customername; ?></td>
				<td><input id="customername" type="text" name="customername" /><span class="required">(<font>*</font>)</span>
				</td>
			  </tr>
			  <tr>
				<td><?php echo $entry_email; ?></td>
				<td><input id="email" type="text" name="email" /><span class="required">(<font>*</font>)</span>
				</td>
			  </tr>
			  <tr>
				<td><?php echo $entry_telephone; ?></td>
				<td><input id="telephone" type="text" name="telephone" /><span class="required">(<font>*</font>)</span>
				</td>
			  </tr>
			</table>
		</div>
		<?php } else { ?>
		<div class="content dangky">
			<table>
			  <tr>
				<td width="150"><?php echo $entry_customername; ?></td>
				<td><input id="customername" type="text" name="customername" value="<?php echo $customername; ?>" /><span class="required">(<font>*</font>)</span>
				</td>
			  </tr>
			  <tr>
				<td><?php echo $entry_email; ?></td>
				<td><input id="email" type="text" name="email" value="<?php echo $email; ?>" /><span class="required">(<font>*</font>)</span>
			  
				</td>
			  </tr>
			  <tr>
				<td><?php echo $entry_telephone; ?></td>
				<td><input id="telephone" type="text" name="telephone" value="<?php echo $telephone; ?>" /><span class="required">(<font>*</font>)</span>
				</td>
			  </tr>
			</table>
		</div>
		<?php } ?>
		<div class="address dangky" style="margin-bottom:10px;">
		  <b class="bod_title"><?php echo $text_your_address; ?></b>
		  <div class="content">
			<table>
			  <tr>
				<td width="150"><?php echo $entry_address; ?></td>
				<td><input type="text" name="address" value="<?php echo $address; ?>" /></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_city; ?></td>
				<td><input type="text" name="city" value="<?php echo $city; ?>" /></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_country; ?></td>
				<td><select name="country_id" id="country_id" onchange="$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');">
					<option value="FALSE"><?php echo $text_select; ?></option>
					<?php foreach ($countries as $country) { ?>
					<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_zone; ?></td>
				<td><select name="zone_id">
				  </select></td>
			  </tr>
			</table>
		  </div>
		</div>
      <?php if ($shipping_methods) { ?>
      <b class="bod_title"><?php echo $text_shipping_method; ?></b>
      <div class="content">
        <table width="100%" cellpadding="0">
          <?php foreach ($shipping_methods as $shipping_method) { ?>
          <?php if (!$shipping_method['error']) { ?>
          <?php foreach ($shipping_method['quote'] as $quote) { ?>
          <tr>
            <td width="1">
			<label for="<?php echo $quote['id']; ?>">
                <input type="radio" name="shipping_method" value="<?php echo $quote['title']; ?>" id="<?php echo $quote['id']; ?>" style="margin: 0px;" />
              </label></td>
            <td width="534"><label for="<?php echo $quote['id']; ?>" style="cursor: pointer;"><?php echo $quote['title']; ?></label></td>
            <td width="50" align="right"><?php if($quote['text'] != "0 VNĐ") { ?><label for="<?php echo $quote['id']; ?>" style="cursor: pointer;"><?php echo $quote['text']; ?></label><?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
	  
      <?php if ($payment_methods) { ?>
      <b class="bod_title"><?php echo $text_payment_method; ?></b>
      <div class="content">
        <table width="100%" cellpadding="0">
          <?php foreach ($payment_methods as $payment_method) { ?>
          <tr>
            <td width="1">
				<input type="radio" name="payment_method" value="<?php echo $payment_method['id']; ?>#<?php echo $payment_method['title']; ?>" id="<?php echo $payment_method['id']; ?>" style="margin: 0px;" />
			</td>
            <td><label for="<?php echo $payment_method['id']; ?>" style="cursor: pointer;"><?php echo str_replace('NgânLượng.vn','<span class="icon-nl">NgânLượng.vn</span>',$payment_method['title']); ?></label></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
		<div class="cartbutton">
		<table>
		  <tr>
			<td align="left"><a id="cart_order" onclick="checkout/cart&view=cartpopup"><span>Xem lại giỏ hàng</span></a></td>
			<td align="right"><a onclick="confirm();" class="button"><span><?php echo $button_confirm; ?></span></a></td>
		  </tr>
		</table>
		</div>
	</div>
<script type="text/javascript"><!--
$('select[name=\'zone_id\']').load('index.php?route=checkout/cart/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
$('#country_id').attr('value', '<?php echo $country_id; ?>');
<?php if(!$getProducts) { ?>
	window.location.reload();
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function confirm() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=checkout/cart/confirm',
		dataType: 'json',
		data: 'customername=' + encodeURIComponent($('input[name=\'customername\'][id=\'customername\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email\'][id=\'email\']').val()) + '&telephone=' + encodeURIComponent($('input[name=\'telephone\'][id=\'telephone\']').val()) + '&address=' + encodeURIComponent($('input[name=\'address\']').val()) + '&city=' + encodeURIComponent($('input[name=\'city\']').val()) + '&country_id=' + encodeURIComponent($('select[name=\'country_id\']').val()) + '&zone_id=' + encodeURIComponent($('select[name=\'zone_id\']').val()) + '&shipping_method=' + encodeURIComponent($('input[name=\'shipping_method\']:checked').val() ? $('input[name=\'shipping_method\']:checked').val() : '') + '&payment_method=' + encodeURIComponent($('input[name=\'payment_method\']:checked').val() ? $('input[name=\'payment_method\']:checked').val() : ''),
		beforeSend: function() {
			$('.success, .warning.wpcart, .error').remove();
			$.blockUI({
				css: { 
					border: 'none', 
					padding: '10px', 
					backgroundColor: '#FFF', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: 0.8,
					color: '#000' 
				}
			}); 
		},
		complete: function() {
			$('.waiting').remove();
		},
		success: function(data) {
			if (data.error) {
				setTimeout(function() {
					$.unblockUI({
						onUnblock: function(){
							$('#warning').after('<div class="warning wpcart"><div class="warring_arrow"></div>' + data.error + '</div>');
						} 
					}); 
				}, 1000);
			}
			
			if (data.success) {
				setTimeout(function() {
					$.unblockUI({
						onUnblock: function(){
							$(document).colorbox({
								overlayClose: false,
								escKey: false,
								opacity: 0.5,
								open: true,
								href: 'checkout/success&view=successpopup'
							});
							$('input[name=\'customername\']').val('');
							$('input[name=\'email\']').val('');
							$('input[name=\'telephone\']').val('');
							$('input[name=\'address\']').val('');
							$('input[name=\'city\']').val('');
							$('select[name=\'country_id\']').val('');
							$('select[name=\'zone_id\']').val('');
							$('input[name=\'shipping_method\']:checked').attr('checked', '');
							$('input[name=\'payment_method\']:checked').attr('checked', '');
						} 
					}); 
				}, 1000);
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$('#cartpopup input').keydown(function(e) {
	if (e.keyCode == 13) {
		confirm();
	}
});
//--></script>
<script type="text/javascript"><!--
$('.cp_count').load('index.php?route=checkout/cart/cart_count');
setTimeout("$(document).ready(function(){$('.tbc_close').click();})",15000);
$('.tbc_close').click(function() {
	$('.warning.wpcart').remove();
});
$('#cart_order').click(function() {
	$('.warning.wpcart').remove();
});
$(document).ready(function() {
	$('#cart_order').colorbox({
		opacity: 0.5
	});
});
//--></script>
</div>
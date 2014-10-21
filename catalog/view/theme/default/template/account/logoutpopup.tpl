<?php if ($logged) { ?>
<div class="popup logout-content">
	<div class="popupmiddle">
	<div class="text_notice confirm_logout"><?php echo $text_confirm_logout; ?></div>
	<table width="100%">
	<tr>
		<td align="right"><a id="button_yes" class="button"><span><?php echo $button_yes; ?></span></a></td>
		<td align="left"><a id="button_no" class="button"><span><?php echo $button_no; ?></span></a></td>
	</tr>
	</table>
	</div>
</div>
<script type="text/javascript"><!--
$('#cboxClose').hide();
$('.popupmiddle #button_yes').click(function(event) {
				$(this).colorbox({
					overlayClose: false,
					escKey: false,
					opacity: 0.5,
					href: 'index.php?route=account/logout'
				});
			$('#showuser').load('index.php?route=common/header/account');
			$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
});
$('.popupmiddle #button_no').click(function() {
			$(document).ready(function(){$('#cboxClose').click();});
});
//--></script>
<?php } else { ?>
<div class="popup">
	<div class="popupmiddle" style="padding:10px;">
	<div class="text_notice"><?php echo $text_confirm_logouted; ?></div>
	<table width="100%">
	<tr>
		<td align="center"><a id="button_yes" class="button"><span><?php echo $button_yes; ?></span></a></td>
	</tr>
	</table>
	</div>
</div>
<script type="text/javascript"><!--
$('#cboxClose').hide();
$('.popupmiddle #button_yes').click(function() {
			$(document).ready(function(){$('#cboxClose').click();});
			$('#showuser').load('index.php?route=common/header/account');
			$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
});
//--></script>
<?php } ?>
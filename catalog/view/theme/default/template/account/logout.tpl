<div class="popup">
	<div class="popupmiddle" style="padding:10px;">
	<div class="text_notice"><?php echo $text_message; ?></div>
	<table width="100%">
	<tr>
		<td align="center"><a id="button_yes" class="button"><span><?php echo $button_yes; ?></span></a></td>
	</tr>
	</table>
	</div>
</div>
<script type="text/javascript"><!--
$('#showuser').load('index.php?route=common/header/account');
$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
$('.popupmiddle #button_yes').click(function(event) {
			$(document).ready(function(){$('#cboxClose').click();});
	return false;
});
//--></script>
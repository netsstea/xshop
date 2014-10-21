<?php if (!$logged) { ?>
<?php if($options == 'orderlogin') { ?>
<div id="cartpopup">
	<div class="cartpopuptitle iconorder">Lựa chọn đặt hàng</div>
	<div class="popupmiddle ctp_content">
		<div class="ctp_options">
			<div class="ctp_title"><span>Khách hàng chưa có tài khoản?</span></div>
			
			<a class="ctp_button" id="ctp_continue" onclick="index.php?route=checkout/cart/order&options=ordercontinue"><span>Đặt hàng không cần tài khoản</span></a>
			
			<a class="ctp_button" id="no_create" href="<?php echo $create; ?>"><span>Đăng ký tài khoản</span></a>
		</div>
		
        <div class="ctp_login">
			<div class="ctp_title"><span>Đã có tài khoản? Đăng nhập tại đây</span></div>
			<div class="warning_content">
				<div id="logintop"></div>
			</div>
			<table width="100%">
			<tr>
				<td align="right"><b><?php echo $entry_email; ?></b></td>
				<td align="left"><input type="text" name="email" id="login" /></td>
			</tr>
			<tr>
				<td align="right"><b><?php echo $entry_password; ?></b></td>
				<td align="left"><input type="password" name="password" id="login" /></td>
			</tr>
			<tr>
				<td></td>
				<td align="left"><a onclick="account();" class="button"><span><?php echo $button_login; ?></span></a></td>
			</tr>
			</table>
			<br/>
			<a href="<?php echo $forgotten; ?>">Quên mật khẩu?</a>
        </div>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('#ctp_continue').colorbox({
			opacity: 0.5
		});
	});
//--></script>
<script type="text/javascript"><!--
function account() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=account/login/login',
		dataType: 'json',
		data: 'email=' + encodeURIComponent($('input[name=\'email\'][id=\'login\']').val()) + '&password=' + encodeURIComponent($('input[name=\'password\'][id=\'login\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#logintop').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#logintop').after('<div class="warning" style="font-size:10px;">' + data.error + '</div>');
			}
			
			if (data.success) {
				$(document).ready(function() {
					$(this).colorbox({
						opacity: 0.5,
						open: true,
						href: 'checkout/cart/order/'
					});
				});
				$('#showuser').load('index.php?route=common/header/account');
				$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
				
			}
		}
	});
}

//--></script>
<?php } else { ?>
  <div class="popup">
  <div class="popuptitle"><?php echo $heading_title; ?></div>
        <div class="popupmiddle">
		<div class="warning_content">
			<div id="logintop"></div>
		</div>
        <table width="100%">
		<tr>
            <td align="right"><b><?php echo $entry_email; ?></b></td>
            <td align="left"><input type="text" name="email" id="login" /></td>
		</tr>
		<tr>
            <td align="right"><b><?php echo $entry_password; ?></b></td>
            <td align="left"><input type="password" name="password" id="login" /></td>
        </tr>
		<tr>
			<td></td>
			<td align="left"><a onclick="account();" class="button"><span><?php echo $button_login; ?></span></a></td>
		</tr>
		</table>
		<br/>
		<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten_password; ?></a> | <a href="<?php echo $create; ?>"><?php echo $text_account; ?></a>
        </div>
  </div>
<script type="text/javascript"><!--
function account() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=account/login/login',
		dataType: 'json',
		data: 'email=' + encodeURIComponent($('input[name=\'email\'][id=\'login\']').val()) + '&password=' + encodeURIComponent($('input[name=\'password\'][id=\'login\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#logintop').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#logintop').after('<div class="warning" style="font-size:10px;">' + data.error + '</div>');
			}
			
			if (data.success) {
				$(document).ready(function(){$('#cboxClose').click();});
				$('#showuser').load('index.php?route=common/header/account');
				$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
				
			}
		}
	});
}

//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('.popup input').keydown(function(e) {
	if (e.keyCode == 13) {
		account();
	}
});
//--></script>
<?php } else { ?>
<div class="popup">
	<div class="popupmiddle" style="padding:10px;">
	<div class="text_notice"><?php echo $text_confirm_notice; ?></div>
	<table width="100%">
	<tr>
		<td align="center"><a id="button_yes" class="button"><span><?php echo $button_yes; ?></span></a></td>
	</tr>
	</table>
	</div>
</div>
<script type="text/javascript"><!--
$('.popupmiddle #button_yes').click(function(event) {
			$(document).ready(function(){$('#cboxClose').click();});
			$('#showuser').load('index.php?route=common/header/account');
			$('.mr_cart_count').load('index.php?route=checkout/cart/cart_count');
	return false;
});
//--></script>
<?php } ?>
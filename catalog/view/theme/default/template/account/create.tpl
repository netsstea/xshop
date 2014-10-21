<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.blockUI.js"></script>
<div id="content" class="dangky">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <div id="warning"></div>
      <b style="margin-bottom: 2px; display: block;font-size:14px;"><?php echo $text_your_details; ?></b>
      <div class="content">
        <table>
          <tr>
            <td width="150"><?php echo $entry_customername; ?></td>
            <td><input type="text" name="customername" /><span class="required" id="customername">(<font>*</font>)</span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><input type="text" name="email" /><span class="required" id="email">(<font>*</font>)</span>
            </td>
          </tr>
          <tr>
            <td width="150"><?php echo $entry_password; ?></td>
            <td><input type="password" name="password" /><span class="required" id="password">(<font>*</font>)</span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_confirm; ?></td>
            <td><input type="password" name="confirm" /><span class="required" id="confirm_password">(<font>*</font>)</span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?></td>
            <td><input type="text" name="telephone" /><span class="required" id="telephone">(<font>*</font>)</span>
            </td>
          </tr>
          <tr>
            <td>Giới tính</td>
            <td>
				<table width="120" cellpadding="0">
				  <tr>
					<td width="1">
						<input style="width:auto;" type="radio" name="gender" value="male" id="gd_male" />
					</td>
					<td><label for="gd_male" style="cursor: pointer;">Nam</label></td>
					<td width="1">
						<input style="width:auto;" type="radio" name="gender" value="female" id="gd_female" />
					</td>
					<td><label for="gd_female" style="cursor: pointer;">Nữ</label></td>
				  </tr>
				</table>
            </td>
          </tr>
        </table>
      </div>
	<div class="address" style="margin-bottom:10px;">
      <b style="margin-bottom: 2px; display: block;font-size:14px;"><?php echo $text_your_address; ?></b>
      <div class="content">
        <table>
          <tr>
            <td width="150"><?php echo $entry_address; ?></td>
            <td><input type="text" name="address" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?></td>
            <td><input type="text" name="city" /></td>
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
	<input type="hidden" name="newsletter" value="1" />
      <?php if ($text_agree) { ?>
      <div class="buttons">
        <table>
          <tr>
			<td><span id="information"></span></td>
            <td align="right" style="padding-right: 5px;"><?php echo $text_agree; ?></td>
            <td width="5" style="padding-top: 5px;"><input style="width:auto;" type="checkbox" name="agree" value="1" /></td>
            <td align="right" width="168"><a onclick="createajax();" class="button"><span><?php echo $button_create; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } else { ?>
      <div class="buttons">
        <table>
          <tr>
            <td align="right"><a onclick="createajax();" class="button"><span><?php echo $button_create; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
  <script type="text/javascript"><!--
$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
$('#country_id').attr('value', '<?php echo $country_id; ?>');
//--></script>
<script type="text/javascript"><!--
function createajax() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=account/create/createajax',
		dataType: 'json',
		data: 'customername=' + encodeURIComponent($('input[name=\'customername\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email\']').val()) + '&password=' + encodeURIComponent($('input[name=\'password\']').val()) + '&confirm=' + encodeURIComponent($('input[name=\'confirm\']').val()) + '&telephone=' + encodeURIComponent($('input[name=\'telephone\']').val()) + '&address=' + encodeURIComponent($('input[name=\'address\']').val()) + '&city=' + encodeURIComponent($('input[name=\'city\']').val()) + '&country_id=' + encodeURIComponent($('select[name=\'country_id\']').val()) + '&zone_id=' + encodeURIComponent($('select[name=\'zone_id\']').val()) + '&newsletter=' + encodeURIComponent($('input[name=\'newsletter\']').val()) + '&agree=' + encodeURIComponent($('input[name=\'agree\']:checked').val() ? $('input[name=\'agree\']:checked').val() : '') + '&gender=' + encodeURIComponent($('input[name=\'gender\']:checked').val() ? $('input[name=\'gender\']:checked').val() : ''),
		beforeSend: function() {
			$('.success, .warning2, .error').remove();
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

		success: function(data) {
			if (data.error) {
				setTimeout(function() {
					$.unblockUI({
						onUnblock: function(){
							if (data.error['customername']) {
								$('#customername').after('<span class="warning2">' + data.error['customername'] + '</span>');
							}
							
							if (data.error['email']) {
								$('#email').after('<span class="warning2">' + data.error['email'] + '</span>');
							}
							
							if (data.error['password']) {
								$('#password').after('<span class="warning2">' + data.error['password'] + '</span>');
							}
							
							if (data.error['confirm_password']) {
								$('#confirm_password').after('<span class="warning2">' + data.error['confirm_password'] + '</span>');
							}
							
							if (data.error['telephone']) {
								$('#telephone').after('<span class="warning2">' + data.error['telephone'] + '</span>');
							}
							
							if (data.error['information']) {
								$('#information').after('<span class="warning2">' + data.error['information'] + '</span>');
							}
						} 
					}); 
				}, 1000);
			} else {
				setTimeout(function() {
					$.unblockUI({
						onUnblock: function(){
								$('#showuser').load('index.php?route=common/header/account');
								$('#content').load('index.php?route=account/success');
						} 
					}); 
				}, 1000);
			}
		  
			if (data.success) {
				$('input[name=\'customername\']').val('');
				$('input[name=\'email\']').val('');
				$('input[name=\'password\']').val('');
				$('input[name=\'confirm\']').val('');
				$('input[name=\'telephone\']').val('');
				$('input[name=\'newsletter\']').val('');
				$('input[name=\'address\']').val('');
				$('input[name=\'city\']').val('');
				$('select[name=\'country_id\']').val('');
				$('select[name=\'zone_id\']').val('');
				$('input[name=\'agree\']:checked').attr('checked', '');
				$('input[name=\'gender\']:checked').attr('checked', '');
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$('.content input').keydown(function(e) {
	if (e.keyCode == 13) {
		createajax();
	}
});
//--></script>
<?php echo $footer; ?> 
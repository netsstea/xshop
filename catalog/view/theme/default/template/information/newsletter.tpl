<?php if($view == 'success') { ?>
	<?php if($newsletter_success) { ?>
	<div class="popup">
		<div class="popupmiddle" style="padding:10px;">
		<div class="text_notice"><?php echo $success; ?></div>
		<table width="100%">
		<tr>
			<td align="center"><a id="button_yes" class="button"><span>Đồng ý</span></a></td>
		</tr>
		</table>
		</div>
	</div>
	<script type="text/javascript"><!--
	$('#cboxClose').hide();
	$('.popupmiddle #button_yes').click(function() {
				$(document).ready(function(){$('#cboxClose').click();});
	});
	//--></script>
	<?php } ?>
<?php } else { ?>
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/nlt.css" />
	<?php if(!$logged) { ?>
	<div id="newsletter">
		<div class="nltbox"></div>
		<div class="nltpopup">
			<div class="nltclose"></div>
			<div class="ntlemail">
				<input type="text" name="email" value="" placeholder="Nhập địa chỉ E-mail của bạn" id="nltr3_email" />
				<span id="nlt_email"></span>
			</div>
			<div class="nltbutton">
				<a class="button" onclick="createnewsletter('female');" ><span>Dành cho nữ</span></a>
				<a class="button" onclick="createnewsletter('male');" ><span>Dành cho nam</span></a>
			</div>
		</div>
	</div>
<script language="javascript"> 
$('#newsletter .nltbox').click(function(event) {
	if ($('#newsletter').hasClass('active')) {
		$('#newsletter').removeClass('active');
		$(".nltpopup").animate({bottom: "-240"}, 250 );
	} else {
		$('#newsletter').addClass('active');
		$(".nltpopup").animate({bottom: "0"}, 250 );
	}
	return false;
});
$('.nltpopup').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$('#newsletter').removeClass('active');
	$(".nltpopup").animate({bottom: "-240"}, 250 );
});
$('.nltclose').click(function() {
	$('#newsletter').removeClass('active');
	$(".nltpopup").animate({bottom: "-240"}, 250 );
});
</script>
	<script type="text/javascript"><!--
	$('#newsletter input').click(function(event) {
		$('.warninghome').remove();
	});
	$('.warninghome').click(function(event) {
		$('.warninghome').remove();
	});
	function createnewsletter(gender) {
		$.ajax({
			type: 'post',
			url: 'index.php?route=information/newsletter/createnewsletter',
			dataType: 'json',
			data: 'email=' + encodeURIComponent($('input[name=\'email\'][id=\'nltr3_email\']').val()) + '&gender=' + gender,
			beforeSend: function() {
				$('.success, .warninghome, .error').remove();
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
				setTimeout(function() {
					$.unblockUI({
						onUnblock: function(){
							  if (data.error) {
								if (data.error['gender']) {
									$('#nlt_gender').after('<div class="warninghome whgender"><div class="war_arrow"></div><span>' + data.error['gender'] + '</span></div>');
								}
								if (data.error['email']) {
									$('#nlt_email').after('<div class="warninghome"><div class="war_arrow"></div><span>' + data.error['email'] + '</span></div>');
								}
								setTimeout("$('.warninghome').remove();",12000);
							  } else {
									$(document).ready(function() {
										$(this).colorbox({
											opacity: 0.5,
											initialHeight: "91",
											initialWidth: "322",
											open: true,
											href: 'index.php?route=information/newsletter&view=success'
										});
									});
							  }
						} 
					}); 
				}, 1000);

			  
				if (data.success) {
					$('input[name=\'email\'][id=\'nltr3_email\']').val('');
				}
			}
		});
	}
	//--></script>
	<?php } ?>
<?php } ?>
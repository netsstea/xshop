<div id="popup_showroom">
    <div class="sr_tabs">
	<?php for($i = 0; $i < sizeof($showroorms); $i++) { ?>
		<a tab="#tab_showroom<?php echo $showroorms[$i]['showroom_id']; ?>" id="showroom<?php echo $showroorms[$i]['showroom_id']; ?>">
			<span class="sr_top"><?php echo $showroorms[$i]['name']; ?></span><br/>
			<font>ĐC:</font><?php echo $showroorms[$i]['address']; ?><br/>
			<font>ĐT:</font> <?php echo $showroorms[$i]['telephone']; ?><br/><font>Mobile:</font> <?php echo $showroorms[$i]['hotline']; ?>
		</a>
	<?php } ?>
	</div>
	<div class="trSitemap">
		<?php for($i = 0; $i < sizeof($showroorms); $i++) { ?>
		<div id="tab_showroom<?php echo $showroorms[$i]['showroom_id']; ?>" class="sr_tab_page">
			<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $showroorms[$i]['google_maps']; ?>"></iframe>
		</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript"><!--
$.tabs_showroom = function(selector, start) {
	$(selector).each(function(i, element) {
		$($(element).attr('tab')).removeClass('active');
		
		$(element).click(function() {
			$(selector).each(function(i, element) {
				$(element).removeClass('selected');
				
				$($(element).attr('tab')).removeClass('active');
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('tab')).addClass('active');
		});
	});
	
	if (!start) {
		start = $(selector + ':first').attr('tab');
	}

	$(selector + '[tab=\'' + start + '\']').trigger('click');
};
$.tabs_showroom('.sr_tabs a');
//--></script>
<?php if($showroom_id != 0) { ?>
<script type="text/javascript"><!--
	$('.sr_tabs a').removeClass('selected');
	$('.sr_tab_page').removeClass('active');
	$('.sr_tabs #showroom<?php echo $showroom_id; ?>').addClass('selected');
	$('#tab_showroom<?php echo $showroom_id; ?>').addClass('active');
//--></script> 
<?php } ?>
$.tabs = function(selector, start) {
	$(selector).each(function(i, element) {
		$($(element).attr('tab')).css('display', 'none');
		
		$(element).click(function() {
			$(selector).each(function(i, element) {
				$(element).removeClass('selected');
				
				$($(element).attr('tab')).css('display', 'none');
				
				$($(element).attr('tab')).removeClass('active');
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('tab')).css('display', 'block');
			
			$($(this).attr('tab')).addClass('active');
		});
	});
	
	if (!start) {
		start = $(selector + ':first').attr('tab');
	}

	$(selector + '[tab=\'' + start + '\']').addClass('selected');
	$(start).css('display', 'block');
	$(start).addClass('active');
};
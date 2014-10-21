<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<div id="footer">
<div class="footer_content">
  <div class="div0">
  <div class="div0ct">
	<div class="fbanner_left">
		<a href="<?php echo $link_banner_footer; ?>"><img src="<?php echo $banner_footer; ?>" /></a>
	</div>
	<?php foreach ($cinformations as $cinformation) { ?>
	<div class="finfo">
		<div class="ftop">
		  <div class="ftop_name"><?php echo $cinformation['name']; ?></div>
		</div>
		<div class="fmiddle">
			<div>
				<ul>
				<?php foreach ($cinformation['informations'] as $information) { ?>
					<li><a href="<?php if($information['link']){ echo $information['link']; } else { echo $information['href']; } ?>"><?php echo $information['name']; ?></a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="finfo">
		<div class="ftop ftright">
		  <div class="ftop_name"><?php echo $footer_title; ?></div>
		</div>
		<div class="fmiddle">
			<?php echo $footer; ?>
		</div>
	</div>
  </div>
  </div>
  <div class="div1">
	<div class="div1ct">
		<div class="showroom_hcm">
			<div class="srhcm_name">Khu vực Hồ Chí Minh</div>
			
			<div class="srhcm_middle"><ul class="srmul">
				<?php foreach ($showroorm_hcm as $showroorm) { ?>
					<li class="srmli">
						<div class="srmName"><?php echo $showroorm['name']; ?></div>
						<div class="srmAddress"><?php echo $showroorm['address']; ?></div>
						<div class="srmHotline"><font>Hotline:</font> <?php echo $showroorm['hotline']; ?></div>
						<div class="srmTelephone">
							<font>Tel:</font> <?php echo $showroorm['telephone']; ?>
							<?php if($showroorm['fax']) { ?>
								- <font>Fax:</font> <?php echo $showroorm['fax']; ?>
							<?php } ?>
						</div>
						<a id="fshowrooms<?php echo $showroorm['showroom_id']; ?>" class="srmHref" onclick="<?php echo $showroorm['showroom_href']; ?>">Xem bản đồ »</a>
					</li>
				<?php } ?>
			</ul></div>
		</div>
		
		<div class="showroom_hn">
			<div class="srhn_name">Khu vực Hà Nội</div>
			
			<div class="srhn_middle"><ul class="srmul">
				<?php foreach ($showroorm_hn as $showroorm) { ?>
					<li class="srmli">
						<div class="srmName"><?php echo $showroorm['name']; ?></div>
						<div class="srmAddress"><?php echo $showroorm['address']; ?></div>
						<div class="srmHotline"><font>Hotline:</font> <?php echo $showroorm['hotline']; ?></div>
						<div class="srmTelephone">
							<font>Tel:</font> <?php echo $showroorm['telephone']; ?>
							<?php if($showroorm['fax']) { ?>
								- <font>Fax:</font> <?php echo $showroorm['fax']; ?>
							<?php } ?>
						</div>
						<a id="fshowrooms<?php echo $showroorm['showroom_id']; ?>" class="srmHref" onclick="<?php echo $showroorm['showroom_href']; ?>">Xem bản đồ »</a>
					</li>
				<?php } ?>
			</ul></div>
		</div>
	<script type="text/javascript"><!--
	$('.srmul .srmHref').each(function(i, element) {
	var sid = $(element).attr("id");
	$(document).ready(function() {
		$('#' + sid).colorbox({
			initialHeight: "540",
			initialWidth: "968",
			overlayClose: false,
			escKey: false,
			fixed: true,
			opacity: 0.5
		});
	});
	});
	//--></script>
	</div>
  </div>
  <div class="copyright">
	<div class="copyrightct">
		<a href="<?php echo $home; ?>" class="logofooter"><img src="<?php echo $logo_footer; ?>" /></a>
		<?php echo $text_powered_by; ?>
		
		  <div id="bttop"><a class="fixtop" title="Lên trên"><img src="catalog/view/theme/default/image/top.png" /></a></div>
		  <script type='text/javascript'>$(function(){$(window).scroll(function(){if($(this).scrollTop() != 0){$('#bttop').addClass('active');}else{$('#bttop').removeClass('active');}});$('#bttop').click(function(){$('body,html').animate({scrollTop:0},800);});});</script>
	</div>
  </div>
</div>
</div>
</div>
<script type="text/javascript"><!--
$(function(){$(window).scroll(function(){
	var scdata = $('#wrapper').height() - $('.bannerhead img').height() - ((668 - $('.bannerhead img').height())/2) + 40;

	if($(this).scrollTop() > scdata){
		$('.bannerhead').addClass('active');
		$('.bannerhead').css("top",scdata);
	} else {
		$('.bannerhead').removeClass('active');
		$('.bannerhead').css("top",0);
	}
});});
	
	$(document).ready(function() {
		$('.colorbox').colorbox({
			overlayClose: true,
			escKey: true,
			opacity: 0.5
		});
	});

	$(document).ready(function() {
		$('.OCTcolorbox').colorbox({
			overlayClose: false,
			opacity: 0.5
		});
	});
//--></script>
</body></html>
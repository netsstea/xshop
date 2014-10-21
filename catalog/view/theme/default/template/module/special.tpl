<?php if($home_select) { ?>
<script type="text/javascript">
	  $(document).ready(function(){
		$('#sbspecial').bxSlider({
		speed: 250,
		autoStart: false
		});
	  });
</script>
<div class="box">
	<div class="right"></div>
  <div class="top"><h4><?php echo $heading_title; ?></h4></div>
  <div class="middle special">
	<ul class="listsp" id="sbspecial">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 5) { ?>
		<li><ul class="sblist">
        <?php for ($j = $i; $j < ($i + 5); $j++) { ?>
        <?php if (isset($products[$j])) { ?>
		<li>
          <div class="lsimage"><a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>"  alt="<?php echo $products[$j]['name']; ?>" /></a></div>
          <div class="lsname"><a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a></div>
		  <?php if ($display_price) { ?>
			  <div class="lsprice">
			  <?php if (!$products[$j]['special']) { ?>
			  <span class="price"><font><?php echo $products[$j]['price']; ?></font></span>
			  <?php } else { ?>
			  <span class="special"><font><?php echo $products[$j]['price']; ?></font></span><br/>
			  <span class="price"><font><?php echo $products[$j]['special']; ?></font></span>
			  <?php } ?>
			  </div>
          <?php } ?>
		
		</li>
        <?php } ?>
        <?php } ?>
		</ul></li>
      <?php } ?>
	</ul>
	<script type="text/javascript"><!--
	$('.sblist li').each(function(i, element) {
	var lid = $(element).attr("id");
	$(document).ready(function() {
		$('#' + lid).hoverIntent(makeTall,makeShort);
	});
	function makeTall(){
	  $('#' + lid + " .sblist_info").stop(true, false).animate({
		top: "-120"
	  }, 150 );
	}
	function makeShort(){
	  $('#' + lid + " .sblist_info").stop(true, false).animate({
		top: "0"
	  }, 150 );
	}
	});
	//--></script>
  <?php if($special_href) { ?><a class="sb_xemthem" href="<?php echo $special_href; ?>">XEM THÊM</a><?php } ?>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
	  $(document).ready(function(){
		$('#bestseller').bxSlider({
		speed: 250,
		autoStart: false
		});
	  });
</script>
<div class="box">
	<div class="right"></div>
  <div class="top"><h4><?php echo $heading_title; ?></h4></div>
  <div class="middle special">
	<ul class="listsp" id="bestseller">
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
  </div>
</div>
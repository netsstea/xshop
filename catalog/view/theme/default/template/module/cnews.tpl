<div class="box">
  <div class="top"><h4><?php echo $heading_title; ?></h4></div>
  <div id="cnews" class="middle"><?php echo $cnews; ?></div>
</div>
<script type="text/javascript">
	  $(document).ready(function(){
		$('.sb_topnews').bxSlider({
		speed: 250,
		autoStart: false
		});
	  });
</script>
<div class="box news">
  <div class="right"></div>
  <div class="top"><h4>Tin xem nhiều</h4></div>
  <div class="middle sb_news">
    <ul class="sb_topnews">
      <?php for ($i = 0; $i < sizeof($xemnhieu); $i = $i + 5) { ?>
		<li><ul>
			<?php for ($j = $i; $j < ($i + 5); $j++) { ?>
				<?php if (isset($xemnhieu[$j])) { ?>
				<li>
					<a href="<?php echo $xemnhieu[$j]['href']; ?>">
						<div class="sn_image"><img alt="<?php echo $xemnhieu[$j]['name']; ?>" src="<?php echo $xemnhieu[$j]['image']; ?>" /></div>
						<div class="sn_name"><?php echo $xemnhieu[$j]['name']; ?></div>
						<?php if($xemnhieu[$j]['date_added']) { ?><div class="sn_date_added"><?php echo $xemnhieu[$j]['date_added']; ?></div><?php } ?>
					</a>
				</li>
				<?php } ?>
			<?php } ?>
		</ul></li>
      <?php } ?>
    </ul>
  </div>
</div>

<?php foreach ($cnewss as $cnews) { ?>
<script type="text/javascript">
	  $(document).ready(function(){
		$('.sb_cnews<?php echo $cnews['cnews_id']; ?>').bxSlider({
		speed: 250,
		autoStart: false
		});
	  });
</script>
<div class="box news">
  <div class="right"></div>
  <div class="top"><h4><?php echo $cnews['name']; ?></h4></div>
  <div class="middle sb_news">
	<a class="sb_xemthem" href="<?php echo $cnews['href']; ?>">Xem thêm</a>
    <ul class="sb_cnews<?php echo $cnews['cnews_id']; ?>">
	  <?php $newss = $cnews['newss']; ?>
      <?php for ($i = 0; $i < sizeof($newss); $i = $i + 5) { ?>
		<li><ul>
			<?php for ($j = $i; $j < ($i + 5); $j++) { ?>
				<?php if (isset($newss[$j])) { ?>
				<li>
					<a href="<?php echo $newss[$j]['href']; ?>">
						<div class="sn_image"><img alt="<?php echo $newss[$j]['name']; ?>" src="<?php echo $newss[$j]['image']; ?>" /></div>
						<div class="sn_name"><?php echo $newss[$j]['name']; ?></div>
						<?php if($newss[$j]['date_added']) { ?><div class="sn_date_added"><?php echo $newss[$j]['date_added']; ?></div><?php } ?>
					</a>
				</li>
				<?php } ?>
			<?php } ?>
		</ul></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>

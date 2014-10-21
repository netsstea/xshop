<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/listpro.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/home.css" />
<script src="catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#slideshow').nivoSlider();
});
--></script>
<div id="ct_home">
<div id="content" class="ct_slide">
<div class="slideshow">
	<div id="slideshow" class="nivoSlider">
		<?php foreach ($tophomes as $tophome) { ?>
			<?php if($tophome['link']) { ?>
				<a href="<?php echo $tophome['link']; ?>"><img src="<?php echo $tophome['image']; ?>" /></a>
			<?php } else { ?>
				<img src="<?php echo $tophome['image']; ?>" />
			<?php } ?>
		<?php } ?>
	</div>
</div>

<?php if($toprighthome1s && $toprighthome2s) { ?>
<div class="toprighthome">
	<div class="toprighthome1s">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#toprighthome1s').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="toprighthome1s">
			<?php foreach ($toprighthome1s as $toprighthome1) { ?>
			  <li>
				<?php if($toprighthome1['link']) { ?>
					<a href="<?php echo $toprighthome1['link']; ?>"><img src='<?php echo $toprighthome1['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $toprighthome1['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
	<div class="toprighthome2s">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#toprighthome2s').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="toprighthome2s">
			<?php foreach ($toprighthome2s as $toprighthome2) { ?>
			  <li>
				<?php if($toprighthome2['link']) { ?>
					<a href="<?php echo $toprighthome2['link']; ?>"><img src='<?php echo $toprighthome2['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $toprighthome2['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
</div>

<?php if($bottomlefthomes && $bottomrighthomes) { ?>
<div class="slidebottom">
	<div class="slideleft">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#slideleft').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="slideleft">
			<?php foreach ($bottomlefthomes as $bottomlefthome) { ?>
			  <li>
				<?php if($bottomlefthome['link']) { ?>
					<a href="<?php echo $bottomlefthome['link']; ?>"><img src='<?php echo $bottomlefthome['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bottomlefthome['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
	<div class="slideright">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#slideright').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="slideright">
			<?php foreach ($bottomrighthomes as $bottomrighthome) { ?>
			  <li>
				<?php if($bottomrighthome['link']) { ?>
					<a href="<?php echo $bottomrighthome['link']; ?>"><img src='<?php echo $bottomrighthome['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bottomrighthome['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>

<?php echo $column_left; ?>
<?php foreach ($chomes as $chome) { ?>
<?php if($chome['products']) { ?>
<div id="content" class="col_left">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $chome['name']; ?></h1>
    </div>
  </div>
  <div class="middle listpro">
	<ul class="list">
      <?php foreach ($chome['products'] as $products) { ?>
		<li class="lli" id="Chid<?php echo $chome['chome_id']; ?>_Pid<?php echo $products['product_id']; ?>">
			<a class="lmhref" href="<?php echo $products['href']; ?>">
			<div class="lpro">
			  <img src="<?php echo $products['thumb']; ?>"  alt="<?php echo $products['name']; ?>" />
			  
			<h3 class="lmname"><?php echo $products['name']; ?></h3>
			<?php if ($display_price) { ?>
			  <div class="lprice">
			  <?php if (!$products['special']) { ?>
			  <span class="price"><?php echo $products['price']; ?></span>
			  <?php } else { ?>
			  <span class="price"><?php echo $products['special']; ?></span> <span class="lspecial"><?php echo $products['price']; ?></span>
			  <?php } ?>
			  </div>
			<?php } ?>
			
			<?php if($products['promotion']) { ?><div class="lmprom"><?php echo $products['promotion']; ?></div><?php } ?>
			</div>
			
			<?php if ($products['attribute_data']) { ?>
			<div class="lmore">
				<div class="lbdesc"><ul>
				  <?php foreach($products['attribute_data'] as $attribute_data) { ?>
					<li><?php echo $attribute_data['name']; ?>: <?php echo $attribute_data['text']; ?></li>
				  <?php } ?>
				</ul></div>
			</div>
			<?php } ?>
			</a>
		</li>
      <?php } ?>
	</ul>
  </div>
  <div class="chomeib">
	<?php if($chome['image'] != 'image/no_image.jpg') { ?>
		<?php if($chome['link']) { ?>
			<a href="<?php echo $chome['link']; ?>"><img src="<?php echo $chome['image']; ?>" /></a>
		<?php } else { ?>
			<img src="<?php echo $chome['image']; ?>" />
		<?php } ?>
	<?php } ?>
  </div>
</div>
<?php } ?>
<?php } ?>	

<?php if($popup_status) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$(this).colorbox({
		overlayClose: false,
		escKey: false,
		opacity: 0.5,
		open: true,
		href: '<?php echo $link_popup; ?>'
	});
});
//--></script>
<?php } ?>
</div>
<?php echo $footer; ?> 
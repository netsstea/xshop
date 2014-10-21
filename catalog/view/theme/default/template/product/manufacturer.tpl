<?php echo $header; ?>
<h1 class="h1manu"><?php echo $heading_title; ?></h1>
<?php echo $column_left; ?><?php echo $column_right; ?>
<?php $list = 0; ?>
<?php foreach ($categories as $category) { ?>
<?php if($category['products']) { ?>
<?php $list++; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h1>
	  <a class="Manuxt" href="<?php echo $category['href']; ?>">Xem thêm <?php echo $category['name']; ?></a>
    </div>
  </div>
  <div class="middle listpro">

	<?php $products = $category['products']; ?>
	<ul class="list" id="list<?php echo $list; ?>">
      <?php foreach ($products as $product) { ?>
		<li class="lli">
			<a class="lmhref" href="<?php echo $product['href']; ?>">
			<div class="lpro">
			  <img src="<?php echo $product['thumb']; ?>"  alt="<?php echo $product['name']; ?>" />
			  
			<h3 class="lmname"><?php echo $product['name']; ?></h3>
			<?php if ($display_price) { ?>
			  <div class="lprice">
			  <?php if (!$product['special']) { ?>
			  <span class="price"><?php echo $product['price']; ?></span>
			  <?php } else { ?>
			  <span class="price"><?php echo $product['special']; ?></span> <span class="lspecial"><?php echo $product['price']; ?></span>
			  <?php } ?>
			  </div>
			<?php } ?>
			<?php if($product['promotion']) { ?><div class="lmprom"><?php echo $product['promotion']; ?></div><?php } ?>
			</div>
			
			<?php if ($product['attribute_data']) { ?>
			<div class="lmore">
				<div class="lbdesc"><ul>
				  <?php foreach($product['attribute_data'] as $attribute_data) { ?>
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
</div>
<?php } ?>
<?php } ?>
<?php echo $footer; ?> 
<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content" class="col_left">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle listpro">
    <?php if ($description) { ?>
    <div style="margin-bottom: 15px;"><?php echo $description; ?></div>
    <?php } ?>

    <?php if ($products) { ?>
    <div class="sort">
	  <div class="sortname"><span>Tìm theo</span></div>
	  <?php if(isset($category)) { ?>
		<?php echo $category; ?>
	  <?php } ?>
	  <?php if(isset($manufacturer)) { ?>
		<?php echo $manufacturer; ?>
	  <?php } ?>
	  <?php if(isset($phanloai)) { ?>
		<?php echo $phanloai; ?>
	  <?php } ?>
      <div class="crfilter">
          <?php foreach ($sorts as $sort_info) { ?>
          <?php if (($sort . '-' . $order) == $sort_info['value']) { ?>
          <a class="crfselected"><?php echo $sort_info['text']; ?></a>
          <?php } ?>
          <?php } ?>
        <ul class="cfilter">
          <?php foreach ($sorts as $sort_info) { ?>
          <?php if (($sort . '-' . $order) == $sort_info['value']) { ?>
          <li><a href="<?php echo $sort_info['href']; ?>" class="selected"><?php echo $sort_info['text']; ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo $sort_info['href']; ?>"><?php echo $sort_info['text']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
	<ul class="list">
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
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } else { ?>
		<h3>Rất tiếc, chúng tôi không tìm thấy sản phẩm nào thỏa điều kiện tìm kiếm của bạn.</h3>
	<?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
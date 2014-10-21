<div class="box_manufacturer">
	<div class="box_title">
		<?php if(isset($manufacturer_name)) { ?>
			<a class="crfselected"><?php echo $manufacturer_name; ?></a>
		<?php } else { ?>
			<a class="crfselected"><?php echo $heading_title; ?></a>
		<?php } ?>
	</div>
	<div class="box_content"<?php if(sizeof($manufacturers) > 8) { echo ' id="box_croll"';} ?>>
		<ul class="boxc_ul">
			<li id="boxall" <?php if(!$category_href_all) { echo ' class="selected"'; } ?>><a <?php if($category_href_all) { echo 'href="'.$category_href_all.'"'; } ?>>Tất cả thương hiệu
		</a></li>
		  <?php foreach ($manufacturers as $manufacturer) { ?>
			<li <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { echo ' class="selected"';} ?>><a href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a></li>
		  <?php } ?>
		</ul>
	</div>
</div>
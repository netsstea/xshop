<div class="box_category">
	<div class="box_title">
		<?php if(isset($category_name)) { ?>
			<a class="crfselected"><?php echo $category_name; ?></a>
		<?php } else { ?>
			<a class="crfselected"><?php echo $heading_title; ?></a>
		<?php } ?>
	</div>
	<?php if($category) { ?>
	<div class="box_content"<?php if($numcat > 8) { echo ' id="box_croll"';} ?>>
		<ul class="boxc_ul">
		<li id="boxall" <?php if(!$category_href_all) { echo ' class="selected"'; } ?>><a <?php if($category_href_all) { echo 'href="'.$category_href_all.'"'; } ?>>Tất cả
		<?php if(isset($ct_name)) { ?>
			<?php echo $ct_name; ?>
		<?php } ?>
		</a></li>
		<?php echo $category; ?>
		</ul>
	</div>
	<?php } ?>
</div>

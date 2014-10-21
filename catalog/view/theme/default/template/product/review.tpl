<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
	<div class="content">
		<div class="p_avatar">
			<img alt="<?php echo $review['author']; ?>" title="<?php echo $review['author']; ?>" src="image/avatar/avatar_default.png" />
		</div>
		<div class="preview_info">
		<div class="preview_title"><b class="prv_<?php echo $review['customer_group']; ?>"><?php echo $review['author']; ?></b> | <img src="catalog/view/theme/default/image/stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" /></div>
		<div class="p_date_added"><?php echo $review['date_vn']; ?></div>
		<div class="preview_desc"><?php echo $review['text']; ?></div>
		</div>
	</div>
<?php } ?>
	<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
	<div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>

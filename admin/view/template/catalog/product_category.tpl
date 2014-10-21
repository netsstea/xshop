<?php echo $header; ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1>Chọn danh mục đăng sản phẩm</h1>
  </div>
  <div class="content">
		<div class="category"><ul>
                <?php foreach ($category_attribute as $category) { ?>
					<?php if($product_id) { ?>
						<li><a href="index.php?route=catalog/product/update&product_id=<?php echo $product_id; ?>&category_id=<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a></li>
					<?php } else { ?>
						<li><a href="index.php?route=catalog/product/insert&category_id=<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a></li>
					<?php } ?>
                <?php } ?>
        </ul></div>
	
  </div>
</div>
<?php echo $footer; ?>
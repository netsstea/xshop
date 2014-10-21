<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="cart">
      <table class="cart">
        <tr>
          <th align="center"><?php echo $column_remove; ?></th>
          <th align="center"><?php echo $column_image; ?></th>
          <th align="left"><?php echo $column_name; ?></th>
          <th align="left"><?php echo $column_model; ?></th>
          <th align="right"><?php echo $column_quantity; ?></th>
		  <?php if($display_price) { ?>
          <th align="right"><?php echo $column_price; ?></th>
          <th align="right"><?php echo $column_total; ?></th>
		  <?php } ?>
        </tr>
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        <tr class="<?php echo $class; ?>">
          <td align="center"><input type="checkbox" name="remove[<?php echo $product['key']; ?>]" /></td>
          <td align="center"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
          <td align="left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if (!$product['stock']) { ?>
            <span style="color: #FF0000; font-weight: bold;">***</span>
            <?php } ?>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div></td>
          <td align="left"><?php echo $product['model']; ?></td>
          <td align="right">
			<select name="quantity[<?php echo $product['key']; ?>]" title="Số lượng" style="width:50px;">
				<option <?php if($product['quantity'] == 1) { echo ' selected=""'; } ?> value="1">1</option>
				<option <?php if($product['quantity'] == 2) { echo ' selected=""'; } ?> value="2">2</option>
				<option <?php if($product['quantity'] == 3) { echo ' selected=""'; } ?> value="3">3</option>
				<option <?php if($product['quantity'] == 4) { echo ' selected=""'; } ?> value="4">4</option>
				<option <?php if($product['quantity'] == 5) { echo ' selected=""'; } ?> value="5">5</option>
				<?php if($product['quantity'] > 5) { ?>
				<option <?php if($product['quantity'] > 5) { echo ' selected=""'; } ?> value="$product['quantity']"><?php echo $product['quantity']; ?></option>
				<?php } ?>
            </select>
		  </td>
		  <?php if($display_price) { ?>
          <td align="right"><?php echo $product['price']; ?></td>
          <td align="right"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>
	  <?php if($display_price) { ?>
	  <div style="width: 100%; display: inline-block; margin-top:10px;">
			<table style="float: right; display: inline-block;border-collapse: collapse;">
			  <?php $i=0; ?>
			  <?php foreach ($totals as $total) { ?>
			  <?php $i++; ?>
			  <tr class="total<?php echo $i; ?>">
				<td align="left" class="total_left"><?php echo $total['title']; ?></td>
				<td align="right" class="total_right"><?php echo $total['text']; ?></td>
			  </tr>
			  <?php } ?>
			  <tr>
			  <td colspan="2" align="right"><div class="cartvat">Bao gồm VAT</div></td>
			  </tr>
			</table>
	  </div>
	  <?php } ?>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="$('#cart').submit();" class="button"><span><?php echo $button_update; ?></span></a></td>
            <td align="center"><a onclick="location='<?php echo $continue; ?>'" class="button"><span><?php echo $button_shopping; ?></span></a></td>
            <td align="right"><a onclick="<?php echo $checkout; ?>" class="colorbox button"><span><?php echo $button_order; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: false,
		escKey: false,
		opacity: 0.5
	});
});
//--></script>
<?php echo $footer; ?> 
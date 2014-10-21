<?php if($view == 'successpopup') { ?>
<div class="popup" id="popup_order" style="text-align:left;">
<?php if ($payment_method_id == 'cod') { ?>
<div class="popuptitle" style="width:610px;"><?php echo $heading_title; ?></div>
<div class="popupmiddle" style="width:600px;">
<div class="text_notice"><?php echo $text_message; ?></div>
	<table width="100%">
		<tr>
			<td align="center"><a id="button_yes" class="button"><span><?php echo $button_yes; ?></span></a></td>
		</tr>
	</table>
</div>
  <?php } else { ?>
<div id="cartpopup" class="<?php if(sizeof($products) == 2) { echo ' pro_count_2'; } elseif(sizeof($products) > 2) { echo ' pro_count_3'; } ?> cartsuccess">
	<div class="cartpopuptitle iconorder">Xác nhận đặt hàng</div>
	<div id="quantity">
      <table class="cart">
        <tr>
          <th class="column_image" align="center"><?php echo $column_image; ?></th>
          <th class="column_name" align="center"><?php echo $column_name; ?></th>
          <th class="column_model" align="center"><?php echo $column_model; ?></th>
		  <?php if($display_price) { ?>
          <th class="column_price" align="right"><?php echo $column_price; ?></th>
		  <?php } ?>
          <th class="column_quantity" align="right"><?php echo $column_quantity; ?></th>
		  <?php if($display_price) { ?>
          <th class="column_total" align="right"><?php echo $column_total; ?></th>
		  <?php } ?>
        </tr>
	  </table>
	  <div class="cartcontent<?php if(sizeof($products) > 3) { echo ' cpproducts'; } ?>">
	  <table class="cart">
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        <tr class="<?php echo $class; ?>">
          <td class="column_image" align="center"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></td>
          <td class="column_name" align="left"><?php echo $product['name']; ?>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div></td>
          <td class="column_model" align="center"><?php echo $product['model']; ?></td>
		  <?php if($display_price) { ?>
          <td class="column_price" align="right"><?php echo $product['price']; ?></td>
		  <?php } ?>
          <td class="column_quantity" align="right">
			<?php echo $product['quantity']; ?>
			</td>
		  <?php if($display_price) { ?>
          <td class="column_total" align="right"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>
	  </div>
	</div>
	  <?php if($display_price) { ?>
	  <div style="width: 100%; display: inline-block;height: 75px;">
			<table style="float: right; display: inline-block;border-collapse: collapse;">
			  <?php $i=0; ?>
			  <?php foreach ($totals as $total) { ?>
			  <?php $i++; ?>
			  <tr class="total<?php if(sizeof($totals) == $i) { echo 'end';} else { echo 'start';} ?>">
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
<?php echo ${$payment_method_id}; ?>
</div>
<div style="width:100%;height:57px;"></div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#cboxClose').hide();
$('.popupmiddle #button_yes').click(function() {
	window.location.reload();
});
//--></script>
<?php } else { ?>
<?php echo $header; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle"><?php echo $text_message; ?>
    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location='<?php echo $continue; ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
<?php } ?>
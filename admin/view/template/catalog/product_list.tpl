<?php if($filtertype == ''):?>
<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<style type="text/css">
    .tfilter {
        float: right;
        margin-right: 11px;
        margin-top: 9px;
    }
    .tfilter select {
        height: 23px;
        padding-top: 3px;
        padding-left: 3px;
        cursor: pointer;
    }
    .stupdate img, .stupdatehc img {
        position: absolute;
        margin-top: -8px;
        cursor: pointer;
    }
</style>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/product.png');"><?php echo $heading_title; ?></h1>
    
    <div class="buttons">
	<a onclick="location='<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a>
	<a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><span>Sao chép</span></a>
	<a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
	<!-- giá và danh mục (product_list,header.tpl) -->
    <div class="tfilter">Filter: &nbsp; &nbsp;
      <select id="tfilter">
          <option value="0" <?php echo $cat_id == 0 ? 'selected' : ''; ?>>All</option>
          <?php foreach($categories as $row): ?>
          <option value="<?php echo $row['category_id']  ?>" <?php echo $cat_id == $row['category_id'] ? 'selected' : ''; ?>><?php echo $row['name']  ?></option>
          <?php endforeach; ?>
      </select>
   </div>
  </div>
  
  <div class="content"> 
   <div id="innerconent">
   <?php endif; ?>

    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="center"><?php echo $column_image; ?></td>
            <td class="left"><?php if ($sort == 'pd.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left" style="width:168px"><?php if ($sort == 'p.price') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Price</a>
              <?php } else { ?>
              <a class="button" onclick="updatallprice();"><span>Cập nhật giá HN</span></a>
              <?php } ?></td>
            <td class="left" style="width:168px"><a class="button" onclick="updatallprice_hc();"><span>Cập nhật giá HCM</span></a></td>
            <td class="left" style="width:100px;"><?php if ($sort == 'p.model') { ?>
              <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
              <?php } ?></td>
            <td class="right" style="width:60px;"><?php if ($sort == 'p.quantity') { ?>
              <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'p.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td></td>
            <td><input size="55" type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td></td>
			<td></td>
            <td><input type="text" size="10" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
            <td align="right"><input size="2" type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" style="text-align: right;" /></td>
            <td><select name="filter_status">
                <option value="*"></option>
                <?php if ($filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_status) && !$filter_status) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
          <?php if ($products) { ?>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td style="align: center;"><?php if ($product['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
              <?php } ?></td>
            <td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
            <td class="left"><?php echo $product['name']; ?></td>
            <td class="left stupdate">
				<input size="20" type="text" pid="<?php echo $product['product_id']; ?>" value ="<?php echo $product['price']; ?>" >
				<img src="view/image/adept_update.png" />
			</td>
			<td class="left stupdatehc"><input size="20" phcid="<?php echo $product['product_id']; ?>" type="text" value ="<?php echo $product['price_hc']; ?>" ><img src="view/image/adept_update.png" /></td>
            <td class="left"><?php echo $product['model']; ?></td>
            <td class="right"><?php if ($product['quantity'] <= 0) { ?>
              <span style="color: #FF0000;"><?php echo $product['quantity']; ?></span>
              <?php } elseif ($product['quantity'] <= 5) { ?>
              <span style="color: #FFA500;"><?php echo $product['quantity']; ?></span>
              <?php } else { ?>
              <span style="color: #008000;"><?php echo $product['quantity']; ?></span>
              <?php } ?></td>
            <td class="left"><?php echo $product['status']; ?></td>
            <td class="right"><?php foreach ($product['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php if($filtertype == ''):?>
    </div>
    <script type="text/javascript"><!--
        jQuery(document).ready(function(){
            jQuery('#tfilter').change(function(){
                 jQuery.blockUI({ css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                        } }); 
                url = 'index.php?route=catalog/product';
                jQuery.post(url,{cat_id: jQuery(this).val(),filtertype: 'category'},function(data){
                    jQuery('#innerconent').html(data);
                    jQuery.unblockUI();
                    updateprice();
					
					updateprice_hc();
                });
            });
            
			updateprice();
		   
			updateprice_hc();
        });
      
       function updatallprice(){
            jQuery.blockUI({ css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                } });
			product = 'list';
            jQuery('.stupdate input').each(function(){
                url = 'index.php?route=catalog/product/updateprice';
                jQuery.post(url,{ele_id: jQuery(this).attr('pid'),ele_val : jQuery(this).val()});
				product = product + '_' + jQuery(this).attr('pid');
            });
            jQuery.unblockUI();
			
			url = 'index.php?route=catalog/product/updatepriceHistory';
			jQuery.post(url,{list_product: product});
       }
        
        function updateprice (){
         jQuery('.stupdate img').click(function(){
                   ele = jQuery(this).prev();
                    jQuery.blockUI({ css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                } }); 
                url = 'index.php?route=catalog/product/updateprice';
                jQuery.post(url,{ele_id: ele.attr('pid'),ele_val : ele.val()},function(data){
                    jQuery.unblockUI();
                });
				url = 'index.php?route=catalog/product/updatepriceHistory';
				jQuery.post(url,{list_product: ele.attr('pid')});
				
            });
        }
		
       function updatallprice_hc(){
            jQuery.blockUI({ css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                } });
			product = 'list';
            jQuery('.stupdatehc input').each(function(){
                url = 'index.php?route=catalog/product/updateprice_hc';
                jQuery.post(url,{proid: jQuery(this).attr('phcid'),price_hc_val : jQuery(this).val()});
				product = product + '_' + jQuery(this).attr('phcid');
            });
            jQuery.unblockUI();
			
			url = 'index.php?route=catalog/product/updatepriceHistory';
			jQuery.post(url,{list_product: product});
       }
        
        function updateprice_hc(){
         jQuery('.stupdatehc img').click(function(){
                   elehc = jQuery(this).prev();
                    jQuery.blockUI({ css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                } }); 
                url = 'index.php?route=catalog/product/updateprice_hc';
                jQuery.post(url,{proid: elehc.attr('phcid'),price_hc_val : elehc.val()},function(data){
                    jQuery.unblockUI();
                });
				url = 'index.php?route=catalog/product/updatepriceHistory';
				jQuery.post(url,{list_product: elehc.attr('phcid')});
				
            });
        }
		
        function filter() {
                url = 'index.php?route=catalog/product';

                var filter_name = $('input[name=\'filter_name\']').attr('value');

                if (filter_name) {
                        url += '&filter_name=' + encodeURIComponent(filter_name);
                }

                var filter_model = $('input[name=\'filter_model\']').attr('value');

                if (filter_model) {
                        url += '&filter_model=' + encodeURIComponent(filter_model);
                }

                var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');

                if (filter_quantity) {
                        url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
                }

                var filter_status = $('select[name=\'filter_status\']').attr('value');

                if (filter_status != '*') {
                        url += '&filter_status=' + encodeURIComponent(filter_status);
                }	

                location = url;
        }

//--></script>
  </div>
</div>
<?php echo $footer; ?>
<?php endif; ?>
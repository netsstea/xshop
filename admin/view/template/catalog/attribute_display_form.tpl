<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/attribute_display.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> Tên nhóm thông số</td>
            <td><input size="40"  name="name" value="<?php echo $name; ?>" />
              <span class="error"><?php echo $error_name; ?></span>
              </td>
          </tr>
          <tr>
            <td>Danh mục sản phẩm</td>
            <td><div class="scrollbox" style="height:180px;">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($category['category_id'], $category_id)) { ?>
                  <input type="checkbox" name="category_id[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                  <?php echo $category['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="category_id[]" value="<?php echo $category['category_id']; ?>" />
                  <?php echo $category['name']; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div></td>
          </tr>
          <tr>
            <td>Thông số</td>
            <td><table>
                <tr>
                  <td style="padding: 0;" colspan="3"><select id="attribute_group" style="margin-bottom: 5px;" onchange="getattributebygroup();">
                      <?php foreach ($attribute_groups as $attribute_group) { ?>
                      <option value="<?php echo $attribute_group['attribute_group_id']; ?>"><?php echo $attribute_group['name']; ?></option>
                      <?php } ?>
                    </select></td>
                </tr>
                <tr>
                  <td style="padding: 0;"><select multiple="multiple" id="attribute" size="10" style="width: 300px;">
                    </select></td>
                  <td style="vertical-align: middle;"><input type="button" value="--&gt;" onclick="addattribute();" />
                    <br />
                    <input type="button" value="&lt;--" onclick="removeattribute();" /></td>
                  <td style="padding: 0;"><select multiple="multiple" id="attributed" size="10" style="width: 300px;">
                    </select></td>
                </tr>
              </table>
              <div id="attribute_data">
                <?php foreach ($attribute_data as $attribute_id) { ?>
                <input type="hidden" name="attribute_data[]" value="<?php echo $attribute_id; ?>" />
                <?php } ?>
              </div></td>
          </tr>
        <tr>
          <td>Hiển thị</td>
		  <td><select name="ashow">
			<option value="thongsorutgon"<?php if($ashow=="thongsorutgon") { echo ' selected="selected"'; } ?>>Thông số rút gọn</option>
			<option value="thongsolistsp"<?php if($ashow=="thongsolistsp") { echo ' selected="selected"'; } ?>>Thông số hiển thị ô SP</option>
		  </select></td>
        </tr>
          <tr>
			<td><?php echo $entry_sort_order; ?></td>
			<td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
          </tr>
        </table>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
function addattribute() {
	$('#attribute :selected').each(function() {
		$(this).remove();
		
		$('#attributed option[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#attributed').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		
		$('#attribute_data input[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#attribute_data').append('<input type="hidden" name="attribute_data[]" value="' + $(this).attr('value') + '" />');
	});
}

function removeattribute() {
	$('#attributed :selected').each(function() {
		$(this).remove();
		
		$('#attribute_data input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getattributebygroup() {
	$('#attribute option').remove();
	
	$.ajax({
		url: 'index.php?route=catalog/attribute_display/attribute_group&attribute_group_id=' + $('#attribute_group').attr('value'),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
	 			$('#attribute').append('<option value="' + data[i]['attribute_id'] + '">' + data[i]['name'] + '</option>');
			}
		}
	});
}

function getattribute() {
	$('#attribute option').remove();
	
	$.ajax({
		url: 'index.php?route=catalog/attribute_display/attribute',
		type: 'POST',
		dataType: 'json',
		data: $('#attribute_data input'),
		success: function(data) {
			$('#attribute_data input').remove();
			
			for (i = 0; i < data.length; i++) {
	 			$('#attributed').append('<option value="' + data[i]['attribute_id'] + '">' + data[i]['name'] + '</option>');
				
				$('#attribute_data').append('<input type="hidden" name="attribute_data[]" value="' + data[i]['attribute_id'] + '" />');
			} 
		}
	});
}

getattributebygroup();
getattribute();
//--></script>
<?php echo $footer; ?>
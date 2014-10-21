<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/category.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="languages" class="tabs">
        <?php foreach ($languages as $language) { ?>
        <a tab="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
        <?php } ?>
      </div>
      <?php foreach ($languages as $language) { ?>
      <div id="language<?php echo $language['language_id']; ?>">
		<div id="tabs" class="tabs" style="margin-bottom:0;">
			<a tab="#tab_general">Tổng quan</a>
			<a tab="#tab_seo">SEO Google</a>
			<a tab="#tab_manu">Chọn thương hiệu</a>
		</div>
		<div id="tab_general" class="tab_more">
			<table class="form">
			  <tr>
				<td><span class="required">*</span> <?php echo $entry_name; ?></td>
				<td><input name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" />
				  <?php if (isset($error_name[$language['language_id']])) { ?>
				  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
				  <?php } ?></td>
			  </tr>          
			  <tr>
				<td><?php echo $entry_description; ?></td>
				<td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea></td>
			  </tr>
			</table>
		</div>
		<div id="tab_seo" class="tab_more">
			<table class="form">       
			  <tr>            
				  <td>SEO <?php echo $entry_name; ?></td>
				  <td><input name="category_description[<?php echo $language['language_id']; ?>][name_seo]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name_seo'] : ''; ?>" /></td> 
			  </tr>
			  <tr>
				<td><?php echo $entry_meta_description; ?></td>
				<td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
			  </tr>
			  <tr>
				<td>Keywords</td>
				<td><textarea name="category_description[<?php echo $language['language_id']; ?>][keywords]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['keywords'] : ''; ?></textarea></td>
			  </tr>
			</table>
		</div>
		
		<div id="tab_manu" class="tab_more">
			<table class="list">
			  <thead>
				<tr>
				  <td class="left">Thương hiệu</td>
				  <td class="left">Tên thương hiệu thay thế</td>
				  <td class="left">Sắp xếp</td>
				  <td class="left">Tiêu đề SEO</td>
				  <td class="left">Meta mô tả</td>
				  <td class="left">Meta keywords</td>
				  <td></td>
				</tr>
			  </thead>
			  <?php $manufacturer_row = 0; ?>
			  <?php foreach ($category_manufacturers as $category_manufacturer) { ?>
			  <tbody id="manufacturer_row<?php echo $manufacturer_row; ?>">
				<tr>
				  <td class="left"><select name="category_manufacturer[<?php echo $manufacturer_row; ?>][manufacturer_id]">
					  <?php foreach ($manufacturers as $manufacturer) { ?>
					  <?php if ($manufacturer['manufacturer_id'] == $category_manufacturer['manufacturer_id']) { ?>
					  <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
				  </select></td>
					
				  <td class="left"><input type="text" name="category_manufacturer[<?php echo $manufacturer_row; ?>][ex_name]" value="<?php echo $category_manufacturer['ex_name']; ?>" size="20" /></td>
				  
				  <td class="left"><input type="text" name="category_manufacturer[<?php echo $manufacturer_row; ?>][sort_order]" value="<?php echo $category_manufacturer['sort_order']; ?>" size="2" /></td>
				  
				  <td class="left"><input type="text" name="category_manufacturer[<?php echo $manufacturer_row; ?>][name_seo]" value="<?php echo $category_manufacturer['name_seo']; ?>" size="20" /></td>
				  
				  <td class="left"><textarea name="category_manufacturer[<?php echo $manufacturer_row; ?>][meta_description]" cols="40" rows="5"><?php echo $category_manufacturer['meta_description']; ?></textarea></td>
				  
				  <td class="left"><textarea name="category_manufacturer[<?php echo $manufacturer_row; ?>][keywords]" cols="40" rows="5"><?php echo $category_manufacturer['keywords']; ?></textarea></td>
				  <td class="left"><a onclick="$('#manufacturer_row<?php echo $manufacturer_row; ?>').remove();" class="button"><span>Xoá</span></a></td>
				</tr>
			  </tbody>
			  <?php $manufacturer_row++; ?>
			  <?php } ?>
			  <tbody id="manufacturer">
				<tr class="filter">
				  <td class="left"><select id="manufacturer_manufacturer_id">
					  <?php foreach ($manufacturers as $manufacturer) { ?>
						<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
					  <?php } ?>
				  </select></td>
					
				  <td class="left"><input type="text" id="manufacturer_ex_name" value="" size="20" /></td>
					
				  <td class="left"><input type="text" id="manufacturer_sort_order" value="" size="2" /></td>
				  
				  <td class="left"><input type="text" id="manufacturer_name_seo" value="" size="20" /></td>
				  
				  <td class="left"><textarea id="manufacturer_meta_description" cols="40" rows="5"></textarea></td>
				  
				  <td class="left"><textarea id="manufacturer_keywords" cols="40" rows="5"></textarea></td>
				  
				  <td class="left"><a onclick="addmanufacturer();" class="button"><span>Thêm thương hiệu</span></a></td>
				</tr>
			  </tbody>
			</table>
		</div>
      </div>
      <?php } ?>
      <table class="form">
        <tr>
          <td><?php echo $entry_category; ?></td>
          <td><select name="parent_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $parent_id) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td>Hiển thị</td>
            <td><div class="scrollbox" style="overflow:visible; height:auto !important;">
				<div class="even">
					<input type="checkbox" name="cshow[]" value="menu=1" <?php if (in_array('menu=1', $cshow)) { echo 'checked="checked"'; } ?> />Menu thương hiệu
				</div>
				<div class="odd">
					<input type="checkbox" name="cshow[]" value="thuonghieu=1" <?php if (in_array('thuonghieu=1', $cshow)) { echo 'checked="checked"'; } ?> />Thương hiệu
				</div>
                <?php $class = 'odd'; ?>
                <?php foreach ($phanloais as $phanloai) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <input type="checkbox" name="cshow[]" value="phanloai_id=<?php echo $phanloai['phanloai_id']; ?>" <?php if (in_array('phanloai_id=' . $phanloai['phanloai_id'], $cshow)) { echo 'checked="checked"'; } ?> />
                  <?php echo $phanloai['name']; ?>
                </div>
                <?php } ?>
              </div></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td>Hình trên menu</td>
          <td valign="top"><input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <img src="<?php echo $preview; ?>" alt="" id="preview" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('image', 'preview');" />
			
			<img onclick="$('#preview').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="cdelelte" src="view/image/del.png" />
			</td>
        </tr>
        <tr>
          <td>Banner</td>
          <td valign="top"><input type="hidden" name="banner" value="<?php echo $banner; ?>" id="banner" />
            <img src="<?php echo $preview_banner; ?>" alt="" id="preview_banner" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('banner', 'preview_banner');" />
			
			<img onclick="$('#preview_banner').attr('src', '<?php echo $no_image; ?>'); $('#banner').attr('value', '');" class="cdelelte" src="view/image/del.png" />
			</td>
        </tr>
        <tr>
          <td>icon menu</td>
          <td valign="top"><input type="hidden" name="icon_menu" value="<?php echo $icon_menu; ?>" id="icon_menu" />
            <img src="<?php echo $preview_icon_menu; ?>" alt="" id="preview_icon_menu" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('icon_menu', 'preview_icon_menu');" />
			
			<img onclick="$('#preview_icon_menu').attr('src', '<?php echo $no_image; ?>'); $('#icon_menu').attr('value', '');" class="cdelelte" src="view/image/del.png" />
			</td>
        </tr>
        <tr>
          <td>icon mobile</td>
          <td valign="top"><input type="hidden" name="icon_mobile" value="<?php echo $icon_mobile; ?>" id="icon_mobile" />
            <img src="<?php echo $preview_icon_mobile; ?>" alt="" id="preview_icon_mobile" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('icon_mobile', 'preview_icon_mobile');" />
			
			<img onclick="$('#preview_icon_mobile').attr('src', '<?php echo $no_image; ?>'); $('#icon_mobile').attr('value', '');" class="cdelelte" src="view/image/del.png" />
			</td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
<?php } ?>
//--></script>
<script type="text/javascript"><!--
var manufacturer_row = <?php echo $manufacturer_row; ?>;

function addmanufacturer() {
	html  = '<tbody id="manufacturer_row' + manufacturer_row + '">';
	html += '<tr>'; 
    html += '<td class="left"><select name="category_manufacturer[' + manufacturer_row + '][manufacturer_id]" id="category_manufacturer_' + manufacturer_row + '_manufacturer_id">';
    <?php foreach ($manufacturers as $manufacturer) { ?>
    html += '<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';
	html += '<td class="left"><input type="text" name="category_manufacturer[' + manufacturer_row + '][ex_name]" value="' + $('#manufacturer_ex_name').attr('value') + '" /></td>';	
    html += '<td class="left"><input type="text" name="category_manufacturer[' + manufacturer_row + '][sort_order]" value="' + $('#manufacturer_sort_order').attr('value') + '" size="2" /></td>';
	html += '<td class="left"><input type="text" name="category_manufacturer[' + manufacturer_row + '][name_seo]" value="' + $('#manufacturer_name_seo').attr('value') + '" /></td>';
    html += '<td class="left"><textarea name="category_manufacturer[' + manufacturer_row + '][meta_description]" cols="40" rows="5">' + $('#manufacturer_meta_description').attr('value') + '</textarea></td>';
	html += '<td class="left"><textarea name="category_manufacturer[' + manufacturer_row + '][keywords]" cols="40" rows="5">' + $('#manufacturer_keywords').attr('value') + '</textarea></td>';
	html += '<td class="left"><a onclick="$(\'#manufacturer_row' + manufacturer_row + '\').remove();" class="button"><span>Xoá</span></a></td>';
	html += '</tr>';
    html += '</tbody>';
	
	$('#manufacturer').before(html);

	$('#category_manufacturer_' + manufacturer_row + '_manufacturer_id').attr('value', $('#manufacturer_manufacturer_id').attr('value'));
	
	$('#manufacturer_manufacturer_id option').attr('selected', '');
	$('#manufacturer_ex_name').attr('value', '');
	$('#manufacturer_sort_order').attr('value', '');
	$('#manufacturer_name_seo').attr('value', '');
	$('#manufacturer_meta_description').val( '');
	$('#manufacturer_keywords').val('');
	
	manufacturer_row++;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" style="border: 1px solid #EEEEEE;" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<script type="text/javascript"><!--
$.tabs('#languages.tabs a'); 
$.tabs('#tabs.tabs a'); 
//--></script>
<?php echo $footer; ?>
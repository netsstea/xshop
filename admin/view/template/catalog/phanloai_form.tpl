<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/shipping.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="tabs">
        <?php foreach ($languages as $language) { ?>
        <a tab="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
        <?php } ?>
      </div>
      <?php foreach ($languages as $language) { ?>
      <div id="language<?php echo $language['language_id']; ?>">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><input name="phanloai_info[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($phanloai_info[$language['language_id']]) ? $phanloai_info[$language['language_id']]['name'] : ''; ?>" />
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td><input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <img src="<?php echo $preview; ?>" alt="" id="preview" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('image', 'preview');" /></td>
        </tr>
      </table>
      </div>
      <?php } ?>
	  <table class="form">
        <tr>
          <td><?php echo $entry_phanloai; ?></td>
          <td><select name="parent_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($phanloais as $phanloai) { ?>
			  <?php if ($phanloai['phanloai_id'] != $phanloai_id) { ?>
              <?php if ($phanloai['phanloai_id'] == $parent_id) { ?>
              <option value="<?php echo $phanloai['phanloai_id']; ?>" selected="selected"><?php echo $phanloai['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $phanloai['phanloai_id']; ?>"><?php echo $phanloai['name']; ?></option>
              <?php } ?>
			  <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
          <tr>
            <td>Danh mục sản phẩm</td>
            <td><div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($category['category_id'], $phanloai_category)) { ?>
                  <input type="checkbox" name="phanloai_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                  <?php echo $category['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="phanloai_category[]" value="<?php echo $category['category_id']; ?>" />
                  <?php echo $category['name']; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div></td>
          </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
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
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>
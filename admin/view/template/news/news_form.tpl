<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/news.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
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
            <td><input name="news_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['name'] : ''; ?>" />
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_description; ?></td>
            <td><textarea name="news_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['description'] : ''; ?></textarea>
              <?php if (isset($error_description[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td>Tags<br /><span class="help">Ngăn cách bằng dấu phẩy</span></td>
            <td><input name="news_description[<?php echo $language['language_id']; ?>][tags]" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['tags'] : ''; ?>" />
			</td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <table class="form">
		<tr>
		  <td>Danh mục tin tức</td>
		  <td>
			<div class="scrollbox">
			<?php $class = 'odd'; ?>
			<?php foreach ($cnewss as $cnews) { ?>
			<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
			<div class="<?php echo $class; ?>">
			  <?php if (in_array($cnews['cnews_id'], $news_cnews)) { ?>
			  <input type="checkbox" name="news_cnews[]" value="<?php echo $cnews['cnews_id']; ?>" checked="checked" />
			  <?php echo $cnews['name']; ?>
			  <?php } else { ?>
			  <input type="checkbox" name="news_cnews[]" value="<?php echo $cnews['cnews_id']; ?>" />
			  <?php echo $cnews['name']; ?>
			  <?php } ?>
			</div>
			<?php } ?>
			</div></td>
		</tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td><input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <img src="<?php echo $preview; ?>" alt="" id="preview" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="view/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('image', 'preview');" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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
$.tabs('.tabs a'); 
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
<?php echo $footer; ?>
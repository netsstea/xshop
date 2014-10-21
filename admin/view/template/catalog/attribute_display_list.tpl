<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/attribute_display.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location='<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'a.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
			  <td class="left">Danh mục sản phẩm</td>
			  <td class="left">Hiển thị</td>
              <td class="right"><?php if ($sort == 'a.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($attribute_displays) { ?>
          <?php foreach ($attribute_displays as $attribute_display) { ?>
          <tr>
            <td style="align: center;"><?php if ($attribute_display['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $attribute_display['attribute_display_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $attribute_display['attribute_display_id']; ?>" />
              <?php } ?></td>
            <td class="left"><?php echo $attribute_display['name']; ?></td>
			<td class="left"><?php echo $attribute_display['category_name']; ?></td>
            <td class="right"><?php echo $attribute_display['sort_order']; ?></td>
			<td class="right"><?php if($attribute_display['ashow'] == 'thongsorutgon') { echo 'Thông số rút gọn'; } else { echo 'Thông số hiển thị ô SP'; } ?></td>
            <td class="right"><?php foreach ($attribute_display['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>
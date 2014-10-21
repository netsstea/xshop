<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/attribute.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> Tên thông số</td>
            <td><input size="40"  name="name" value="<?php echo $name; ?>" />
              <span class="error"><?php echo $error_name; ?></span>
              </td>
          </tr>
          <tr>
            <td>Thông số mặc định</td>
            <td><input size="40"  name="text_default" value="<?php echo $text_default; ?>" />
              </td>
          </tr>
          <tr>
            <td>Nhóm thông số</td>
            <td><select name="attribute_group_id">
                <option value="0" selected="selected"><?php echo $text_none; ?></option>
                <?php foreach ($attributegroups as $attributegroup) { ?>
                <?php if ($attributegroup['attribute_group_id'] == $attribute_group_id) { ?>
                <option value="<?php echo $attributegroup['attribute_group_id']; ?>" selected="selected"><?php echo $attributegroup['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $attributegroup['attribute_group_id']; ?>"><?php echo $attributegroup['name']; ?></option>
                <?php } ?>
                <?php } ?>
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
<?php echo $footer; ?>
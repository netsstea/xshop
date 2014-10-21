<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/attribute_group.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
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
            <td><div class="scrollbox" style="height:280px;">
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
			<td><?php echo $entry_sort_order; ?></td>
			<td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
          </tr>
        </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>
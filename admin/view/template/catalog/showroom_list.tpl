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
    <h1 style="background-image: url('view/image/shipping.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location='<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left">Tên showroom</td>
            <td class="left">Địa chỉ</td>
			<td class="left">Hotline</td>
			<td class="left">Điện thoại</td>
			<td class="left">Fax</td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($showrooms) { ?>
          <?php foreach ($showrooms as $showroom) { ?>
          <tr>
            <td style="align: center;"><?php if ($showroom['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $showroom['showroom_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $showroom['showroom_id']; ?>" />
              <?php } ?></td>
            <td class="left"><?php echo $showroom['name']; ?></td>
            <td class="left"><?php echo $showroom['address']; ?></td>
			<td class="left"><?php echo $showroom['hotline']; ?></td>
			<td class="left"><?php echo $showroom['telephone']; ?></td>
			<td class="left"><?php echo $showroom['fax']; ?></td>
            <td class="right"><?php foreach ($showroom['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>
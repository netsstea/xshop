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
      <table class="form">
        <tr>
          <td><span class="required">*</span> Tên showroorm</td>
          <td><input name="name" value="<?php echo $name; ?>" />
            <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td>Địa chỉ</td>
          <td><input name="address" value="<?php echo $address; ?>" /></td>
        </tr>
        <tr>
          <td>Hotline</td>
          <td><input name="hotline" value="<?php echo $hotline; ?>" /></td>
        </tr>
        <tr>
          <td>Điện thoại</td>
          <td><input name="telephone" value="<?php echo $telephone; ?>" /></td>
        </tr>
        <tr>
          <td>Fax</td>
          <td><input name="fax" value="<?php echo $fax; ?>" /></td>
        </tr>
        <tr>
            <td>Tỉnh/Thành Phố</td>
            <td><select name="zone_id">
                <?php foreach ($zones as $zone) { ?>
                <?php if ($zone['zone_id'] == $zone_id) { ?>
                <option value="<?php echo $zone['zone_id']; ?>" selected="selected"><?php echo $zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td>Link Google Maps</td>
          <td><textarea name="google_maps" cols="80" rows="6"><?php echo $google_maps; ?></textarea></td>
        </tr>
        <tr>
          <td>Sắp xếp</td>
          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>
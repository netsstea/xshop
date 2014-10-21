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
          <td>URL gốc</td>
          <td><input name="url_goc" style="height:30px;width:500px;" value="<?php echo $url_goc; ?>" /></td>
        </tr>
        <tr>
          <td>URL đích</td>
          <td><input name="url_dich" style="height:30px;width:500px;" value="<?php echo $url_dich; ?>" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>
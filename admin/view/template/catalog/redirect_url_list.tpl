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
            <td class="left"><?php if ($sort == 'url_goc') { ?>
              <a href="<?php echo $sort_url_goc; ?>" class="<?php echo strtolower($order); ?>">URL gốc</a>
              <?php } else { ?>
              <a href="<?php echo $sort_url_goc; ?>">URL gốc</a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'url_dich') { ?>
              <a href="<?php echo $sort_url_dich; ?>" class="<?php echo strtolower($order); ?>">URL đích</a>
              <?php } else { ?>
              <a href="<?php echo $sort_url_dich; ?>">URL đích</a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($redirect_urls) { ?>
          <?php foreach ($redirect_urls as $redirect_url) { ?>
          <tr>
            <td style="align: center;"><?php if ($redirect_url['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $redirect_url['redirect_url_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $redirect_url['redirect_url_id']; ?>" />
              <?php } ?></td>
            <td class="left"><?php echo $redirect_url['url_goc']; ?></td>
            <td class="left"><?php echo $redirect_url['url_dich']; ?></td>
            <td class="right"><?php foreach ($redirect_url['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>
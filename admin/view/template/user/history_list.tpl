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
    <h1 style="background-image: url('view/image/user.png');">Lịch sử thay đổi</h1>
    <div class="buttons"><a onclick="$('form').submit();" class="button"><span>Xoá</span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left">Tên thành viên</td>
            <td class="left">Module thay đổi</td>
			<td class="left">Nội dung thay đổi</td>
            <td class="right">Thời gian thay đổi</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($historis) { ?>
          <?php foreach ($historis as $history) { ?>
          <tr>
            <td style="align: center;"><?php if ($history['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $history['history_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $history['history_id']; ?>" />
              <?php } ?></td>
            <td class="left"><?php echo $history['username']; ?></td>
            <td class="left"><?php echo $history['generic']; ?></td>
			<td class="left">
				<b><?php echo $history['username']; ?></b> vừa <?php echo $history['format']; ?> <?php echo $history['generic']; ?>
				<?php echo $history['datah']; ?>
			</td>
            <td class="right"><?php echo $history['date_added']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5">Không có dữ liệu</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
  </div>
</div>
<div class="pagination"><?php echo $pagination; ?></div>
<?php echo $footer; ?>
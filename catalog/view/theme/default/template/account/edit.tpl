<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="edit">
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_your_details; ?></b>
      <div class="content">
        <table>
          <tr>
            <td width="150"><?php echo $entry_customername; ?></td>
            <td><input type="text" name="customername" value="<?php echo $customername; ?>" /><span class="required">(<font>*</font>)</span>
              <?php if ($error_customername) { ?>
              <span class="error"><?php echo $error_customername; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><input type="text" name="email" value="<?php echo $email; ?>" /><span class="required">(<font>*</font>)</span>
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?></td>
            <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" /><span class="required">(<font>*</font>)</span>
              <?php if ($error_telephone) { ?>
              <span class="error"><?php echo $error_telephone; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td>Giới tính</td>
            <td>
				<table width="120" cellpadding="0">
				  <tr>
					<td width="1">
						<input <?php if($gender=='male') { echo 'checked="checked"';} ?> style="width:auto;" type="radio" name="gender" value="male" id="gd_male" />
					</td>
					<td><label for="gd_male" style="cursor: pointer;">Nam</label></td>
					<td width="1">
						<input <?php if($gender=='female') { echo 'checked="checked"';} ?> style="width:auto;" type="radio" name="gender" value="female" id="gd_female" />
					</td>
					<td><label for="gd_female" style="cursor: pointer;">Nữ</label></td>
				  </tr>
				</table>
            </td>
          </tr>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="location='<?php echo $back; ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td align="right"><a onclick="$('#edit').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
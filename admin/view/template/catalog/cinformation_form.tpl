<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/cinformation.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
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
            <td><input name="cinformation_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($cinformation_description[$language['language_id']]) ? $cinformation_description[$language['language_id']]['name'] : ''; ?>" />
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <table class="form">
        <tr>
          <td>Hiển thị</td>
		  <td><select name="cshow">
			<option value="">--- Không ---</option>
			<option value="header"<?php if($cshow=="header") { echo ' selected="selected"'; } ?>>Header(Đầu trang)</option>
			<option value="footer"<?php if($cshow=="footer") { echo ' selected="selected"'; } ?>>Footer(Chân trang)</option>
			<option value="sidebar"<?php if($cshow=="sidebar") { echo ' selected="selected"'; } ?>>Sidebar(Thanh bên phải)</option>
			<option value="product"<?php if($cshow=="product") { echo ' selected="selected"'; } ?>>Chi tiết sản phẩm</option>
			<option value="dichvu"<?php if($cshow=="dichvu") { echo ' selected="selected"'; } ?>>Dịch vụ</option>
			<option value="daotao"<?php if($cshow=="daotao") { echo ' selected="selected"'; } ?>>Đào tạo</option>
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
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>
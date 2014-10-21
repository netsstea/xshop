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
    <h1 style="background-image: url('view/image/newsletter.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location='<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'gender') { ?>
              <a href="<?php echo $sort_gender; ?>"><?php echo $column_gender; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_gender; ?>"><?php echo $column_gender; ?></a>
              <?php } ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><select name="filter_gender">
                <option value="*"></option>
                <?php if ($filter_gender) { ?>
                <option value="male" selected="selected">Nam</option>
                <?php } else { ?>
                <option value="male">Nam</option>
                <?php } ?>
                <?php if (!is_null($filter_gender) && !$filter_gender) { ?>
                <option value="female" selected="selected">Nữ</option>
                <?php } else { ?>
                <option value="female">Nữ</option>
                <?php } ?>
              </select></td>
            <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
          <?php if ($newsletters) { ?>
          <?php foreach ($newsletters as $newsletter) { ?>
          <tr>
            <td style="align: center;"><?php if ($newsletter['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $newsletter['newsletter_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $newsletter['newsletter_id']; ?>" />
              <?php } ?></td>
            <td class="left">
				<?php if($newsletter['gender'] == 'male') { echo "Nam"; } else { echo "Nữ"; } ?>
			</td>
            <td class="left"><?php echo $newsletter['email']; ?></td>
            <td class="left"><?php echo $newsletter['date_added']; ?></td>
            <td class="right"><?php foreach ($newsletter['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/newsletter';
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_gender = $('select[name=\'filter_gender\']').attr('value');
	
	if (filter_gender != '*') {
		url += '&filter_gender=' + encodeURIComponent(filter_gender);
	}	

	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?>
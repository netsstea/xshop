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
    <h1 style="background-image: url('view/image/slideshow.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location='<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
  <div class="laybanner">
	<div class="bl"><span>BL - Banner Left<br/>(145x668)</span>
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'bl\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'id.title') { ?>
              <?php echo $column_name; ?>
              <?php } else { ?>
              <?php echo $column_name; ?>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($slideshows) { ?>
          <?php foreach ($slideshows as $slideshow) { ?>
			  <?php if ($slideshow['sshow'] == 'bl') { ?>
			  <tr>
				<td style="align: center;"><?php if ($slideshow['selected']) { ?>
				  <input id="bl" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
				  <?php } else { ?>
				  <input id="bl" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
				  <?php } ?></td>
				<td class="left"><?php echo $slideshow['name']; ?></td>
				<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
				  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				  <?php } ?></td>
			  </tr>
			  <?php } ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
	  <p><a onclick="location='<?php echo $insert; ?>&sshow=bl'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
	</div>
	<div class="br"><span>BR - Banner Right<br/>(145x668)</span>
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'br\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'id.title') { ?>
              <?php echo $column_name; ?>
              <?php } else { ?>
              <?php echo $column_name; ?>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($slideshows) { ?>
          <?php foreach ($slideshows as $slideshow) { ?>
			  <?php if ($slideshow['sshow'] == 'br') { ?>
			  <tr>
				<td style="align: center;"><?php if ($slideshow['selected']) { ?>
				  <input id="br" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
				  <?php } else { ?>
				  <input id="br" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
				  <?php } ?></td>
				<td class="left"><?php echo $slideshow['name']; ?></td>
				<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
				  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				  <?php } ?></td>
			  </tr>
			  <?php } ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
	  <p><a onclick="location='<?php echo $insert; ?>&sshow=br'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
	</div>
	<div class="bh">
		<div class="tlh"><span>TLH - Top Left Home <br/>(520x312)</span>
		  <table class="list">
			<thead>
			  <tr>
				<td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'tlh\']').attr('checked', this.checked);" /></td>
				<td class="left"><?php if ($sort == 'id.title') { ?>
				  <?php echo $column_name; ?>
				  <?php } else { ?>
				  <?php echo $column_name; ?>
				  <?php } ?></td>
				<td class="right"><?php echo $column_action; ?></td>
			  </tr>
			</thead>
			<tbody>
			  <?php if ($slideshows) { ?>
			  <?php foreach ($slideshows as $slideshow) { ?>
				  <?php if ($slideshow['sshow'] == 'tlh') { ?>
				  <tr>
					<td style="align: center;"><?php if ($slideshow['selected']) { ?>
					  <input id="tlh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
					  <?php } else { ?>
					  <input id="tlh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
					  <?php } ?></td>
					<td class="left"><?php echo $slideshow['name']; ?></td>
					<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
					  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
					  <?php } ?></td>
				  </tr>
				  <?php } ?>
			  <?php } ?>
			  <?php } else { ?>
			  <tr>
				<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
			  </tr>
			  <?php } ?>
			</tbody>
		  </table>
		  <p><a onclick="location='<?php echo $insert; ?>&sshow=tlh'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
		</div>
		<div class="trh">
			<div class="trh1"><span>TRH1 - Top Right Home 1 <br/>(298x150)</span>
			  <table class="list">
				<thead>
				  <tr>
					<td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'trh1\']').attr('checked', this.checked);" /></td>
					<td class="left"><?php if ($sort == 'id.title') { ?>
					  <?php echo $column_name; ?>
					  <?php } else { ?>
					  <?php echo $column_name; ?>
					  <?php } ?></td>
					<td class="right"><?php echo $column_action; ?></td>
				  </tr>
				</thead>
				<tbody>
				  <?php if ($slideshows) { ?>
				  <?php foreach ($slideshows as $slideshow) { ?>
					  <?php if ($slideshow['sshow'] == 'trh1') { ?>
					  <tr>
						<td style="align: center;"><?php if ($slideshow['selected']) { ?>
						  <input id="trh1" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
						  <?php } else { ?>
						  <input id="trh1" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
						  <?php } ?></td>
						<td class="left"><?php echo $slideshow['name']; ?></td>
						<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
						  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
						  <?php } ?></td>
					  </tr>
					  <?php } ?>
				  <?php } ?>
				  <?php } else { ?>
				  <tr>
					<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			  </table>
			  <p><a onclick="location='<?php echo $insert; ?>&sshow=trh1'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
			</div>
			<div class="trh2"><span>TRH1 - Top Right Home 2 <br/>(298x150)</span>
			  <table class="list">
				<thead>
				  <tr>
					<td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'trh2\']').attr('checked', this.checked);" /></td>
					<td class="left"><?php if ($sort == 'id.title') { ?>
					  <?php echo $column_name; ?>
					  <?php } else { ?>
					  <?php echo $column_name; ?>
					  <?php } ?></td>
					<td class="right"><?php echo $column_action; ?></td>
				  </tr>
				</thead>
				<tbody>
				  <?php if ($slideshows) { ?>
				  <?php foreach ($slideshows as $slideshow) { ?>
					  <?php if ($slideshow['sshow'] == 'trh2') { ?>
					  <tr>
						<td style="align: center;"><?php if ($slideshow['selected']) { ?>
						  <input id="trh2" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
						  <?php } else { ?>
						  <input id="trh2" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
						  <?php } ?></td>
						<td class="left"><?php echo $slideshow['name']; ?></td>
						<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
						  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
						  <?php } ?></td>
					  </tr>
					  <?php } ?>
				  <?php } ?>
				  <?php } else { ?>
				  <tr>
					<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			  </table>
			  <p><a onclick="location='<?php echo $insert; ?>&sshow=trh2'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
			</div>
		</div>
		
		<div class="bbh">
			<div class="blh"><span>BLH - Bottom Left Home (523x150)</span>
			  <table class="list">
				<thead>
				  <tr>
					<td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'blh\']').attr('checked', this.checked);" /></td>
					<td class="left"><?php if ($sort == 'id.title') { ?>
					  <?php echo $column_name; ?>
					  <?php } else { ?>
					  <?php echo $column_name; ?>
					  <?php } ?></td>
					<td class="right"><?php echo $column_action; ?></td>
				  </tr>
				</thead>
				<tbody>
				  <?php if ($slideshows) { ?>
				  <?php foreach ($slideshows as $slideshow) { ?>
					  <?php if ($slideshow['sshow'] == 'blh') { ?>
					  <tr>
						<td style="align: center;"><?php if ($slideshow['selected']) { ?>
						  <input id="blh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
						  <?php } else { ?>
						  <input id="blh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
						  <?php } ?></td>
						<td class="left"><?php echo $slideshow['name']; ?></td>
						<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
						  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
						  <?php } ?></td>
					  </tr>
					  <?php } ?>
				  <?php } ?>
				  <?php } else { ?>
				  <tr>
					<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			  </table>
			  <p><a onclick="location='<?php echo $insert; ?>&sshow=blh'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
			</div>
			<div class="brh"><span>BRH - Bottom Right Home (523x150)</span>
			  <table class="list">
				<thead>
				  <tr>
					<td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\'][id=\'brh\']').attr('checked', this.checked);" /></td>
					<td class="left"><?php if ($sort == 'id.title') { ?>
					  <?php echo $column_name; ?>
					  <?php } else { ?>
					  <?php echo $column_name; ?>
					  <?php } ?></td>
					<td class="right"><?php echo $column_action; ?></td>
				  </tr>
				</thead>
				<tbody>
				  <?php if ($slideshows) { ?>
				  <?php foreach ($slideshows as $slideshow) { ?>
					  <?php if ($slideshow['sshow'] == 'brh') { ?>
					  <tr>
						<td style="align: center;"><?php if ($slideshow['selected']) { ?>
						  <input id="brh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
						  <?php } else { ?>
						  <input id="brh" type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
						  <?php } ?></td>
						<td class="left"><?php echo $slideshow['name']; ?></td>
						<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
						  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
						  <?php } ?></td>
					  </tr>
					  <?php } ?>
				  <?php } ?>
				  <?php } else { ?>
				  <tr>
					<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			  </table>
			  <p><a onclick="location='<?php echo $insert; ?>&sshow=brh'" class="button balign"><span><?php echo $button_insert; ?></span></a></p>
			</div>
		</div>
	</div>
  </div>
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'id.title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="right"><?php if ($sort == 'i.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($slideshows) { ?>
          <?php foreach ($slideshows as $slideshow) { ?>
			  <?php if (!$slideshow['sshow']) { ?>
			  <tr>
				<td style="align: center;"><?php if ($slideshow['selected']) { ?>
				  <input type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" checked="checked" />
				  <?php } else { ?>
				  <input type="checkbox" name="selected[]" value="<?php echo $slideshow['slideshow_id']; ?>" />
				  <?php } ?></td>
				<td class="left"><?php echo $slideshow['name']; ?></td>
				<td class="right"><?php echo $slideshow['sort_order']; ?></td>
				<td class="right"><?php foreach ($slideshow['action'] as $action) { ?>
				  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				  <?php } ?></td>
			  </tr>
			  <?php } ?>
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
<?php foreach ($phanloais as $phanloai) { ?>
<?php if(sizeof($phanloai['children'])) { ?>
<?php $name_select = ''; ?>
<?php foreach ($phanloai['children'] as $children) { ?>
<?php if (in_array($children['phanloai_id'],$plid)) { ?>
	<?php $name_select = $children['name']; ?>
	<?php
		if(sizeof($plid) <= 1) {
			$href_all = str_replace('&plid=' . $children['phanloai_id'],'',$phanloai_href_all);
		} else {
			$href_all = str_replace('__','',str_replace($children['phanloai_id'],'_',$phanloai_href_all));
		}
	?>
<?php } ?>
<?php } ?>
<?php if(!isset($href_all)) { $href_all = '';} ?>
<div class="box_phanloai">
	<div class="box_title">
		<?php if($name_select) { ?>
			<a class="crfselected"><?php echo $name_select; ?></a>
		<?php } else { ?>
			<a class="crfselected"><?php echo $phanloai['name']; ?></a>
		<?php } ?>
	</div>
	<div class="box_content">
		<ul class="boxc_ul">
			<li id="boxall" <?php if(!$name_select) { echo ' class="selected"'; } ?>><a <?php if($name_select) { echo 'href="' . $href_all . '"'; } ?>>Tất cả <?php echo $phanloai['name']; ?>
			</a></li>
		  <?php if($name_select) { ?>
			<li class="selected"><a><?php echo $name_select; ?></a></li>
		  <?php } else { ?>
		  <?php foreach ($phanloai['children'] as $children) { ?>
				<li><a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a></li>
		  <?php } ?>
		  <?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
<?php } ?>
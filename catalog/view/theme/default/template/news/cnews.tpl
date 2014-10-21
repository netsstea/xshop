<?php echo $header; ?>
<div id="column_right">
	<?php echo $cnews; ?>
</div>
<div id="content" class="col_right">
  <div class="top">
	<div class="left"></div>
	<div class="right"></div>
    <div class="center">
     <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if ($description) { ?>
    <div style="margin:0 5px 15px;"><?php echo $description; ?></div>
    <?php } ?>
 	<ul class="listnews">
	<?php foreach ($newss as $news) { ?>
		<li>
		<h3 class="info_title">
			<a  href="<?php echo $news['href']; ?>"><?php echo $news['name']; ?></a>
		</h3>
		<div class="information">
		<?php if ($news['image'] == "image/no_image.jpg") { ?>
		
			<?php if($news['date_added']) { ?><div class="cn_date_added"><?php echo $news['date_added']; ?></div><?php } ?>
			
			<div class="info_desc no_image"><?php echo $news['description']; ?></div>
			
		<?php } else { ?>
		
			<div class="info_image"><a href="<?php echo $news['href']; ?>"><img alt="<?php echo $news['name']; ?>" src="<?php echo $news['image']; ?>" /></a></div>
			
			<?php if($news['date_added']) { ?><div class="cn_date_added"><?php echo $news['date_added']; ?></div> <?php } ?>
			
			<div class="info_desc yes_image"><?php echo $news['description']; ?></div>
			
		<?php } ?>
		</div>
		<div class="xemtiep"><a href="<?php echo $news['href']; ?>" class="button"><span>Xem tiếp</span></a></div>
		</li>
    <?php } ?>
	</ul>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
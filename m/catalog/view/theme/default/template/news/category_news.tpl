<?php echo $header; ?>
<div id="content">
  <div class="top">
	<div class="left"></div>
	<div class="right"></div>
    <div class="center">
     <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
	<div style="padding:10px 10px 0;">
	<select onchange="location=this.value" class="mct_select" style="margin-bottom:0;">
		<option value="<?php echo $tintuc; ?>">Tất cả tin tức</option>
		<?php foreach ($cnews as $cnew) { ?>
			<option value="<?php echo $cnew['href']; ?>"<?php if($category_news_id == $cnew['category_news_id']) { echo ' selected="selected"'; } ?>><?php echo $cnew['name']; ?></option>
		<?php } ?>
	</select>
	</div>
    <?php if ($description) { ?>
    <div style="margin:0 5px 15px;"><?php echo $description; ?></div>
    <?php } ?>
 	<table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border-bottom:1px solid #EEE;">
	<?php foreach ($newss as $news) { ?>
		<tr>
		<td valign="top" colspan="2">
		<div class="news_name"><a  href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?></a></div>
		</td>
		</tr>
		<tr>
		<?php if ($news['image'] == "image/no_image.jpg") { ?>
		<td valign="top" colspan="2" style="font-size:12px;padding:0 5px" class="news_desc">
		<div style="text-align:left;padding:0px;font-size:11px;color:#888"><?php echo $news['date_added']; ?></div>
		<?php echo mb_substr(strip_tags(html_entity_decode($news['description'], ENT_QUOTES, 'UTF-8')),0,700,'UTF-8'); ?>...</td>
		<?php } else { ?>
		<td width="1%" valign="top" class="news_desc">
		<a   href="<?php echo $news['href']; ?>"><img alt="<?php echo $news['title']; ?>" width="100" height="80" src="<?php echo $news['image']; ?>" /></a>
		</td>
		<td valign="top" style="font-size:12px;padding:5px">
		<div style="text-align:left;padding:0px;font-size:11px;color:#888"><?php echo $news['date_added']; ?></div>
		<?php echo mb_substr(strip_tags(html_entity_decode($news['description'], ENT_QUOTES, 'UTF-8')),0,220,'UTF-8'); ?>...
		</td>
		<?php } ?>
		</tr>
    <?php } ?>
	</table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
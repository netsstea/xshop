<?php echo $header; ?>
<div id="content">
  <div class="top">
	<div class="left"></div>
	<div class="right"></div>
    <div class="center">
      <h1 class="news"><a href="<?php echo $category_news_href; ?>"><?php echo $category_news_name; ?></a></h1>
    </div>
  </div>
 <div class="middle cm_info">
  <h2><?php echo $heading_title; ?></h2>
 <div class="date_added"><?php echo $date_added; ?></div>
 <div style="min-height:250px;text-align:left;overflow:hidden;">
  <?php echo str_replace('background-color','rel',str_replace('width="','max-width="',str_replace('height="','max-height="',str_replace('height:','max-height:',str_replace('width:','max-width:',$description))))); ?>
  </div>

<?php if ($tinmois) { ?>
<div class="heading">Tin mới</div>
<div id="news"><ul>
	<?php foreach ($tinmois as $tinmoi) { ?>
	<li><a  href="<?php echo $tinmoi['href']; ?>"><?php echo $tinmoi['title']; ?></a> <span style="color:#777;"><?php echo $tinmoi['date_added']; ?></span></li>
    <?php } ?> 
</ul></div>
<br/>
<?php } ?> 
<?php if ($tinkhacs) { ?>
<div class="heading">Các tin khác</div>
<div id="news"><ul>
	<?php foreach ($tinkhacs as $tinkhac) { ?>
	<li><a  href="<?php echo $tinkhac['href']; ?>"><?php echo $tinkhac['title']; ?></a> <span style="color:#777;"><?php echo $tinkhac['date_added']; ?></span></li>
    <?php } ?> 
</ul></div>
<?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
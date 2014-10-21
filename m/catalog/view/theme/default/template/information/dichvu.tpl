<?php echo $header; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle" style="margin-bottom:20px;">
    <ul id="ullistcat">
      <?php foreach ($dichvus as $dichvu) { ?>
		<li><a href="<?php echo $dichvu['href']; ?>"><?php echo $dichvu['title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
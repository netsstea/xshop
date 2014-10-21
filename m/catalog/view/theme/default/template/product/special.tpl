<?php echo $header; ?>
<div id="content" class="ctproduct">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if ($products) { ?>
    <div class="sort">
      <div class="div1">
        <select name="sort" onchange="location=this.value">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="div2"><?php echo $text_sort; ?></div>
    </div>
	<div id="product">
    <ul>
      <?php for ($j = 0; $j < sizeof($products); $j++) { ?>
		<li>
        <a href="<?php echo $products[$j]['href']; ?>">
		  <img align="left" src="<?php echo $products[$j]['thumb']; ?>"  alt="<?php echo $products[$j]['name']; ?>" />
          <span class="pname"><?php echo $products[$j]['name']; ?></span><br />
          <?php if ($display_price) { ?>
		  <span class="pprice">
			  <?php if (!$products[$j]['special']) { ?>
			  <span style="color: #F00; font-weight: bold;"><?php echo $products[$j]['price']; ?></span><br />
			  <?php } else { ?>
			  <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span><br /> <span style="color: #F00;"><?php echo $products[$j]['special']; ?></span><br />
			  <?php } ?>
		  </span>
          <?php } ?>
		  <span class="pkhuyenmai"><?php echo $products[$j]['khuyenmai']; ?></span>
		</a>
		</li>
      <?php } ?>
    </ul>
	</div>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>

<?php echo $footer; ?> 
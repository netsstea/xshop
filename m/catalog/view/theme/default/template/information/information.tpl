<?php echo $header; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle cm_info">
	<?php if($dichvu_yes) { ?>
    <select onchange="location=this.value" class="mct_select" onchange="ChangeOrder(this);">
      <?php foreach ($dichvus as $dichvu) { ?>
      <?php if ($dichvu['information_id'] == $information_id) { ?>
      <option value="<?php echo $dichvu['href']; ?>" selected="selected"><?php echo $dichvu['title']; ?></option>
      <?php } else { ?>
      <option value="<?php echo $dichvu['href']; ?>"><?php echo $dichvu['title']; ?></option>
      <?php } ?>
      <?php } ?>
    </select>
	<?php } ?>
<?php if(strpos($description,"bangtinhtragop")) { ?>
<script>
	jQuery().ready(function(){
	
	function FormatNumber(strvalue) {
	var num;
	    num = strvalue.toString().replace(/\$|\,/g,'');
	 
	    if(isNaN(num))
	    num = "";
	    sign = (num == (num = Math.abs(num)));
	    num = Math.floor(num*100+0.50000000001);
	    num = Math.floor(num/100).toString();
	    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	    num = num.substring(0,num.length-(4*i+3))+','+
	    num.substring(num.length-(4*i+3));
	    return (((sign)?'':'-') + num);
}

		months = new Array(0.3, 0.4, 0.5, 0.6, 0.7);
		
		month = 6;
		repaid = 0;
		paid = 15000000;
		percent = 0.026;
		
		jQuery('#month').change(function(){
			month = parseInt(jQuery(this).val());	
		});
		
		jQuery('#repaid').change(function(){
			repaid = parseInt(jQuery(this).val());	
		});
		
		jQuery('#paid').change(function(){
			paid = parseInt(jQuery(this).val());
		});
		jQuery('#cal').click(function(){
			switch(month)
			{
				case 6:
					jQuery('#sub').css('display','block');				
					jQuery('#spaid').html(FormatNumber(paid*(repaid*10+30)/100));
					jQuery('#spaidmonthly').html(FormatNumber(((6*percent+1)*(1-months[repaid])*jQuery('#paid').val())/6));
				break;
				case 9:
					jQuery('#sub').css('display','block');				
					jQuery('#spaid').html(FormatNumber(paid*(repaid*10+30)/100));
					jQuery('#spaidmonthly').html(FormatNumber(((9*percent+1)*(1-months[repaid])*jQuery('#paid').val())/9));
				break;
				case 12:
					jQuery('#sub').css('display','block');				
					jQuery('#spaid').html(FormatNumber(paid*(repaid*10+30)/100));
					jQuery('#spaidmonthly').html(FormatNumber(((12*percent+1)*(1-months[repaid])*jQuery('#paid').val())/12));
				break;
			}
		});		
		jQuery('#cal').click();		
	});
</script>
<?php
$tragop ='
<div class="info_tragop">
	<p><strong class="red">Dành cho đối tượng khách hàng KHÔNG CHỨNG MINH THU NHẬP</strong></p>
<div style="border: 1px solid #ddd;position: relative; width: 100%;">
	<div class="row"><span class="label" style="width: 154px">Tổng giá trị sản phẩm:</span><input type="text" width="200" value="15000000" name="paid" id="paid">&nbsp;VNĐ</div>
	<div class="row"><span class="label">% thanh toán trước:</span>
		<select id="repaid" name="repaid">
			<option value="0">30%</option>
			<option value="1">40%</option>
			<option value="2">50%</option>
			<option value="3">60%</option>						
			<option value="4">70%</option>
		</select>
	</div>
	<div class="row"><span class="label">Thời gian vay:</span>
		<select id="month" name="month">
			<option value="6">6 tháng</option>
			<option value="9">9 tháng</option>
			<option value="12">12 tháng</option>		
		</select>
	</div>
<input type="button" name="cal" id="cal" value="Tính" />
</div>
<br/>

<p>Số tiền thanh toán trước: <span id="spaid" class="red">4,500,000</span> VND</p>
<p>Số tiền cần thanh toán hàng tháng: <span id="spaidmonthly" class="red">2,124,000</span> VND</p>
<p><b>Lưu ý</b>: <span class="red">Tý giá có thể thay đổi trong ngày</span></p>

</div>';
?>
<?php echo str_replace("bangtinhtragop",$tragop,$description); ?>
<?php } else { ?>
	<?php echo $description; ?>
<?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
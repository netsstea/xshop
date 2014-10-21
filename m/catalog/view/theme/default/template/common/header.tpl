<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1,initial-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title id="title"><?php echo $title; ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php } ?>
<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="image/<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" media="all" />
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">
<div class="contain">
<div id="header"<?php if($home_select) { echo ' class="homepage"'; } elseif($product_select) { echo ' class="homepage"'; } ?>>
  <div class="headtop">
	<div class="div1">
		<div class="logo">
			<a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store; ?>" /></a>
		</div>
		<div class="menu">
		  <a class="mhome" href="<?php echo $home; ?>"></a>
		  <a class="msearch"></a>
		  <a class="mcategory"></a>
		</div>
	</div>
	<div class="search">
	  <span class="ms_arrow"></span>
	  <div class="sinput">
		<a onclick="moduleSearch();" class="button_search"></a>
		<div class="input">
		<?php if ($keyword) { ?>
		<input type="text" value="<?php echo $keyword; ?>" id="filter_keyword" />
		<?php } else { ?>
		<input type="text" value="<?php echo $text_keyword; ?>" id="filter_keyword" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
		<?php } ?>
		</div>
	  </div>
	</div>
  </div>
<?php if ($categories) { ?>
	<div class="cat_menu" id="category">
	  <span class="ms_arrow"></span>
	  <ul>
		<?php $i = 0; ?>
		<?php foreach ($categories as $category) { ?>
			<?php $i++; ?>
			<li class="cattop<?php if($i == 1) { echo ' cm_top'; } ?>">
				<a class="catatop" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
				<ul class="children">
					<?php foreach ($category['children'] as $children) { ?>
						<li class="catchild"><a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
		<?php } ?>
			<li class="cattop">
				<a class="catatop">Dịch vụ</a>
				<ul class="children">
					<?php foreach ($dichvus as $dichvu) { ?>
						<?php if($dichvu['lienketnhanh']) { ?>
							<li><a href="<?php echo $dichvu['lienketnhanh']; ?>"><?php echo $dichvu['title']; ?></a></li>
						<?php } else { ?>
							<li><a href="<?php echo $dichvu['href']; ?>"><?php echo $dichvu['title']; ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</li>
			<li class="cattop">
				<a class="catatop" href="<?php echo $tintuc; ?>">Tin tức</a>
				<ul class="children">
					<?php foreach ($cnews as $cnew) { ?>
						<li class="catchild"><a href="<?php echo $cnew['href']; ?>"><?php echo $cnew['name']; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<li class="catclose"><span class="closecat">Đóng lại</span></li>
	  </ul>
	</div>
<?php } ?>
</div>
<script language="javascript"> 
$('.menu .msearch').click(function(event) {
	$('.cat_menu').removeClass('active');
	if ($('.headtop').hasClass('active')) {
		$('.headtop').removeClass('active');
	} else {
		$('.headtop').addClass('active');
	}
	return false;
});
$('.headtop').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$('.headtop').removeClass('active');
});

$('.menu .mcategory').click(function(event) {
	$('.headtop').removeClass('active');
	if ($('.cat_menu').hasClass('active')) {
		$('.cat_menu').removeClass('active');
	} else {
		$('.cat_menu').addClass('active');
	}
	if ($('#container').hasClass('active')) {
		$('#container').removeClass('active');
		$('#container').removeAttr( 'style' );
	} else {
		$('#container').addClass('active');
		$('#container.active').css("min-height",$('.cat_menu').height() + 70);
	}
	return false;
});
$('.cat_menu').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$('.cat_menu').removeClass('active');
	$('#container').removeClass('active');
	$('#container').removeAttr( 'style' );
});
$('.catclose').click(function() {
	$('.cat_menu').removeClass('active');
	$('#container').removeClass('active');
	$('#container').removeAttr( 'style' );
});
</script>
<script type="text/javascript"><!--
$('.search input').keydown(function(e) {
	if (e.keyCode == 13) {
		moduleSearch();
	}
});
function moduleSearch() {
	pathArray = location.pathname.split( '/' );

	url = 'search/';
		
	var filter_keyword = $('#filter_keyword').attr('value')

	if (filter_keyword) {
		url += 'keyword/' + encodeURIComponent(filter_keyword).replace(/%20/gi, "-") + '/';
	}
	
	location = url;
}
//--></script>
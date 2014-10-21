<!DOCTYPE html>
<?php 
if($news_select == 1) {
	$schema = "http://schema.org/Article";
} else {
	$schema = "http://schema.org/Product";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>" xmlns:fb="http://www.facebook.com/2008/fbml" itemscope itemtype="<?php echo $schema; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="INDEX,FOLLOW" name="robots" />
<meta name="copyright" content="<?php echo str_replace('http://','',$base); ?>" />
<meta name="author" content="<?php echo str_replace('http://','',$base); ?>" />
<meta http-equiv="audience" content="General" />
<meta name="resource-type" content="Document" />
<meta name="distribution" content="Global" />
<meta name="revisit-after" content="1 days" />
<meta name="GENERATOR" content="<?php echo str_replace('http://','',$base); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php if ($image) { ?>
<meta property="og:image" content="<?php echo $image; ?>" />
<link rel="image_src" href="<?php echo $image; ?>" />
<?php $link_image = $image; ?>
<?php } else { ?>
<meta property="og:image" content="<?php echo $logo; ?>" />
<link rel="image_src" href="<?php echo $base . 'image/logo.png'; ?>" />
<?php $link_image = $base . 'image/logo.png'; ?>
<?php } ?>
<meta property="og:title" content="<?php echo $title; ?>" />
<?php if ($description) { ?>
<meta property="og:description" content="<?php echo $description; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $base; ?>" />
<meta property="og:url" content="<?php echo $url_share; ?>" />

<?php if ($description) { ?>
<meta itemprop="description" content="<?php echo $description; ?>" />
<?php } ?>
<link itemprop="url" href="<?php echo $url_share; ?>" />
<link itemprop="image" href="<?php echo $link_image; ?>" />

<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/header.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/sidebar.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/menu.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/content.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/footer.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/cart.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/showroom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/newsletter.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script src="catalog/view/javascript/jquery.bxSlider.js" type="text/javascript"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/tab.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.hoverIntent.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.menu-aim.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/bootstrap.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.blockUI.js"></script>
<?php if(!$home_select) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/sort.css" />
<?php } ?>
<?php if($news_select) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/news.css" />
<?php } ?>
<?php if($product_select) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/listpro.css" />
<?php } ?>
<?php if($product_product_select) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/product.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/animate.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/jquery.onebyone.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/onebyone/jquery.onebyone.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/onebyone/jquery.touchwipe.js"></script>
<?php } ?>
<?php if($category_select) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/category.css" />
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&amp;subset=latin,vietnamese' rel='stylesheet' type='text/css'>
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/unitpngfix/unitpngfix.js"></script>
<![endif]-->
<?php foreach ($styles as $style) { ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/<?php echo $style; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="view/javascript/jquery/<?php echo $script; ?>"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">
<?php if($bannerlefts && $bannerrights) { ?>
<div class="hbanner">
<div class="bannerhead">
	<div class="bhleft">
	  <?php if(sizeof($bannerlefts) > 1) { ?>
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#bhleft').bxSlider({
				speed: 1500,
				pause: 5000,
				mode: 'fade',
				controls: false,
				autoStart: true
				});
			  });
		</script>
	  <?php } ?>
		<ul id="bhleft">
			<?php foreach ($bannerlefts as $bannerleft) { ?>
			  <li>
				<?php if($bannerleft['link']) { ?>
					<a href="<?php echo $bannerleft['link']; ?>"><img src='<?php echo $bannerleft['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bannerleft['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
	<div class="bhright">
	  <?php if(sizeof($bannerrights) > 1) { ?>
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#bhright').bxSlider({
				speed: 1500,
				mode: 'fade',
				pause: 5000,
				controls: false,
				autoStart: true
				});
			  });
		</script>
	  <?php } ?>
		<ul id="bhright">
			<?php foreach ($bannerrights as $bannerright) { ?>
			  <li>
				<?php if($bannerright['link']) { ?>
					<a href="<?php echo $bannerright['link']; ?>"><img src='<?php echo $bannerright['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bannerright['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
</div>
</div>
<?php } ?>
<div id="taskbar">
  <div class="taskbar">
	<div class="left"><!-- <?php echo $header; ?> -->
		<a class="tba" href="http://sim.techone.vn/" target="_blank">Sim số đẹp</a>
		<a class="tba" href="http://goldenone.vn/" target="_blank">Golden One</a>
	</div>
	<div class="right">
		<div id="showuser"></div>
		<?php if ($zones) { ?>
		<div class="zone">
		<span>Bạn đang xem tại</span>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="zone_form">
          <div class="switcher">
            <?php foreach ($zones as $zone) { ?>
            <?php if ($zone['code'] == $zone_code) { ?>
            <div class="selected"><a><?php echo $zone['name']; ?></a></div>
            <?php } ?>
            <?php } ?>
            <div class="option">
              <?php foreach ($zones as $zone) { ?>
              <a onclick="$('input[name=\'zone_code\']').attr('value', '<?php echo $zone['code']; ?>'); $('#zone_form').submit();"><?php echo $zone['name']; ?></a>
              <?php } ?>
			  <div>Chọn địa điểm sẽ giúp bạn có thông tin chính xác nhất về giá và tình trạng hàng tại khu vực đó.</div>
            </div>
          </div>
          <input type="hidden" name="zone_code" value="" />
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        </form>
		</div>
<script language="javascript"> 
$('.switcher').click(function(event) {
	if ($('.switcher').hasClass('active')) {
		$('.switcher').removeClass('active');
	} else {
		$('.switcher').addClass('active');
	}
	return false;
});
$('.switcher .option').click(function(event) {
	event.stopPropagation();
});
$(document).click(function() {
	$(".switcher").removeClass("active");
});
</script>
		<?php } ?>
	</div>
  </div>
</div>
<div id="wrapper">
<div id="header">
<div class="header">
  <div class="div1">
	<div class="logo">
	<a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
	</div>
  </div>
  <div class="div0">
	<div class="div2">
		<div class="search">
			<?php if ($keyword) { ?>
			<input type="text" value="<?php echo $keyword; ?>" id="filter_keyword" />
			<?php } else { ?>
			<input type="text" value="" placeholder="<?php echo $text_keyword; ?>" id="filter_keyword" onclick="this.value = '';" onkeydown="this.style.color = '000000'" />
			<?php } ?>
			<a onclick="moduleSearch();" class="button_search"></a>
		</div>
	</div>
	<div class="info_header">
		<?php if($support_status) { ?>
		  <div class="tbsupport">
			<a class="tba">
				Hỗ trợ online
			</a>
			<div class="tbarrow"></div>
			<div id="tsupport"></div>
			<script language="javascript">
			$('.tbsupport').mouseenter(function() {
				$('#tsupport').load('index.php?route=module/support');
			});
			</script>
		  </div>
		<?php } ?>
		
		<div class="tbshowroom">
			<a id="hshowroom" onclick="<?php echo $showroom; ?>" class="tba">
				Hệ thống Showroom
			</a>
		</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#hshowroom').colorbox({
		initialHeight: "540",
		initialWidth: "968",
		overlayClose: false,
		escKey: false,
		fixed: true,
		opacity: 0.5
	});
});
//--></script>
	</div>
  </div>
  <div style="clear:both;"></div>
</div>
<div id="menu">
  <div class="menu">
  <div class="menuleft">
	<div class="mnhome"><a class="mahome" href="<?php echo $base; ?>" ></a></div>
	<div class="dropdown-toggle" data-toggle="dropdown"><span>Danh mục sản phẩm</span></div>
	<ul class="dropdown-menu<?php if($home_select) { echo " homecat"; } ?>" role="menu">
		<?php $i = 0; ?>
		
		<?php if($manufacturer_datas)  { ?>
			<?php foreach ($manufacturer_datas as $manufacturer_data) { ?>
				<?php $i++; ?>
				
				<li data-submenu-id="top<?php echo $i; ?>" class="litop<?php if($i == 1) { echo ' lttop'; } ?>" id="litop<?php echo $i; ?>">
					<a class="atop" href="<?php echo $manufacturer_data['href']; ?>"><span class="lsicon"><img class="lsimage" src="<?php echo $manufacturer_data['image']; ?>" /></span> <?php echo $manufacturer_data['name']; ?></a>
					
					<div id="top<?php echo $i; ?>" class="popover" style="display:none;">
						<?php if($manufacturer_data['banner']){ ?><img class="ld_image" src="<?php echo $manufacturer_data['banner']; ?>" /><?php } ?>
						<div class="col_1">
						<ul class="simple">
						<?php foreach ($manufacturer_data['category_manufacturer'] as $category_manufacturer) { ?>
							<li class="lisimple"><a class="asimple" href="<?php echo $category_manufacturer['href']; ?>"><?php echo $category_manufacturer['name']; ?></a>
								<?php if($category_manufacturer['category_manufacturer_children']) { ?>
								<ul class="children<?php if(sizeof($category_manufacturer['category_manufacturer_children']) > 10) { echo ' crollmenu'; } ?>">
									<?php foreach ($category_manufacturer['category_manufacturer_children'] as $category_manufacturer_children) { ?>
										<li class="lichildren"><a href="<?php echo $category_manufacturer_children['href']; ?>"><?php echo $category_manufacturer_children['name']; ?></a></li>
									<?php } ?>
								</ul>
								<?php } ?>
							</li>
						<?php } ?>
						</ul>
						</div>
					</div>
				</li>
			<?php } ?>
		<?php } ?>
		
		<?php foreach ($categories as $category) { ?>
		<?php $i++; ?>
		<li data-submenu-id="top<?php echo $i; ?>" class="litop<?php if(!$manufacturer_datas && $i == 1) { echo ' lttop'; } elseif($i == (sizeof($categories) + sizeof($manufacturer_datas))) { echo ' ltbottom'; } ?>" id="litop<?php echo $i; ?>"><a class="atop" href="<?php echo $category['href']; ?>"><span class="lsicon"><img class="lsimage" src="<?php echo $category['icon_menu']; ?>" /></span> <?php echo $category['name']; ?></a>
		  <div id="top<?php echo $i; ?>" class="popover" style="display:none;">
			<?php if($category['image']){ ?><img class="ld_image" src="<?php echo $category['image']; ?>" /><?php } ?>
			<div class="col_1">
			<ul class="simple">	
			
			<?php $nochilds = array(); ?>
			
			<?php foreach ($category['children'] as $children) { ?>
				<?php if(!$children['children'] && !$children['manufacturers']){ ?>
					<?php
						$nochilds[] = array(
							'href'        	  => $children['href'],
							'name'        	  => $children['name']
						);
					?>
				<?php } ?>
			<?php } ?>
			
			<?php if($nochilds){ ?>
				<li class="lisimple"><a class="asimple" href="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
					<ul class="children<?php if(sizeof($nochilds) > 11) { echo ' crollmenu'; } ?>">
						<?php $ic = 0; ?>
						<?php foreach ($nochilds as $nochild) { ?>
							<?php $ic++; ?>
							<li class="lichildren<?php echo ' lcd' . $ic%2; ?>"><a href="<?php echo $nochild['href']; ?>"><?php echo $nochild['name']; ?></a></li>
						<?php } ?>
					</ul>	
				</li>
			<?php } ?>
			
			<?php foreach ($category['children'] as $children) { ?>
				<?php if($children['children'] && !$children['manufacturers']){ ?>
					<li class="lisimple"><a class="asimple" href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
						<ul class="children<?php if(sizeof($children['children']) > 11) { echo ' crollmenu'; } ?>">
							<?php $ic = 0; ?>
							<?php foreach ($children['children'] as $child) { ?>
								<?php $ic++; ?>
								<li class="lichildren<?php echo ' lcd' . $ic%2; ?>"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
							<?php } ?>
						</ul>	
					</li>
				<?php } elseif($children['manufacturers']) { ?>
					<li class="lisimple"><a class="asimple" href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
						<ul class="children<?php if(sizeof($children['manufacturers']) > 11) { echo ' crollmenu'; } ?>">
							<?php $ic = 0; ?>
							<?php foreach ($children['manufacturers'] as $manufacturers) { ?>
								<?php $ic++; ?>
								<li class="lichildren<?php echo ' lcd' . $ic%2; ?>"><a href="<?php echo $manufacturers['href']; ?>"><?php echo $manufacturers['name']; ?></a></li>
							<?php } ?>
						</ul>	
					</li>
				<?php } ?>
			<?php } ?>
			
			<?php if($category['manufacturers']){ ?>
				<li class="lisimple"><a class="asimple cnolink">Thương hiệu</a>
					<ul class="children<?php if(sizeof($category['manufacturers']) > 11) { echo ' crollmenu'; } ?>">
						<?php $ic = 0; ?>
						<?php foreach ($category['manufacturers'] as $manufacturers) { ?>
							<?php $ic++; ?>
							<li class="lichildren<?php echo ' lcd' . $ic%2; ?>"><a href="<?php echo $manufacturers['href']; ?>"><?php echo $manufacturers['name']; ?></a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			
			<?php if($category['phanloais']){ ?>
				<?php foreach ($category['phanloais'] as $phanloai) { ?>
					<li class="lisimple"><a class="asimple cnolink"><?php echo $phanloai['name']; ?></a>
						<ul class="children">
							<?php foreach ($phanloai['boloc'] as $boloc) { ?>
								<li class="lichildren"><a href="<?php echo $boloc['href']; ?>"><?php echo $boloc['name']; ?></a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
			<?php } ?>
			</ul>
			</div>
		  </div>
		</li>
		<?php } ?>
	</ul>
  </div>
  <div class="menuright"><ul class="mrul">
	<li class="mrli"><a class="mratop" href="<?php echo $special; ?>">Hot Deals</a></li>
	<li class="mrli"><a class="mratop" href="product/khuyenmai/" target="_blank">Khuyến mãi</a></li>
	<li class="mrli"><a class="mratop" href="info/68/huong-dan-mua-tra-gop.html">Bán trả góp</a></li>
	<li class="mrli"><a class="mratop<?php if($daotaos) {echo ' mdrop';} ?>">Đào tạo</a>
	<?php if($daotaos) { ?>
	  <div class="dropdown_1column">
		<div class="mcol">
			<div class="colr">
			<ul class="showmr">
			  <?php for ($j = 0; $j < sizeof($daotaos); $j++) { ?><li>
				<?php if($daotaos[$j]['link']) { ?>
					<a href="<?php echo $daotaos[$j]['link']; ?>"><?php echo $daotaos[$j]['name']; ?></a>
				<?php } else { ?>
					<a href="<?php echo $daotaos[$j]['href']; ?>"><?php echo $daotaos[$j]['name']; ?></a>
				<?php } ?>
			  </li><?php } ?>
			</ul>
			</div>
		</div>
	  </div>
	<?php } ?>
	</li>
	<li class="mrli"><a class="mratop<?php if($dichvus) {echo ' mdrop';} ?>">Dịch vụ</a>
	<?php if($dichvus) { ?>
	  <div class="dropdown_1column">
		<div class="mcol">
			<div class="colr">
			<ul class="showmr">
			  <?php for ($j = 0; $j < sizeof($dichvus); $j++) { ?><li>
				<?php if($dichvus[$j]['link']) { ?>
					<a href="<?php echo $dichvus[$j]['link']; ?>"><?php echo $dichvus[$j]['name']; ?></a>
				<?php } else { ?>
					<a href="<?php echo $dichvus[$j]['href']; ?>"><?php echo $dichvus[$j]['name']; ?></a>
				<?php } ?>
			  </li><?php } ?>
			</ul>
			</div>
		</div>
	  </div>
	<?php } ?>
	</li>
	<li class="mrli"><a class="mratop" href="news/">Tin tức</a></li>
  </ul></div>
  </div>
<script language="javascript"> 
        var $menu = $(".dropdown-menu");
        $menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu,
			exitMenu: exitMenus
        });

        function activateSubmenu(row) {
            var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId),
                height = $menu.outerHeight(),
                width = $menu.outerWidth();

            $submenu.css({
                display: "block"
            });

            $("#li" + submenuId + " a.atop").addClass("hover");
        }

        function deactivateSubmenu(row) {
            var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId);

            $submenu.css("display", "none");
            $("#li" + submenuId + " a.atop").removeClass("hover");
        }
		
        $('.dropdown-menu').mouseenter(function() {
            $('.dropdown-menu').addClass("active");
        });
		function exitMenus() {
		
        $('.menuleft').mouseleave(function() {
            $('.popover').css("display", "none");
            $(".dropdown-menu a.atop").removeClass("hover");
			$('.dropdown-menu').removeClass("active");
        });
		return true;
		}
</script>
</div>
</div>
<?php if($breadcrumbs) { ?>
<div id="breadcrumb">
	<?php $config_keyword = 'Trang chủ'; ?>
	<ul itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<?php $i = 0; ?>
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php $i++; ?>
			
			<?php if(sizeof($breadcrumbs) == $i) { ?>
			<li <?php if($breadcrumb['separator']) { echo 'class="bc_next"'; } else { echo 'class="bc_home"';} ?>>
				<?php echo $breadcrumb['separator']; ?>
				<span class="bc_title"><?php if($breadcrumb['separator']) { echo $breadcrumb['text']; } ?></span>	
			</li>
			<?php } else { ?>
			<li <?php if($breadcrumb['separator']) { echo 'class="bc_next"'; } else { echo 'class="bc_home"';} ?> itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<?php echo $breadcrumb['separator']; ?>
				<a href="<?php echo $breadcrumb['href']; ?>" itemprop="url">
					<span itemprop="title"><?php if($breadcrumb['separator']) { echo $breadcrumb['text']; } elseif($config_keyword) { echo $config_keyword; } ?></span>
				</a>
			</li>
			<?php } ?>
		
		<?php } ?>
	</ul>
</div>
<?php } ?>
<script language="javascript">
$('#showuser').load('index.php?route=common/header/account');
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
		
	var filter_keyword = $.trim($('#filter_keyword').attr('value'))

	if (filter_keyword) {
		url += 'keyword/' + encodeURIComponent(filter_keyword).replace(/%20/gi, "+").toLowerCase() + '/';
	}
	
	location = url;
}
//--></script>

<?php if($bottomlefthomes && $bottomrighthomes && !$home_select) { ?>
<div class="slidebottom">
	<div class="slideleft">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#slideleft').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="slideleft">
			<?php foreach ($bottomlefthomes as $bottomlefthome) { ?>
			  <li>
				<?php if($bottomlefthome['link']) { ?>
					<a href="<?php echo $bottomlefthome['link']; ?>"><img src='<?php echo $bottomlefthome['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bottomlefthome['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
	<div class="slideright">
		<script type="text/javascript">
			  $(document).ready(function(){
				$('#slideright').bxSlider({
				speed: 1000,
				pause: 4000,
				mode: 'horizontal',
				controls: false,
				autoStart: true
				});
			  });
		</script>
		<ul id="slideright">
			<?php foreach ($bottomrighthomes as $bottomrighthome) { ?>
			  <li>
				<?php if($bottomrighthome['link']) { ?>
					<a href="<?php echo $bottomrighthome['link']; ?>"><img src='<?php echo $bottomrighthome['image']; ?>' /></a>
				<?php } else { ?>
					<img src='<?php echo $bottomrighthome['image']; ?>' />
				<?php } ?>
			  </li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
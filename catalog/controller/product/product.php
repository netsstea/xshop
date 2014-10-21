<?php  
class ControllerProductProduct extends Controller {
	private $error = array(); 
	
	public function index() { 
		$this->language->load('product/product');
		$this->load->model('tool/seo_url'); 
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->helper('image');
		
		$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
    	
		if ($product_info) {
			if($this->zone->getCode() == 'HI') {
				$codeZone = '';
			} else {
				$codeZone = '_' . strtolower($this->zone->getCode());
			}
			
			$url_seo = $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $product_id));
			if($this->config->get('config_seo_url')) {
				if(isset($this->request->get['_route_'])){
					if ($url_seo != (HTTP_SERVER . $this->request->get['_route_'])){
						$this->redirect($url_seo);
					}
				} else {
					$this->redirect($url_seo);
				}
			}
			
			$this->data['product_href'] = $url_seo;
			
			if($product_info['category_id']) {
				$category_id = $product_info['category_id'];
			} else {
				$category_id = $this->model_catalog_product->getCategoryIdByProductId($this->request->get['product_id']);
			}
			
			$cat_start = 0;
			
			$category = $this->model_catalog_category->getCategory($category_id);
			if($category) {
				$path = $category_id;
				while ($category['parent_id'] != 0) {
					$path = $category['parent_id'] . '_' . $path;
					$category = $this->model_catalog_category->getCategory($category['parent_id']);
				}
				$this->document->path =  $path;
				$parts = explode('_', $path);
				
				$cat_start = $parts[0];
				
				$category_data = $this->model_catalog_category->getCategory($parts[0]);
				if($category_data) {
					$this->document->breadcrumbs[] = array(
						'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $parts[0])),
						'text'      => $category_data['name'],
						'separator' => $this->language->get('text_separator')
					);
				}
			}
			
			if ($product_info['manufacturer_id'] && $this->model_catalog_category->getTotalCategoryManufacturer($cat_start, $product_info['manufacturer_id'])) {
				$manufacturer_id = $product_info['manufacturer_id'];
				$url_manu = "&manufacturer_id=" . $product_info['manufacturer_id'];
				
				$this->load->model('catalog/manufacturer'); 

				if ($cat_start) {
					$ex_name = $this->model_catalog_category->getManufacturerIdAndCategoryId($cat_start, $product_info['manufacturer_id']);
						
					if($ex_name && $ex_name['name']) {
						$manu_name = $ex_name['name'];
					} else {
						$manu_name = $product_info['manufacturer'];
					}
				} else {
					$manu_name = '';
				}
				
				$this->document->breadcrumbs[] = array(
					'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $cat_start . $url_manu)),
					'text'      => $manu_name,
					'separator' => $this->language->get('text_separator')
				);
			}
			
			foreach ($parts as $part) {
				if($part != $parts[0]) {
					$category = $this->model_catalog_category->getCategory($part);
					
					$this->document->breadcrumbs[] = array(
						'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $part)),
						'text'      => $category['name'],
						'separator' => $this->language->get('text_separator')
					);
				}
			}
									
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $this->request->get['product_id'])),
        		'text'      => $product_info['name'],
        		'separator' => $this->language->get('text_separator')
      		);			
			
			$this->document->title = $product_info['name'];
			
			$this->document->description = $product_info['meta_description'];
			
			$this->data['heading_title'] = $product_info['name'];
			
			$this->data['text_enlarge'] = $this->language->get('text_enlarge');
      		$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_options'] = $this->language->get('text_options');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_availability'] = $this->language->get('text_availability');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_order_quantity'] = $this->language->get('text_order_quantity');
			$this->data['text_price_per_item'] = $this->language->get('text_price_per_item');
			$this->data['text_qty'] = $this->language->get('text_qty');
			$this->data['text_write'] = $this->language->get('text_write');
			$this->data['text_average'] = $this->language->get('text_average');
			$this->data['text_no_rating'] = $this->language->get('text_no_rating');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_no_images'] = $this->language->get('text_no_images');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_no_related'] = $this->language->get('text_no_related');
			$this->data['text_xemtatca'] = $this->language->get('text_xemtatca');
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_review'] = $this->language->get('entry_review');
			$this->data['entry_rating'] = $this->language->get('entry_rating');
			$this->data['entry_good'] = $this->language->get('entry_good');
			$this->data['entry_bad'] = $this->language->get('entry_bad');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
			
			$this->data['hotline'] = $this->config->get('config_hotline');

			$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->load->model('catalog/review');

			$this->data['tab_description'] = $this->language->get('tab_description');
			$this->data['tab_technical_description'] = $this->language->get('tab_kythuat');
			$this->data['tab_image'] = $this->language->get('tab_image');
			$this->data['tab_review'] = sprintf($this->language->get('tab_review'), $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']));
			$this->data['review'] = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			$this->data['tab_related'] = $this->language->get('tab_related');
			
			$average = $this->model_catalog_review->getAverageRating($this->request->get['product_id']);	
			
			$this->data['text_stars'] = sprintf($this->language->get('text_stars'), $average);
			
			$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

			$this->data['action'] = $this->url->http('checkout/cart');
			
			$this->data['redirect'] = $this->url->http('product/product&product_id=' . $this->request->get['product_id']);
			
			if($this->zone->getCode() == 'HI') {
				$pprice = $product_info['price'];
			} else {
				$pprice = $product_info['price_' . strtolower($this->zone->getCode())];
			}

			$discount = $this->model_catalog_product->getProductDiscount($this->request->get['product_id']);
			
			if ($discount) {
				$this->data['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
				
				$this->data['special_price'] = FALSE;
			} else {
				$this->data['price'] = $this->currency->format($this->tax->calculate($pprice, $product_info['tax_class_id'], $this->config->get('config_tax')));
			
				$special = $this->model_catalog_product->getProductSpecial($this->request->get['product_id']);
			
				if ($special) {
					$this->data['special_price'] = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$this->data['special_price'] = FALSE;
				}
			}
			
			if($pprice == 0) {$this->data['price'] = $this->language->get('price_contact');}
			$this->load->model('total/tax');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$tax = $this->model_total_tax->getTax($product_info['tax_class_id']);
			if($product_info['tax_class_id']) {
				foreach ($tax as $taxs) {
				$this->data['tax'] = $taxs['description'];
				}
			} else {
				$this->data['tax'] = $this->language->get('no_tax');
			}
			
			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
			
			$this->data['discounts'] = array(); 
			
			foreach ($discounts as $discount) {
				$this->data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}
			
			if ($product_info['quantity'] <= 0) {
				$this->data['stock'] = $this->language->get('text_instock');
			} else {
				if ($this->config->get('config_stock_display')) {
					$this->data['stock'] = $product_info['quantity'];
				} else {
					$this->data['stock'] = $product_info['stock'];
				}
			}
			
// information
			$this->load->model('catalog/information');
			$this->load->model('catalog/cinformation');
			$this->data['informations'] = array();
			foreach ($this->model_catalog_cinformation->getcinformations('product',1) as $cinformation_info) {
				foreach ($this->model_catalog_information->getinformationbycinformation($cinformation_info['cinformation_id'],3) as $result) {
					$this->data['informations'][] = array(
						'name' 	   				=> $result['name'],
						'link' 					=> $result['link'],
						'href' 	 	   			=> $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
					);
				}
			}
//end information

// zone
		$this->data['zone_code'] = $this->zone->getCode();
		
		$this->load->model('localisation/zone');
		$this->data['zones'] = array();
		
		$results = $this->model_localisation_zone->getZoneByShowroom();
		
		foreach ($results as $result) {
			$this->data['zones'][] = array(
				'name'  => $result['name'],
				'code'  => $result['code'],
				'zone_id'  => $result['zone_id']
			);
		}
// end zone

			$total_promotion = '';
			
			if($this->zone->getCode() == 'HI') {
				if($product_info['total_promotion']) {
					$total_promotion = sprintf($this->language->get('text_promotion'), $this->currency->format($product_info['total_promotion']));
				}
			} else {
				if($product_info['total_promotion_' . strtolower($this->zone->getCode())]) {
					$total_promotion = sprintf($this->language->get('text_promotion'), $this->currency->format($product_info['total_promotion_' . strtolower($this->zone->getCode())]));
				}
			}
			
			$this->data['model'] = $product_info['model'];
			$this->data['warranty'] = $product_info['warranty'];
			$this->data['manufacturer'] = $product_info['manufacturer'];
			$this->data['manufacturers'] = $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $product_info['manufacturer_id']));
			$this->data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');			
			$this->data['technical_description'] = html_entity_decode($product_info['technical_description'], ENT_QUOTES, 'UTF-8');
			$this->data['total_promotion'] = $total_promotion;
			$this->data['promotion'] = html_entity_decode($product_info['promotion' . $codeZone], ENT_QUOTES, 'UTF-8');
			$this->data['brief_description'] = html_entity_decode($product_info['brief_description'], ENT_QUOTES, 'UTF-8');
      		$this->data['product_id'] = $this->request->get['product_id'];
			$this->data['average'] = $average;
			
			$tags = explode(',',html_entity_decode($product_info['tags'], ENT_QUOTES, 'UTF-8'));
			$this->data['tags'] = array();
			for ($i=0; $i<sizeof($tags); $i++) {
			$this->data['tags'][$i] = array(
				'keyword' => trim($tags[$i]),
				'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/search&keyword=' . $tags[$i]))
			);
			}
			
			$this->data['options'] = array();
			
			$options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
			
			foreach ($options as $option) { 
				$option_value_data = array();
				
				foreach ($option['option_value'] as $option_value) {
					$option_value_data[] = array(
            			'option_value_id' => $option_value['product_option_value_id'],
            			'name'            => $option_value['name'],
            			'price'           => (float)$option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : FALSE,
            			'prefix'          => $option_value['prefix']
          			);
				}
				
				$this->data['options'][] = array(
          			'option_id'    => $option['product_option_id'],
          			'name'         => $option['name'],
          			'option_value' => $option_value_data
				);
			}
			
			if (isset($this->request->post['option'])) {
				$option = $this->request->post['option'];
			} else {
				$option = array();
			}
			
			$this->data['checkout'] = $this->model_tool_seo_url->rewrite($this->url->http('checkout/cart/order')) . '&options=ordercontinue';
			
			unset($this->session->data['cart']);
					
			$this->cart->add($this->request->get['product_id'], 1, $option);
			
			if ($product_info['image']) {
				$image = $product_info['image'];
				$this->document->image = image_resize($product_info['image'], 300, 300);
			} else {
				$image = 'no_image.jpg';
			}
			
	  		$this->data['thumb'] = image_resize($image, 700, 390);
			
			$this->data['iconImg'] = image_resize($image, 86, 51);
			
			$this->data['slideshows'] = array();
			
			$SlideImage = $this->model_catalog_product->getProductImagesToSlide($this->request->get['product_id']);
			if(!$SlideImage) {
				$SlideImage = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			}
      		foreach ($SlideImage as $result) {
        		$this->data['slideshows'][] = array(
					'title_image' 		=> html_entity_decode($result['title_image'], ENT_QUOTES, 'UTF-8'),
					'description_image' => html_entity_decode($result['description_image'], ENT_QUOTES, 'UTF-8'),
					'image' 			=> image_resize($result['image'],700, 390)
        		);
      		}
			
			$this->data['images'] = array();
			
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

      		foreach ($results as $result) {
        		$this->data['images'][] = array(
          			'thumb' => image_resize($result['image'], 127, 70),
					'popup' => image_resize($result['image'],700, 390)
        		);
      		}
			
			$this->data['img300x300'] = image_resize($image, 300, 300);
			
			$this->data['img500x500'] = image_resize($image, 500, 500);
			
			$this->data['imgSP1'] = array();
			
			if($results) {
				$this->data['imgSP1'][] = array(
					'img500x500' => image_resize($image, 500, 500),
					'img300x300' => image_resize($image, 300, 300),
					'thumb' => image_resize($image, 56, 56)
				);

				foreach ($results as $result) {
					$this->data['imgSP1'][] = array(
						'img500x500' => image_resize($result['image'] , 500, 500),
						'img300x300' => image_resize($result['image'],300, 300),
						'thumb' => image_resize($result['image'], 56, 56)
					);
				}
			}
			
			$this->data['videos'] = array();
			
			$this->data['iconVid'] = 'image/no_image.jpg';
			
			$results = $this->model_catalog_product->getProductVideos($this->request->get['product_id']);
			
      		foreach ($results as $result) {
				
				$video_id = explode('v=', $result['video']);
				
				if(isset($video_id[1])) {
					$videoID = substr($video_id[1],0,11);
				}
				
				if(!$this->data['videos'] && isset($videoID)) {
				
					$this->data['iconVid'] = 'http://i1.ytimg.com/vi/' . $videoID . '/default.jpg';
				}
				
				if(isset($videoID)) {
					$this->data['videos'][] = array(
						'video_id' => $videoID,
						'iconVid' => 'http://i1.ytimg.com/vi/' . $videoID . '/default.jpg'
					);
				}
      		}
			
//san pham lien quan
			
			$this->data['products'] = array();
			
			$this->data['phukiens'] = array();


			$this->data['xemtatca'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_id));
			
			$resultsCategoryId = $this->model_catalog_product->getProductsRelatedByCategoryId($product_id, $category_id, $start = 0, $limit = $this->config->get('config_related'), $product_info['manufacturer_id']);
			
			$resultsRelated = $this->model_catalog_product->getProductsRelated($product_id);
			
			if($resultsRelated) {
				$Related = $resultsRelated;
			} else {
				$Related = $resultsCategoryId;
			}
			
			$resultsPhukien = $this->model_catalog_product->getProductPhukien($product_id);
			
			$productSB = array();
			
			$productSB[] = array('product' => $Related,'key' => 'products');
			$productSB[] = array('product' => $resultsPhukien,'key' => 'phukiens');
				
			foreach ($productSB as $results) {
				
				$data_products = array();
				
				foreach ($results['product'] as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					$special = FALSE;
					
					$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
				
					if ($discount) {
						$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
						
						$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
					
						if ($special) {
							$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
						}
					}
					
					if($result['price'] == 0) {$price = $this->language->get('price_contact');}

					$data_products[] = array(
						'name'    			=> $result['name'],
						'thumb'   			=> image_resize($image, 86, 86),
						'price'   			=> $price,
						'special' 			=> $special,
						'href'    			=> $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
					);
				}
				
				$this->data[$results['key']] = $data_products;
			}
			
			if($product_info['template']) {
				$this->data['products'] = array();
				$this->load->model('catalog/attribute');
				
				foreach ($Related as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					$special = FALSE;
					
					$phantram = FALSE;
					
					if($this->zone->getCode() == 'HI') {
						$pprice = $result['price'];
					} else {
						$pprice = $result['price_' . strtolower($this->zone->getCode())];
					}
					
					$total_promotion = '';
					
					if($this->zone->getCode() == 'HI') {
						if($result['total_promotion']) {
							$total_promotion = sprintf($this->language->get('text_promotion'), $this->currency->format($result['total_promotion']));
						}
					} else {
						if($result['total_promotion_' . strtolower($this->zone->getCode())]) {
							$total_promotion = sprintf($this->language->get('text_promotion'), $this->currency->format($result['total_promotion_' . strtolower($this->zone->getCode())]));
						}
					}
					
					$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
					
					if ($discount) {
						$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = $this->currency->format($this->tax->calculate($pprice, $result['tax_class_id'], $this->config->get('config_tax')));
					 
						if($pprice) {
							$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
						
							if ($special) {
								$phantram = floor((($special - $pprice)*100)/$pprice) . '%';
								$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
							}
						}
					}
					
					$attributes = array();
					
					$catIdStart = $this->model_catalog_product->getCatStart($result['product_id']);
					
					$attribute_data = $this->model_catalog_attribute->getAttributesByCategoryId($catIdStart,$result['product_id'],'thongsolistsp');
					
					if($pprice == 0) {$price = $this->language->get('price_contact');}
					$this->data['text_price'] = $this->language->get('text_price');
					$this->data['text_model'] = $this->language->get('text_model');
					$this->data['products'][] = array(
						'name'     			=> $result['name'],
						'product_id'    	=> $result['product_id'],
						'promotion'			=> $total_promotion,
						'thumb'    			=> image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
						'price'    			=> $price,
						'special'  			=> $special,
						'attribute_data'  	=> $attribute_data,
						'phantram'  		=> $phantram,
						'href'     			=> $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
					);
				}
			}
			
			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = TRUE;
			} elseif ($this->customer->isLogged() && ($this->customer->getCustomerGroupVip() || $this->customer->getCustomerGroupMod() || $this->customer->getCustomerGroupAdmin())) {
				$this->data['display_price'] = TRUE;
			} else {
				$this->data['display_price'] = FALSE;
			}
			
		if ($this->config->get('khuyenmaihotro_status')) {
			$this->data['khuyenmaihotro_code'] = html_entity_decode($this->config->get('khuyenmaihotro_code'), ENT_QUOTES, 'UTF-8');
			$this->data['khuyenmaihotro_title'] = html_entity_decode($this->config->get('khuyenmaihotro_title'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['khuyenmaihotro_code'] = '';
			$this->data['khuyenmaihotro_title'] = '';
		}
		
		if ($this->config->get('khuyenmaihotro_status')) {
			$this->data['camketmuahang_code'] = html_entity_decode($this->config->get('camketmuahang_code'), ENT_QUOTES, 'UTF-8');
			$this->data['camketmuahang_title'] = html_entity_decode($this->config->get('camketmuahang_title'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['camketmuahang_code'] = '';
			$this->data['camketmuahang_title'] = '';
		}
//thong so ky thuat
		
		$this->load->model('catalog/attribute');
		
		$this->data['attributes'] = $this->model_catalog_attribute->getAttributesByCategoryId($cat_start, $product_id, 'thongsorutgon');
		
		$this->data['attribute_groups'] = array();
		
		$attribute_groups = $this->model_catalog_attribute->getAttributeGroupsByCategoryId($cat_start);
		
		if($attribute_groups) {
			foreach ($attribute_groups as $attribute_group) {
				$attributes = array();
				
				$attribute_infos = $this->model_catalog_attribute->getAttributesByAttributeGroupId($attribute_group['attribute_group_id']);

				foreach ($attribute_infos as $attribute_info) {
					
					$product_attribute = $this->model_catalog_attribute->getProductAttributeId($this->request->get['product_id'],$attribute_info['attribute_id']);
					if($product_attribute && $product_attribute['text']) {
						$attribute_text = $product_attribute['text'];
					} else {
						$attribute_text = $attribute_info['text_default'];
					}
					
					$attributes[] = array(
						'name' 		   => $attribute_info['name'],
						'attribute_id' => $attribute_info['attribute_id'],
						'text' => $attribute_text
					);
				}
				
				$this->data['attribute_groups'][] = array(
					'name' 		 => $attribute_group['name'],
					'attribute_group_id' 		 => $attribute_group['attribute_group_id'],
					'attributes' => $attributes
				);
			}
		}
		
// user review 
			$this->load->model('account/customer');
			$this->data['logged'] = $this->customer->isLogged();
			if ($this->customer->isLogged()) {
				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
				if ($customer_info) {
					$this->data['customername'] = $customer_info['customername'];
				}
			} else {
				$this->data['customername'] = '';
			}

// end user review

			$this->model_catalog_product->updateViewed($this->request->get['product_id']);
			
			if($product_info['template']) {
				$template = $product_info['template'];
			} else {
				$template = 'product';
			}
						
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $template . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/' . $template . '.tpl';
			} else {
				$this->template = 'default/template/product/' . $template . '.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
			);		
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}			

			if (isset($this->request->get['keyword'])) {
				$url .= '&keyword=' . $this->request->get['keyword'];
			}			

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
				
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}		
					
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/product' . $url . '&product_id=' . $product_id)),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->title = $this->language->get('text_error');

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
	  
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
			);	
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}
  	}
	
	public function review() {
    	$this->language->load('product/product');
		$this->load->model('tool/time');
		$this->load->model('catalog/review');
		$this->load->model('account/customer');

		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$this->data['reviews'] = array();
			
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
			$customer_info = $this->model_account_customer->getCustomer($result['customer_id']);
			if ($customer_info) {
				$author = $customer_info['customername'];
				if($customer_info['cg_status']) {
					$customer_group = $customer_info['cg_status'];
				} else {
					$customer_group = "default";
				}
			} else {
				$author = $result['author'];
				$customer_group = "guest";
			}
			
        	$this->data['reviews'][] = array(
        		'author'     => $author,
				'customer_group' => $customer_group,
				'rating'     => $result['rating'],
				'text'       => strip_tags($result['text']),
        		'stars'      => sprintf($this->language->get('text_stars'), $result['rating']),
				'date_vn' 	 => $this->model_tool_time->timevn($result['date_added']),
        		'date_added' => date('h:iA d/m/Y',strtotime($result['date_added']))
        	);
      	}			
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			
		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->http('product/product/review&product_id=' . $this->request->get['product_id'] . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/review.tpl';
		} else {
			$this->template = 'default/template/product/review.tpl';
		}
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	public function write() {
    	$this->language->load('product/product');
		
		$this->load->model('catalog/review');
		
		$json = array();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
    		
			$json['success'] = $this->language->get('text_success');
		} else {
			$json['error'] = $this->error['message'];
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
  	private function validate() {
    	if ($this->session->data['captcha'] != $this->request->post['captcha']) {
      		$this->error['message'] = $this->language->get('error_captcha');
    	}
		
    	if (!$this->request->post['rating']) {
      		$this->error['message'] = $this->language->get('error_rating');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['text'])) < 25)) {
      		$this->error['message'] = $this->language->get('error_text');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
      		$this->error['message'] = $this->language->get('error_name');
    	}
		
    	if (!$this->error) {
      		return TRUE;
    	} else {
      		return FALSE;
    	}	
	}
}
?>
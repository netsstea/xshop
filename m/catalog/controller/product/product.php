<?php  
class ControllerProductProduct extends Controller {
	private $error = array(); 
	
	public function index() { 
		$this->language->load('product/product');
		$this->load->model('tool/seo_url'); 
		$this->load->model('catalog/product');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		$category_id = $this->model_catalog_product->getProductToCategory($product_id);
		$this->load->model('catalog/category');
		$cat_start = 0;
      	if ($category_id) {
			$path = '';
			$category_info = $this->model_catalog_category->getCategory($category_id);
			if($category_info) {
			$path = $category_id;
			while ($category_info['parent_id'] != 0) {
				$path = $category_info['parent_id'] . '_' . $path;
				$category_info = $this->model_catalog_category->getCategory($category_info['parent_id']);
			}
			}
			$this->document->path =  $path;
			foreach ($parts = explode('_', $path) as $path_id) {
				$category = $this->model_catalog_category->getCategory($path_id);
				
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
        	}
			$cat_start = $parts[0];
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
		
// information
		$this->load->model('catalog/information');
		$this->load->model('catalog/danhmucinfo');
		$this->data['informations'] = array();
;
		foreach ($this->model_catalog_danhmucinfo->getdanhmucinfos100(1) as $danhmucinfo_info) {
			foreach ($this->model_catalog_information->getinformationbydanhmucinfo($danhmucinfo_info['danhmucinfo_id'],1) as $result) {
				$this->data['informations'][] = array(
					'title' 	   => $result['title'],
					'lienketnhanh' => $result['lienketnhanh'],
					'description'  => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
				);
			}
		}
//end information
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
    	
		if ($product_info) {
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
									
			$this->document->title = $product_info['name'];
			
			$this->document->description = $product_info['meta_description'];
			
			$this->data['heading_title'] = $product_info['name'];
			
			$this->data['telephone'] = $this->config->get('config_telephone');
			$this->data['contact'] = html_entity_decode($this->config->get('config_lienhe_' . $this->config->get('config_language_id')), ENT_QUOTES, 'UTF-8');
			
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

			$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->load->model('catalog/review');

			$this->data['tab_description'] = $this->language->get('tab_description');
			$this->data['tab_kythuat'] = $this->language->get('tab_kythuat');
			$this->data['tab_image'] = $this->language->get('tab_image');
			$this->data['tab_review'] = sprintf($this->language->get('tab_review'), $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']));
			$this->data['tab_related'] = $this->language->get('tab_related');
			
			$average = $this->model_catalog_review->getAverageRating($this->request->get['product_id']);	
			
			$this->data['text_stars'] = sprintf($this->language->get('text_stars'), $average);
			
			$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

			$this->data['action'] = $this->url->http('checkout/cart');
			
			$this->data['redirect'] = $this->url->http('product/product' . $url . '&product_id=' . $this->request->get['product_id']);
			
			$this->load->helper('image');
			
			if ($product_info['image']) {
				$image = $product_info['image'];
			} else {
				$image = 'no_image.jpg';
			}	
					
	  		$this->data['thumb'] = image_resize($image, 150, 200);

			$discount = $this->model_catalog_product->getProductDiscount($this->request->get['product_id']);
			
			if ($discount) {
				$this->data['price'] = $this->currency->format($discount);
				$this->data['special'] = FALSE;
				$tax_price = $discount;
			} else {
				$this->data['price'] = $this->currency->format($product_info['price']);
				$tax_price = $product_info['price'];
				$special = $this->model_catalog_product->getProductSpecial($this->request->get['product_id']);
				if ($special) {
					$this->data['special'] = $this->currency->format($special);
					$tax_price = $special;
					$dongcap = $special;
				} else {
					$this->data['special'] = FALSE;
				}
			}
			$this->load->model('total/tax');
			$taxs = $this->model_total_tax->getTax($product_info['tax_class_id']);
			if($product_info['tax_class_id']) {
				foreach ($taxs as $tax) {
				$this->data['text_tax'] = $tax['description'];
				}
				$this->data['tax'] = $this->currency->format($this->tax->calculate($tax_price, $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$this->data['text_tax'] = sprintf($this->language->get('yes_tax'), '10% VAT');
				$this->data['tax'] = 0;
			}
			if($cat_start == 306) { $this->data['text_tax'] = ""; }
			if($product_info['location'] == 0) {
				$this->data['tax_price'] = 0;
			} else {
				$this->data['tax_price'] = $this->currency->format($product_info['location']);
			}
			
			
			$this->data['total_amount'] = $product_info['price'];
			
			if($product_info['price'] == 0) {$this->data['price'] = "Liên hệ";}
			
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
			
			$this->data['model'] = $product_info['model'];
			$this->data['baohanh'] = $product_info['baohanh'];
			$this->data['manufacturer'] = $product_info['manufacturer'];
			$this->data['manufacturers'] = $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $product_info['manufacturer_id']));
			$this->data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');			
			$this->data['kythuat'] = html_entity_decode($product_info['kythuat'], ENT_QUOTES, 'UTF-8');
			$this->data['khuyenmai'] = html_entity_decode($product_info['khuyenmai'], ENT_QUOTES, 'UTF-8');
			$this->data['motangan'] = html_entity_decode($product_info['motangan'], ENT_QUOTES, 'UTF-8');
      		$this->data['product_id'] = $this->request->get['product_id'];
			$this->data['average'] = $average;
			
			$tags = explode(',',html_entity_decode($product_info['tags'], ENT_QUOTES, 'UTF-8'));
			$this->data['tags'] = array();
			for ($i=0; $i<sizeof($tags); $i++) {
			$this->data['tags'][$i] = array(
				'keyword' => trim($tags[$i]),
				'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/search&keyword=' . str_replace(' ','-',str_replace('  ',' ',trim($tags[$i])))))
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
			
			$this->data['images'] = array();
			
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			
      		foreach ($results as $result) {
        		$this->data['images'][] = array(
          			'popup' => image_resize($result['image'] , $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
          			'thumb' => image_resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
        		);
      		}
			
			$this->data['videos'] = array();
			
			$results = $this->model_catalog_product->getProductVideos($this->request->get['product_id']);
			
      		foreach ($results as $result) {
				$video_id = explode('v=', $result['video']);
				if(isset($video_id[1])) {
					$this->data['videos'][] = array(
						'video_id' => $video_id[1]
					);
				}
      		}
			
// phu kien
			$this->data['phukiens'] = array();
			
			$results = $this->model_catalog_product->getProductPhukien($this->request->get['product_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $result['image'];
				} else {
					$image = 'no_image.jpg';
				}
				
				$special = FALSE;
				
				$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
			
				if ($discount) {
					$price = $this->currency->format($discount);
				} else {
					$price = $this->currency->format($result['price']);

					$special = $this->model_catalog_product->getProductSpecial($result['product_id']);

					if ($special) {
						$special = $this->currency->format($special);
					}
				}
				if ($result['quantity'] <= 0) {
					$stock = $this->language->get('text_instock');
				} else {
					if ($this->config->get('config_stock_display')) {
						$stock = $result['quantity'];
					} else {
						$stock = $result['stock'];
					}
				}
				if($result['price'] == 0) {$price = "Liên hệ";}
				$this->data['phukiens'][] = array(
					'name'    => $result['name'],
					'model'   => $result['model'],
					'baohanh' => $result['baohanh'],
					'stock'   => $stock,
					'motangan'    => html_entity_decode($result['motangan'], ENT_QUOTES, 'UTF-8'),
					'khuyenmai'    => html_entity_decode($result['khuyenmai'], ENT_QUOTES, 'UTF-8'),
					'thumb' => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
					'price'   => $price,
					'special' => $special,
					'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
				);
			}
// end phu kien

			$this->data['products'] = array();

			$category_id = $this->model_catalog_product->getProductToCategory($product_id);
			$this->data['xemtatca'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $category_id));
			$results = $this->model_catalog_product->getProductRelatedByCategoryId($product_id, $category_id, $sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 10);
			foreach ($results as $result) {
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
				if ($result['quantity'] <= 0) {
					$stock = $result['stock'];
				} else {
					if ($this->config->get('config_stock_display')) {
						$stock = $result['quantity'];
					} else {
						$stock = $this->language->get('text_instock');
					}
				}
				if($result['price'] == 0) {$price = "Liên hệ";}
				$this->data['products'][] = array(
					'name' => $result['name'],
					'model' => $result['model'],
					'baohanh' => $result['baohanh'],
					'product_id' => $result['product_id'],
					'manufacturer' => $result['manufacturer'],
					'stock' => $stock,
					'motangan' => html_entity_decode($result['motangan'], ENT_QUOTES, 'UTF-8'),
					'khuyenmai' => html_entity_decode($result['khuyenmai'], ENT_QUOTES, 'UTF-8'),
					'thumb' => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
					'price' => $price,
					'special' => $special,
					'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
				);
			}
			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = TRUE;
			} elseif ($this->customer->isLogged()) {
				$this->data['display_price'] = TRUE;

			} else {
				$this->data['display_price'] = FALSE;
			}
			$this->model_catalog_product->updateViewed($this->request->get['product_id']);
						
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/product.tpl';
			} else {
				$this->template = 'default/template/product/product.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer'
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

      		$this->data['continue'] = $this->url->http('common/home');
	  
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer'
			);	
			
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}
  	}
	
	public function review() {
    	$this->language->load('product/product');
		
		$this->load->model('catalog/review');

		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['reviews'] = array();
			
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'rating'     => $result['rating'],
				'text'       => strip_tags($result['text']),
        		'stars'      => sprintf($this->language->get('text_stars'), $result['rating']),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
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
    	if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
      		$this->error['message'] = $this->language->get('error_name');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text'])) > 1000)) {
      		$this->error['message'] = $this->language->get('error_text');
    	}

    	if (!$this->request->post['rating']) {
      		$this->error['message'] = $this->language->get('error_rating');
    	}

    	if ($this->session->data['captcha'] != $this->request->post['captcha']) {
      		$this->error['message'] = $this->language->get('error_captcha');
    	}
		
    	if (!$this->error) {
      		return TRUE;
    	} else {
      		return FALSE;
    	}	
	}	
}
?>
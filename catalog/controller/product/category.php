<?php 
class ControllerProductCategory extends Controller {  
	public function index() { 
		$this->language->load('product/category');
		$this->load->model('tool/seo_url');
		$this->load->helper('image'); 
	
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
      		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
       		'text'      => $this->language->get('text_home'),
       		'separator' => FALSE
   		);

		$this->load->model('catalog/category');
		
		$cat_start = 0;
		
		$title = '';
		$parts = array();
		
		if (isset($this->request->get['category_id'])) {
			$category = $this->model_catalog_category->getCategory($this->request->get['category_id']);
			if($category) {
				$path = $this->request->get['category_id'];
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
					
					$title = $category_data['name'];
				}
			}
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
			$url_manu = "&manufacturer_id=" . $this->request->get['manufacturer_id'];
			
			$this->load->model('catalog/manufacturer'); 

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
			
			if (isset($this->request->get['category_id'])) {
				$ex_name = $this->model_catalog_category->getManufacturerIdAndCategoryId($this->request->get['category_id'], $this->request->get['manufacturer_id']);
					
				if($ex_name && $ex_name['name']) {
					$title = $title . ' ' . $ex_name['name'];
					$manu_name = $ex_name['name'];
				} else {
					$title = $title . ' ' . $manufacturer_info['name'];
					$manu_name = $manufacturer_info['name'];
				}
			}
			
			$this->document->breadcrumbs[] = array(
				'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_id . $url_manu)),
				'text'      => $manu_name,
				'separator' => $this->language->get('text_separator')
			);
		} else {
			$manufacturer_id = 0;
			$url_manu = '';
		}
		
		foreach ($parts as $part) {
			if($part != $parts[0]) {
			$category = $this->model_catalog_category->getCategory($part);
			
			$this->document->breadcrumbs[] = array(
				'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $part)),
				'text'      => $category['name'],
				'separator' => $this->language->get('text_separator')
			);
			
			$title = $title . ', ' .  $category['name'];
			}
		}
		
		$query = '';
		$title1 = '';
		
		if (isset($this->request->get['plid'])) {
			$query .= '&plid=' . $this->request->get['plid'];
			$plid = $this->request->get['plid'];
			
			$plids = explode('_', $plid);
			
			$this->load->model('catalog/phanloai'); 
			
			foreach($plids as $phanloai_id) {
				$plid_info = $this->model_catalog_phanloai->getphanloai($phanloai_id);
				
				$title1 = $title1 . ' ' . $plid_info['name'];
			}
		} else {
			$plid = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);
	
		if ($category_info) {
			$url_seo = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_id . $url_manu));
			
			if($this->config->get('config_seo_url')) {
				if(isset($this->request->get['_route_'])){
					if ($url_seo != (HTTP_SERVER . $this->request->get['_route_'])){
					$this->redirect($url_seo . $query);
					}
				} else {
					$this->redirect($url_seo . $query);
				}
			}
			
			if($title) {
				$this->document->title = html_entity_decode($title . $title1, ENT_QUOTES, 'UTF-8');
				
				$this->data['heading_title'] = $title;
			} else {
				$this->document->title = html_entity_decode($category_info['name'], ENT_QUOTES, 'UTF-8');
				
				$this->data['heading_title'] = $category_info['name'];
			}
			
			$this->document->description = html_entity_decode($category_info['meta_description'], ENT_QUOTES, 'UTF-8');
			
			$this->document->keywords = html_entity_decode($category_info['keywords'], ENT_QUOTES, 'UTF-8');
			
			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			
			if ($category_info['image']) {
				$image = $category_info['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['image'] = HTTP_IMAGE . $category_info['image'];
			
			$this->data['text_sort'] = $this->language->get('text_sort');
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}	
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.price';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
        		$this->data['categories'] = array();
        		
				$results = $this->model_catalog_category->getCategories($category_id);
				
        		foreach ($results as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					$this->data['categories'][] = array(
            			'name'  => $result['name'],
            			'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $result['category_id'] . $url_manu . $url)),
            			'thumb' => image_resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'))
          			);
        		}
			
			$this->load->model('catalog/product');
			$this->load->model('catalog/attribute');
			 
			$category_total = $this->model_catalog_category->getTotalCategoriesByCategoryId($category_id);
			$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id, $manufacturer_id, $plid);

			$this->data['products'] = array();
			
			$results = $this->model_catalog_product->getProductsByCategoryId($category_id, $manufacturer_id, $plid, $sort, $order, ($page - 1) * $this->config->get('config_category'), $this->config->get('config_category'));
			
			foreach ($results as $result) {
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

			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = TRUE;
			} elseif ($this->customer->isLogged() && ($this->customer->getCustomerGroupVip() || $this->customer->getCustomerGroupMod() || $this->customer->getCustomerGroupAdmin())) {
				$this->data['display_price'] = TRUE;
			} else {
				$this->data['display_price'] = FALSE;
			}
	
			$url = '';
	
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_date_added_desc'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=p.date_added&order=DESC')) . $query
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=p.viewed&order=DESC')) . $query
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=p.price&order=ASC')) . $query
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=p.price&order=DESC')) . $query
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=rating&order=DESC')) . $query
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . '&sort=rating&order=ASC')) . $query
			);		
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			$href = $url_seo . $query;
			$title = '';
			
			if (isset($this->request->get['option']) && $this->request->get['option'] == 'special') {
				$this->document->title .= ' - ' . $this->language->get('text_special');
				$this->document->description = $this->language->get('text_special') . ' - ' . $this->document->description;
				$title .= $this->language->get('text_special');
				
				$this->document->breadcrumbs[] = array(
					'href'      => $href,
					'text'      => $title,
					'separator' => $this->language->get('text_separator')
				);
				$title .= ' - ';
			}
			
			if (isset($this->request->get['order']) && isset($this->request->get['sort'])) {
				$this->document->title .= ' - ' . $this->language->get('text_sort') . $this->language->get('text_' .str_replace(array('pd.','p.'),'',$this->request->get['sort']) . '_' . strtolower($this->request->get['order']));
				$this->document->description = $this->document->description;
				$href .= '&sort=' . $this->request->get['sort'] . '&order=' . $this->request->get['order'];
				$title .= $this->language->get('text_sort') . $this->language->get('text_' .str_replace(array('pd.','p.'),'',$this->request->get['sort']) . '_' . strtolower($this->request->get['order']));
				
				$this->document->breadcrumbs[] = array(
					'href'      => $href,
					'text'      => $title,
					'separator' => $this->language->get('text_separator')
				);
				$title .= ' - ';
			}
			if (isset($this->request->get['page'])) {
				$this->document->title .= ' - ' . $this->language->get('text_page') . $this->request->get['page'];
				$this->document->description = $this->language->get('text_page') . $this->request->get['page'] . ' - ' . $this->document->description;
				$title .= $this->language->get('text_page') . $this->request->get['page'];
				$href .= '&page=' . $this->request->get['page'];
				
				$this->document->breadcrumbs[] = array(
					'href'      => $href,
					'text'      => $title,
					'separator' => $this->language->get('text_separator')
				);
			}
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_category');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu . $url . '&page=%s')) . $query;
		
			$this->data['pagination'] = $pagination->render();
		
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
			} else {
				$this->template = 'default/template/product/category.tpl';
			}	
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right',
				'module/category',
				'module/manufacturer',
				'module/phanloai'
			);
	
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
			
			if (isset($this->request->get['category_id'])) {	
	       		$this->document->breadcrumbs[] = array(
   	    			'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url)),
    	   			'text'      => $this->language->get('text_error'),
        			'separator' => $this->language->get('text_separator')
        		);
			}
				
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
}
?>
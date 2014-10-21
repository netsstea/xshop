<?php 
class ControllerProductSearch extends Controller { 	
	public function index() { 
    	$this->language->load('product/search');
		$this->load->model('tool/seo_url');
		$this->load->helper('image');
		
		if (isset($this->request->get['keyword'])) {
			$this->document->title = sprintf($this->language->get('text_timthay'),$this->request->get['keyword'],$this->request->get['keyword'],$this->request->get['keyword']);
			
			$this->document->description = sprintf($this->language->get('text_meta_description'),$this->request->get['keyword'],$this->request->get['keyword'],$this->request->get['keyword']);
			
			$title = sprintf($this->language->get('text_ketqua'),$this->request->get['keyword']);
			
			$this->data['heading_title'] = $this->request->get['keyword'];
		} else {
			$this->document->title = $this->language->get('heading_title');
			
			$title = $this->language->get('heading_title');
			
			$this->data['text_search'] = sprintf($this->language->get('text_search'),0);
			
			$this->data['heading_title'] = $this->language->get('heading_title');
		}

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

		$url_search='';
		
		if (isset($this->request->get['keyword'])) {
			$url_search .= '&keyword=' . html_entity_decode($this->request->get['keyword'], ENT_QUOTES, 'UTF-8');
			$url_seo = $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search));
			if($this->config->get('config_seo_url')) {
				if (!isset($this->request->get['_route_'])){
					$this->redirect($url_seo);
				}
			}
		} else {
			if($this->config->get('config_seo_url')) {
				if (!isset($this->request->get['_route_'])){
					$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('product/search')));
				}
			}		
		}
		
		$query ='';
		
		if (isset($this->request->get['plid'])) {
			$query .= '&plid=' . $this->request->get['plid'];
			$plid = $this->request->get['plid'];
		} else {
			$plid = 0;
		}
	
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)),
       		'text'      => $title,
      		'separator' => $this->language->get('text_separator')
   		);
   
    	$this->data['text_critea'] = $this->language->get('text_critea');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_sort'] = $this->language->get('text_sort');
			 
		$this->data['entry_search'] = $this->language->get('entry_search');
    	$this->data['entry_description'] = $this->language->get('entry_description');
		  
    	$this->data['button_search'] = $this->language->get('button_search');
   
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
		
		if (isset($this->request->get['keyword'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/attribute');
			
			$product_total = $this->model_catalog_product->getTotalProductsByKeyword($this->request->get['keyword']);
			$this->data['text_search'] = sprintf($this->language->get('text_search'),$product_total);
			
			if ($product_total) {
        		$this->data['products'] = array();
				
				$results = $this->model_catalog_product->getProductsByKeyword($this->request->get['keyword'], $sort, $order, ($page - 1) * $this->config->get('config_search'), $this->config->get('config_search'));
        		
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
				
				$this->data['sorts'] = array();
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_date_added_desc'),
					'value' => 'p.date_added-DESC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=p.date_added&order=DESC' . $query
				);
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_viewed_desc'),
					'value' => 'p.viewed-DESC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=p.viewed&order=DESC' . $query
				);

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=p.price&order=ASC' . $query
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=p.price&order=DESC' . $query
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=rating&order=DESC' . $query
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . '&sort=rating&order=ASC' . $query
				); 
				
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}	

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				$href = $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search));
				$title = '';
				if (isset($this->request->get['order']) && isset($this->request->get['sort'])) {
					$this->document->title .= ' - ' . $this->language->get('text_sort') . $this->language->get('text_' .str_replace(array('pd.','p.'),'',$this->request->get['sort']) . '_' . strtolower($this->request->get['order']));
					$this->document->description = $this->document->description;
					$href = $href . '&sort=' . $this->request->get['sort'] . '&order=' . $this->request->get['order'];
					$title .= $this->language->get('text_sort') . $this->language->get('text_' .str_replace(array('pd.','p.'),'',$this->request->get['sort']) . '_' . strtolower($this->request->get['order']));
					
					$this->document->breadcrumbs[] = array(
						'href'      => $href . $query,
						'text'      => $title,
						'separator' => $this->language->get('text_separator')
					);
					$title .= ' - ';
				}
				if (isset($this->request->get['page'])) {
					$this->document->title .= ' - ' . $this->language->get('text_page') . $this->request->get['page'];
					$this->document->description = $this->language->get('text_page') . $this->request->get['page'] . ' - ' . $this->document->description;
					
					$this->document->breadcrumbs[] = array(
						'href'      => $href . '&page=' . $this->request->get['page'] . $query,
						'text'      => $title . $this->language->get('text_page') . $this->request->get['page'],
						'separator' => $this->language->get('text_separator')
					);
				}
				
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $this->config->get('config_search'); 
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->model_tool_seo_url->rewrite($this->url->http('product/search' . $url_search)) . $url . '&page=%s' . $query;
				
				$this->data['pagination'] = $pagination->render();
				
				$this->data['sort'] = $sort;
				$this->data['order'] = $order;
			}
		}
  
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/search.tpl';
		} else {
			$this->template = 'default/template/product/search.tpl';
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
?>
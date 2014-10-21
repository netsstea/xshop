<?php 
class ControllerProductManufacturer extends Controller {  
	public function index() { 
		$this->language->load('product/manufacturer');
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/product');
		$this->load->model('tool/seo_url'); 
		$this->load->helper('image');
		
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
	
		if ($manufacturer_info) {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $this->request->get['manufacturer_id'])),
        		'text'      => $manufacturer_info['name'],
        		'separator' => $this->language->get('text_separator')
      		);
					  		
			$this->document->title = 'Thương hiệu ' . $manufacturer_info['name'];
									
			$this->data['heading_title'] = 'Thương hiệu ' . $manufacturer_info['name'];

			$this->load->model('catalog/category');
			$this->load->model('catalog/attribute');
			 
			$this->data['categories'] = array();
			
			$category_info = $this->model_catalog_category->getCategories(0);
		
			foreach ($category_info as $category) {
				$products = array();
				
				$results = $this->model_catalog_product->getProductsByCategoryId($category['category_id'], $manufacturer_id, '', '', '', 0, $this->config->get('config_manufacturer'));

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
					$products[] = array(
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
				
				$ex_name = $this->model_catalog_category->getManufacturerIdAndCategoryId($category['category_id'], $manufacturer_id);
					
				if($ex_name && $ex_name['name']) {
					$cat_name = $category['name'] . ' ' . $ex_name['name'];
				} else {
					$cat_name = $category['name'] . ' ' . $manufacturer_info['name'];
				}
				
				$this->data['categories'][] = array(
					'name'            => $cat_name,
					'href'        	  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category['category_id'] . '&manufacturer_id=' . $manufacturer_id)),
					'products'        => $products
				);
			}
			
			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = TRUE;
			} elseif ($this->customer->isLogged() && ($this->customer->getCustomerGroupVip() || $this->customer->getCustomerGroupMod() || $this->customer->getCustomerGroupAdmin())) {
				$this->data['display_price'] = TRUE;
			} else {
				$this->data['display_price'] = FALSE;
			}
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/manufacturer.tpl';
			} else {
				$this->template = 'default/template/product/manufacturer.tpl';
			}	
			
			$this->children = array(
				'common/header',
				'common/footer',
				'module/category',
				'module/manufacturer',
				'module/phanloai',
				'common/column_left',
				'common/column_right'
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
			
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)),
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
}
?>
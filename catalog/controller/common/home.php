<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->language->load('common/home');
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->helper('image');
		
		if (isset($this->request->get['_route_'])) {
			$rurl = $this->model_tool_seo_url->RedirectUrl(HTTP_SERVER . $this->request->get['_route_']);
			if($rurl) {
				$this->redirect($rurl);
			} else {
				$this->redirect(HTTP_SERVER);
			}
		}
		
		if (isset($this->session->data['popup'])) {
			$this->session->data['popup'] = "damoroi";
		}
		if (isset($this->session->data['popup'])) {
			$this->data['popup'] = $this->session->data['popup'];
		} else {
			$this->data['popup'] ='';
		}
		$this->data['link_popup'] = $this->url->http('common/home/popup');
		
		$this->document->title = html_entity_decode($this->config->get('config_title'), ENT_QUOTES, 'UTF-8');
		
		$this->document->description = html_entity_decode($this->config->get('config_meta_description'), ENT_QUOTES, 'UTF-8');
		
		$this->document->keywords = html_entity_decode($this->config->get('config_meta_keywords'), ENT_QUOTES, 'UTF-8');
		
		if($this->config->get('popup_status')) {
		$this->data['popup_status'] = $this->config->get('popup_status');
		} else {
		$this->data['popup_status'] = '';
		}
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_store'));
		$this->data['welcome'] = html_entity_decode($this->config->get('config_welcome_' . $this->config->get('config_language_id')));

//slide
		$this->load->model('catalog/slideshow');	
		
		$this->data['tophomes'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('tlh') as $result) {
      		$this->data['tophomes'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => image_resize_fix($result['image'], 520, 312)
      		);
    	}
		
		$this->data['toprighthome1s'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('trh1') as $result) {
      		$this->data['toprighthome1s'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => image_resize_fix($result['image'], 298, 150)
      		);
    	}
		
		$this->data['toprighthome2s'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('trh2') as $result) {
      		$this->data['toprighthome2s'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => image_resize_fix($result['image'], 298, 150)
      		);
    	}
		
		$this->data['bottomlefthomes'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('blh') as $result) {
      		$this->data['bottomlefthomes'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => image_resize_fix($result['image'], 523, 150)
      		);
    	}
		
		$this->data['bottomrighthomes'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('brh') as $result) {
      		$this->data['bottomrighthomes'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => image_resize_fix($result['image'], 523, 150)
      		);
    	}
//end slide


// danh muc home
		$this->load->model('catalog/chome');
		$this->load->model('catalog/attribute');
		 
		$this->data['chomes'] = array();
		
		$chomes = $this->model_catalog_chome->getchomes();
		
	foreach ($chomes as $chome) {
		
		$chome['products'] = array();

		foreach ($this->model_catalog_product->getProductsBychomeId($chome['chome_id'],0,24) as $result) {	
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
			
			$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
			
			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($pprice, $result['tax_class_id'], $this->config->get('config_tax')));
			 
				$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
			
				if ($special) {
					$phantram = floor((($special - $pprice)*100)/$pprice) . '%';
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}						
			}
			
			$attributes = array();
			
			$catIdStart = $this->model_catalog_product->getCatStart($result['product_id']);
			
			$attribute_data = $this->model_catalog_attribute->getAttributesByCategoryId($catIdStart,$result['product_id'],'thongsolistsp');
			
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
			
			if($pprice == 0) {$price = $this->language->get('price_contact');}
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_model'] = $this->language->get('text_model');
          	$chome['products'][] = array(
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
		if($chome['image']) {
			$chimage = 'image/' . $chome['image'];
		} else {
			$chimage = 'image/no_image.jpg';
		}
		$this->data['chomes'][] = array(
			'chome_id'        => $chome['chome_id'],
			'name'            => $chome['name'],
			'image'           => $chimage,
			'link'        	  => $chome['link'],
			'products'        => $chome['products']
		);
	}
// end danh muc home

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged() && ($this->customer->getCustomerGroupVip() || $this->customer->getCustomerGroupMod() || $this->customer->getCustomerGroupAdmin())) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	public function popup() {
		$this->session->data['popup'] = 1;
		
		if ($this->config->get('popup_status')) {
			$this->data['popup'] = html_entity_decode($this->config->get('popup_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['popup'] = '';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/popup.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/popup.tpl';
		} else {
			$this->template = 'default/template/common/popup.tpl';
		}
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>
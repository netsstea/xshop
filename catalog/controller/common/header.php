<?php
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->load->model('tool/seo_url');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['currency_code'])) {
      		$this->currency->set($this->request->post['currency_code']);

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('common/home')));
			}
   		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['zone_code'])) {
      		$this->zone->set($this->request->post['zone_code']);

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('common/home')));
			}
   		}
		
		if ($this->config->get('header_status')) {
			$this->data['header'] = html_entity_decode($this->config->get('header_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['header'] = '';
		}
		$this->language->load('common/header');
		$this->data['title'] = $this->document->title;
		$this->data['description'] = $this->document->description;
		$this->data['keywords'] = $this->document->keywords;
		$this->data['image'] = $this->document->image;

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}
		
		if ($this->config->get('google_analytics_status')) {
			$this->data['google_analytics'] = html_entity_decode($this->config->get('google_analytics_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['google_analytics'] = '';
		}
		
		$this->data['home_select'] = 1;
		$this->data['news_select'] = 0;
		$this->data['product_select'] = 0;
		$this->data['contact_select'] = 0;
		$this->data['product_product_select'] = 0;
		$this->data['category_select'] = 0;
		
		if(isset($this->request->get['route'])){
			$link = explode('/', $this->request->get['route']);
			$this->data['home_select'] = 0;
			if ($link[0] == "news"){ $this->data['news_select'] = 1; }
			if ($this->request->get['route'] == 'product/category'){ $this->data['category_select'] = 1; }
			if ($link[0] == "product") {
				if (isset($link[1]) && $link[1] == "product"){
					$this->data['product_product_select'] = 1;
				}
				$this->data['product_select'] = 1; 
			}
				
			if ($link[0] == "information" && isset($link[1]) && $link[1] == "contact"){ $this->data['contact_select'] = 1; }
		} else {
			unset($this->session->data['hassuccess']);
		}
		
//slide
		$this->load->model('catalog/slideshow');
		$this->load->helper('image');
		
		$this->data['bannerlefts'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('bl') as $result) {
      		$this->data['bannerlefts'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => 'image/' . $result['image']
      		);
    	}
		
		$this->data['bannerrights'] = array();

		foreach ($this->model_catalog_slideshow->getslideshows('br') as $result) {
      		$this->data['bannerrights'][] = array(
        		'name' => $result['name'],
				'link' => $result['link'],
	    		'image' => 'image/' . $result['image']
      		);
    	}
//end slide
		
// information
		$this->load->model('catalog/information');
		$this->load->model('catalog/cinformation');
		$this->data['informations'] = array();
		foreach ($this->model_catalog_cinformation->getcinformations('header',1) as $cinformation_info) {
			foreach ($this->model_catalog_information->getinformationbycinformation($cinformation_info['cinformation_id'],3) as $result) {
				$name_info = explode(' ',trim($result['name']));
				$name_2_text = $name_info[0] . " " . $name_info[1];
				$this->data['informations'][] = array(
					'name' 	   				=> str_replace($name_2_text,$name_2_text . '<br/>',$result['name']),
					'information_id' 	    => $result['information_id'],
					'link' 					=> $result['link'],
					'description' 			=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'image' 				=> 'image/' . $result['image'],
					'href' 	 	   			=> $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
				);
			}
		}
//end information


// Menu
		if (isset($this->request->get['category_id'])) {
			$this->data['category_id'] = $this->request->get['category_id'];
		} elseif (isset($this->document->path)) {
			$path = explode('_', $this->document->path);
		
			$this->data['category_id'] = end($path);
		} else {
			$this->data['category_id'] = '';
		}
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->getCategories(0);
		
		$this->load->model('catalog/manufacturer');
		$category_manufacturer = array();
		$this->data['manufacturer_datas'] = array();
		
		$manufacturer_datas = $this->model_catalog_manufacturer->getManufacturerByMenuStatus();
		
		if($manufacturer_datas) {
			foreach ($manufacturer_datas as $manufacturer_data) {
			
				$category_data = $this->model_catalog_category->getCategoriesByManufacturerId($manufacturer_data['manufacturer_id']);
				
				foreach ($category_data as $category_info) {
				
					$category_manufacturer_children_data = $this->model_catalog_category->getCategoriesManufacturers($category_info['category_id']);
					$category_manufacturer_children = array();
					
					if($category_manufacturer_children_data) {
						foreach ($category_manufacturer_children_data as $category_manufacturer_children_info) {
							$category_manufacturer_children[] = array(
								"name" 		=> $category_manufacturer_children_info['name'],
								"href" 		=> $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_manufacturer_children_info['category_id']))
							);
						}
					}
					
					if($category_info['ex_name']) {
						$name = $category_info['ex_name'];
					} else {
						$name = $category_info['name'];
					}
					
					$category_manufacturer[] = array(
						"name" 							 => $name,
						"category_manufacturer_children" => $category_manufacturer_children,
						"href" 							 => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_info['category_id'] . '&manufacturer_id=' . $category_info['manufacturer_id']))
					);
				}
				
				if ($manufacturer_data['icon_menu']) {
					$icon_menu = 'image/' . $manufacturer_data['icon_menu'];
				} else {
					$icon_menu = 'image/no_image.jpg';
				}
				
				if ($manufacturer_data['banner']) {
					$banner = 'image/' . $manufacturer_data['banner'];
				} else {
					$banner = '';
				}
				
				$this->data['manufacturer_datas'][] = array(
					"name" 					=> $manufacturer_data['name'],
					"category_manufacturer" => $category_manufacturer,
					"image" 				=> $icon_menu,
					"banner" 				=> $banner,
					"href" 					=> $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $manufacturer_data['manufacturer_id']))
				);
			}
		}	
		
//end menu

//cnews		
		$this->load->model('catalog/cnews');
		$cnews_info = $this->model_catalog_cnews->getCnewss(0);
		$this->data['cnews'] = array();
		foreach ($cnews_info as $result) {
			$this->data['cnews'][] = array(
				'name'  => $result['name'],
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/cnews&cnews_id=' . $result['cnews_id']))
			);
		}
//end news

// dang nhap
		$this->load->model('account/customer');
		if ($this->customer->isLogged()) {
				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
				if ($customer_info) {
					$this->data['customername'] = $customer_info['customername'];
				}
		} else {
		$this->data['customername'] = '';
		}
		$this->data['text_create'] = $this->language->get('text_create');
    	$this->data['text_login'] = $this->language->get('text_login');
    	$this->data['text_logout'] = $this->language->get('text_logout');
    	$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_helu'] = $this->language->get('text_helu');
		$this->data['create_account'] = $this->model_tool_seo_url->rewrite($this->url->https('account/create'));
    	$this->data['account'] = $this->model_tool_seo_url->rewrite($this->url->https('account/account'));
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['loginpopup'] = $this->model_tool_seo_url->rewrite($this->url->https('account/loginpopup'));
		$this->data['logout'] = $this->model_tool_seo_url->rewrite($this->url->http('account/logout'));
		$this->data['logoutpopup'] = $this->model_tool_seo_url->rewrite($this->url->https('account/logout/logoutpopup'));
// end dang nhap

// Support
		if ($this->config->get('support_position') == 'taskbar' && $this->config->get('support_status')) {
			$this->data['support_status'] = true;
		} else {
			$this->data['support_status'] = false;
		}
// end support

//slide
		$this->load->model('catalog/slideshow');
		
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

// thong tin
		$this->load->model('catalog/information');
		$this->load->model('catalog/cinformation');
		$this->data['daotaos'] = array();
		foreach ($this->model_catalog_cinformation->getcinformations('daotao',1) as $cinformation_info) {
			foreach ($this->model_catalog_information->getinformationbycinformation($cinformation_info['cinformation_id']) as $result) {
				$this->data['daotaos'][] = array(
					'name' 	   				=> $result['name'],
					'link' 					=> $result['link'],
					'href' 	 	   			=> $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
				);
			}
		}
		
//dich vu
		$this->data['dichvus'] = array();
		foreach ($this->model_catalog_cinformation->getcinformations('dichvu',1) as $cinformation_info) {
			foreach ($this->model_catalog_information->getinformationbycinformation($cinformation_info['cinformation_id']) as $result) {
				$this->data['dichvus'][] = array(
					'name' 	   				=> $result['name'],
					'link' 					=> $result['link'],
					'href' 	 	   			=> $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
				);
			}
		}
//end information

		$this->data['charset'] = $this->language->get('charset');
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['links'] = $this->document->links;	
		$this->data['styles'] = $this->document->styles;
		$this->data['scripts'] = $this->document->scripts;		
		$this->data['breadcrumbs'] = $this->document->breadcrumbs;
		$this->data['icon'] = $this->config->get('config_icon');
		
		if (isset($this->request->server['HTTPS']) && ($this->request->server['HTTPS'] == 'on')) {
			$this->data['logo'] = HTTPS_IMAGE . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
		}
		
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
    	$this->data['text_cart'] = $this->language->get('text_cart'); 
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_advanced'] = $this->language->get('text_advanced');
		$this->data['text_cart_chitiet'] = $this->language->get('text_cart_chitiet');
		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['button_go'] = $this->language->get('button_go');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_gioithieu'] = $this->language->get('text_gioithieu');
		$this->data['text_currency'] = $this->language->get('text_currency');

		$this->data['home'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
		$this->data['special'] = $this->model_tool_seo_url->rewrite($this->url->http('product/special'));
		$this->data['contact'] = $this->model_tool_seo_url->rewrite($this->url->http('information/contact'));
    	$this->data['sitemap'] = $this->model_tool_seo_url->rewrite($this->url->http('information/sitemap'));
    	$this->data['cart'] = $this->model_tool_seo_url->rewrite($this->url->http('checkout/cart'));
		$this->data['checkout'] = $this->model_tool_seo_url->rewrite($this->url->https('checkout/shipping'));
		$this->data['news_href'] = $this->model_tool_seo_url->rewrite($this->url->http('news/cnews'));
		$this->data['gioithieu'] = $this->model_tool_seo_url->rewrite($this->url->http('information/gioithieu'));
		$this->data['showroom'] = $this->model_tool_seo_url->rewrite($this->url->http('information/showroom'));
		
		if (isset($this->request->get['keyword'])) {
			$this->data['keyword'] = $this->request->get['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		$this->data['action'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));

		if (!isset($this->request->get['route'])) {
			$this->data['redirect'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
		} elseif (isset($this->request->get['_route_'])) {
			$this->data['redirect'] = HTTP_SERVER . $this->request->get['_route_'];
		} else {
			
			$data = $this->request->get;
			
			unset($data['_route_']);
			
			$route = $data['route'];
			
			unset($data['route']);
			
			$url = '';
			
			if ($data) {
				$url = '&' . urldecode(http_build_query($data));
			}			
			
			$this->data['redirect'] = $this->url->http($route . $url);
		}
		
		$this->data['language_code'] = $this->session->data['language'];	
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = array();
		
		$results = $this->model_localisation_language->getLanguages();
		
		foreach ($results as $result) {
			if ($result['status']) {
				$this->data['languages'][] = array(
					'name'  => $result['name'],
					'code'  => $result['code'],
					'image' => $result['image']
				);	
			}
		}
		
		$this->data['currency_code'] = $this->currency->getCode(); 
		
		$this->load->model('localisation/currency');
		 
		 $this->data['currencies'] = array();
		 
		$results = $this->model_localisation_currency->getCurrencies();	
		
		foreach ($results as $result) {
			if ($result['status']) {
   				$this->data['currencies'][] = array(
					'title' => $result['title'],
					'code'  => $result['code']
				);
			}
		}
		
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

		$this->data['store'] = $this->config->get('config_store');
		$this->data['address'] = $this->config->get('config_address');
		$this->data['telephone'] = $this->config->get('config_telephone');
		$this->data['fax'] = $this->config->get('config_fax');
		$this->data['hotline'] = $this->config->get('config_hotline');
		
    	$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_emails'] = $this->language->get('text_emails');
		$this->data['text_hotline'] = $this->language->get('text_hotline');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
    	$this->data['text_fax'] = $this->language->get('text_fax');
		
		$this->id = 'header';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}
		
    	$this->render();
	}
	private function getCategories($parent_id, $current_path = '', $level = 0) {
		$level++;
		$data = array();
		$this->load->model('catalog/product');
		
		$results = $this->model_catalog_category->getCategoriesMenu($parent_id);
		
		foreach ($results as $result) {
			if ($result['image']) {
				$image = 'image/' . $result['image'];
			} else {
				$image = '';
			}
			
			if ($result['icon_menu']) {
				$icon_menu = 'image/' . $result['icon_menu'];
			} else {
				$icon_menu = 'image/no_image.jpg';
			}
			
			$manufacturers = array();
			
			$phanloais = array();
			
			if($result['cshow']) {
			
				$cshow_info = explode(',',$result['cshow']);
				
				foreach ($cshow_info as $cshow) {
					if($cshow == "thuonghieu=1") {

						$resultmns = $this->model_catalog_category->getManufacturerByCategoryId($result['category_id']);
						
						foreach ($resultmns as $resultmn) {
							$ex_name = $this->model_catalog_category->getManufacturerIdAndCategoryId($result['category_id'], $resultmn['manufacturer_id']);
							
							if($ex_name['name']) {
								$manu_name  = $ex_name['name'];
							} else {
								$manu_name = $resultmn['name'];
							}
							
							$manufacturers[] = array(
								'name'            => $manu_name,
								'href'            => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $result['category_id'] . '&manufacturer_id=' . $resultmn['manufacturer_id']))
							);
						}
					}
					
					if(strpos(str_replace('phanloai_id=',' phanloai_id= ',$cshow),"phanloai_id=")) {
					
						$phanloai_id = (int)str_replace('phanloai_id=','',$cshow);
						
						$this->load->model('catalog/phanloai');

						$boloc = array();
						
						$resultpls = $this->model_catalog_phanloai->getPhanloaisByCategoryId($phanloai_id, $result['category_id']);	

						foreach ($resultpls as $resultpl) {
							$boloc[] = array(
								'href'        	  => $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $result['category_id'])) . '&plid=' . $resultpl['phanloai_id'],
								'name'        	  => $resultpl['name']
							);
						}
						
						$plr = $this->model_catalog_phanloai->getphanloai($phanloai_id);
						if($plr) {
							$phanloais[] = array(
								'boloc'        	  => $boloc,
								'name'        	  => $plr['name']
							);
						}
					}
				}
			}
			
			$children = $this->getCategories($result['category_id'], $level);
			
			$data[] = array(
				'category_id' 	=> $result['category_id'],
				'manufacturers' => $manufacturers,
				'phanloais' 	=> $phanloais,
				'image' 	  	=> $image,
				'icon_menu' 	=> $icon_menu,
				'href'        	=> $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $result['category_id'])),
				'children'		=> $children,
				'name'        	=> html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')
			);
		}
		
		return $data;
	}
	
	public function account() {
// dang nhap
		$this->language->load('common/header');
		$this->load->model('tool/seo_url');
		$this->load->model('account/customer');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		if ($this->customer->isLogged()) {
				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
				if (isset($customer_info)) {
					$this->data['customername'] = $customer_info['customername'];
				}
		} else {
		$this->data['customername'] = '';
		}
		$this->data['text_create'] = $this->language->get('text_create');
    	$this->data['text_login'] = $this->language->get('text_login');
    	$this->data['text_logout'] = $this->language->get('text_logout');
    	$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_helu'] = $this->language->get('text_helu');
		$this->data['create_account'] = $this->model_tool_seo_url->rewrite($this->url->https('account/create'));
    	$this->data['account'] = $this->model_tool_seo_url->rewrite($this->url->https('account/account'));
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['loginpopup'] = $this->model_tool_seo_url->rewrite($this->url->https('account/login')) . "&view=loginpopup";
		$this->data['login'] = $this->model_tool_seo_url->rewrite($this->url->https('account/login'));
		$this->data['logoutpopup'] = $this->model_tool_seo_url->rewrite($this->url->https('account/logout/logoutpopup'));
		$this->data['logout'] = $this->model_tool_seo_url->rewrite($this->url->http('account/logout'));
// end dang nhap
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/account.tpl';
		} else {
			$this->template = 'default/template/common/account.tpl';
		}
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	public function search() {

		$this->language->load('common/header');
		if (isset($this->request->get['keyword'])) {
			$this->data['keyword'] = $this->request->get['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['entry_search'] = $this->language->get('entry_search');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/search.tpl';
		} else {
			$this->template = 'default/template/common/search.tpl';
		}
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>
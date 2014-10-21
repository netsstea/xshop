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
		
		$this->load->model('catalog/mobile');
		$mobile = $this->model_catalog_mobile->mobile_device_detect();
		
		if (isset($this->request->get['_route_'])){
			$home_url = HTTP_HOME . $this->request->get['_route_'];
		} else {
			$home_url = HTTP_HOME;
		}
		
		if (!$mobile){
			$this->redirect($home_url);
		}
		if(isset($this->request->get['route'])){
			$this->data['home_select'] = 0;
			if ($this->request->get['route'] == "product/product"){ $this->data['product_select'] = 1; } else { $this->data['product_select'] = 0; }
		} else {
			$this->data['home_select'] = 1;
			$this->data['product_select'] = 0;
		}

		$this->language->load('common/header');
		$this->data['title'] = $this->document->title;
		$this->data['description'] = $this->document->description;
		$this->data['keywords'] = $this->document->keywords;

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
		
// danh muc
		$this->load->model('catalog/category');
		$this->data['categories'] = array();

		$results = $this->model_catalog_category->getCategories_menu(0);

		foreach ($results as $result) {
			$children = array();
			$result_childs = $this->model_catalog_category->getCategories_menu($result['category_id']);
			foreach ($result_childs as $result_child) {
				$children[] = array(
					'name' => $result_child['name'],
					'category_id' => $result_child['category_id'],
					'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result_child['category_id']))
				);
			}
			$this->data['categories'][] = array(
				'name' => $result['name'],
				'children' => $children,
				'category_id' => $result['category_id'],
				'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result['category_id']))
			);
		}
// end danh muc

//cnews	
		// danh muc news
		$this->load->model('catalog/category_news');
		$cnews_info = $this->model_catalog_category_news->getCategories(0);
		$this->data['cnews'] = array();
		foreach ($cnews_info as $result) {
			$this->data['cnews'][] = array(
				'name'  => $result['name'],
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/category_news&path_news=' . $result['category_news_id']))
			);
		}
//end news

// dich vu info
		$this->load->model('catalog/information');
		$this->data['dichvus'] = array();
		
		foreach ($this->model_catalog_information->getInformationsSortOrder(101) as $result) {
			$this->data['dichvus'][] = array(
				'title' 	   => $result['title'],
				'lienketnhanh' => $result['lienketnhanh'],
				'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
			);
		}
//

// end dich vu info

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
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['button_go'] = $this->language->get('button_go');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_gioithieu'] = $this->language->get('text_gioithieu');

		$this->data['home'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
		$this->data['contact'] = $this->model_tool_seo_url->rewrite($this->url->http('information/contact'));
		$this->data['gioithieu'] = $this->model_tool_seo_url->rewrite($this->url->http('information/gioithieu'));
		
		$this->data['product'] = $this->model_tool_seo_url->rewrite($this->url->http('product/sanpham'));
		$this->data['tintuc'] = $this->model_tool_seo_url->rewrite($this->url->http('news/tintuc'));
		
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

		$this->id = 'header';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}
		
    	$this->render();
	}
}
?>
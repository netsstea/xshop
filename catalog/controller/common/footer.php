<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		$this->load->model('tool/seo_url');
		$this->load->helper('image');

		if(isset($this->request->get['route'])){
			$this->data['home_select'] = 0;
		} else {
			$this->data['home_select'] = 1;
		}
		
		$this->data['logged'] = $this->customer->isLogged();
		
// information
		$this->load->model('catalog/information');
		$this->load->model('catalog/cinformation');
		$this->data['cinformations'] = array();
		
		foreach ($this->model_catalog_cinformation->getcinformations('footer',2) as $cinformation_info) {
			$informations = array();
			foreach ($this->model_catalog_information->getinformationbycinformation($cinformation_info['cinformation_id'],8) as $result) {
				$informations[] = array(
					'name' 	   => $result['name'],
					'link' => $result['link'],
					'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
				);
			}
			$this->data['cinformations'][] = array(
				'name' 			 => $cinformation_info['name'],
				'informations' 	 => $informations,
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('information/cinformation&cinformation_id=' . $cinformation_info['cinformation_id']))
			);
		}
		
//end information

//showroom
		$this->load->model('catalog/showroom');
		
		$this->data['showroorm_hcm'] = array();
		$this->data['showroorm_hn'] = array();
		
		foreach ($this->model_catalog_showroom->getshowroomsByZoneId(3776) as $showroom) {
			$this->data['showroorm_hn'][] = array(
				'name' 			 	 => $showroom['name'],
				'address' 			 => $showroom['address'],
				'hotline' 			 => $showroom['hotline'],
				'telephone' 		 => $showroom['telephone'],
				'fax' 			 	 => $showroom['fax'],
				'showroom_id' 		 => $showroom['showroom_id'],
				'showroom_href' 	 => $this->model_tool_seo_url->rewrite($this->url->http('information/showroom')) . '&showroom_id=' . $showroom['showroom_id']
			);
		}
		
		foreach ($this->model_catalog_showroom->getshowroomsByZoneId(3780) as $showroom) {
			$this->data['showroorm_hcm'][] = array(
				'name' 			 	 => $showroom['name'],
				'address' 			 => $showroom['address'],
				'hotline' 			 => $showroom['hotline'],
				'telephone' 		 => $showroom['telephone'],
				'fax' 			 	 => $showroom['fax'],
				'showroom_id' 		 => $showroom['showroom_id'],
				'showroom_href' 	 => $this->model_tool_seo_url->rewrite($this->url->http('information/showroom')) . '&showroom_id=' . $showroom['showroom_id']
			);
		}
//end showroom

		$this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), date('Y', time()),HTTP_SERVER,$this->config->get('config_store'),$this->language->get('text_arr'));
		$this->data['text_powered'] = $this->language->get('text_powered');
		$this->data['owner'] = $this->config->get('config_owner');
		$this->data['address'] = $this->config->get('config_address');
		$this->data['telephone'] = $this->config->get('config_telephone');
		$this->data['fax'] = $this->config->get('config_fax');
		$this->data['hotline'] = $this->config->get('config_hotline');
		$this->data['email'] = $this->config->get('config_email');
		
    	$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_emails'] = $this->language->get('text_emails');
		$this->data['text_hotline'] = $this->language->get('text_hotline');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
    	$this->data['text_fax'] = $this->language->get('text_fax');
		
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_gioithieu'] = $this->language->get('text_gioithieu');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_dangky'] = $this->language->get('text_dangky');
		$this->data['text_dangnhap'] = $this->language->get('text_dangnhap');
		
		$this->data['special'] = $this->model_tool_seo_url->rewrite($this->url->http('product/special'));
		$this->data['home'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
		$this->data['contact'] = $this->model_tool_seo_url->rewrite($this->url->http('information/contact'));
    	$this->data['sitemap'] = $this->model_tool_seo_url->rewrite($this->url->http('information/sitemap'));
		$this->data['gioithieu'] = $this->model_tool_seo_url->rewrite($this->url->http('information/about'));
		$this->data['tintuc'] = $this->model_tool_seo_url->rewrite($this->url->http('news/cnews'));
		$this->data['dangnhap'] = $this->model_tool_seo_url->rewrite($this->url->https('account/login'));
		$this->data['dangky'] = $this->model_tool_seo_url->rewrite($this->url->https('account/create'));
		$this->data['logged'] = $this->customer->isLogged();
		
		if (isset($this->request->server['HTTPS']) && ($this->request->server['HTTPS'] == 'on')) {
			$this->data['logo_footer'] = HTTPS_IMAGE . $this->config->get('config_logofooter');
		} else {
			$this->data['logo_footer'] = HTTP_IMAGE . $this->config->get('config_logofooter');
		}
		
		if (isset($this->request->server['HTTPS']) && ($this->request->server['HTTPS'] == 'on')) {
			$this->data['banner_footer'] = HTTPS_IMAGE . $this->config->get('config_banner_footer');
		} else {
			$this->data['banner_footer'] = HTTP_IMAGE . $this->config->get('config_banner_footer');
		}
		
		$this->data['link_banner_footer'] = $this->config->get('config_link_banner_footer');
		
		$this->id = 'footer';
		
		if ($this->config->get('footer_title')) {
			$this->data['footer_title'] = html_entity_decode($this->config->get('footer_title'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['footer_title'] = '';
		}
		
		if ($this->config->get('footer_status')) {
			$this->data['footer'] = html_entity_decode($this->config->get('footer_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['footer'] = '';
		}
		if ($this->config->get('hotkeyword_status')) {
			$this->data['hotkeyword'] = html_entity_decode($this->config->get('hotkeyword_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['hotkeyword'] = '';
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>
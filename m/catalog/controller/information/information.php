<?php 
class ControllerInformationInformation extends Controller {
	public function index() {  
    	$this->language->load('information/information');
		$this->load->model('tool/seo_url');
		$this->load->model('catalog/information');
		
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
		
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		
// dich vu info
		$this->data['dichvus'] = array();
		$dichvu_yes = false;
		foreach ($this->model_catalog_information->getInformationsSortOrder(101) as $result) {
			$this->data['dichvus'][] = array(
				'title' 	   => $result['title'],
				'information_id' => $result['information_id'],
				'lienketnhanh' => $result['lienketnhanh'],
				'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
			);
			if($information_id == $result['information_id']) {
				$dichvu_yes = true;
			}
		}
		$this->data['information_id'] = $information_id;
		$this->data['dichvu_yes'] = $dichvu_yes;
// end dich vu info
		
		$information_info = $this->model_catalog_information->getInformation($information_id);
   		
		if ($information_info) {

			if($information_info['title_seo']) {
				$this->document->title = $information_info['title_seo']; 
			} else {
				$this->document->title = $information_info['title']; 
			}
			$this->document->description = $information_info['meta_description'];
			$this->document->keywords = $information_info['keywords'];
			
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $this->request->get['information_id'])),
        		'text'      => $information_info['title'],
        		'separator' => $this->language->get('text_separator')
      		);		
						
      		$this->data['heading_title'] = $information_info['title'];
      		
      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['description'] = html_entity_decode($information_info['description']);
      		
			$this->data['continue'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/information.tpl';
			} else {
				$this->template = 'default/template/information/information.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer'
			);		
			
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
				
	  		$this->document->title = 'Dịch vụ';
			
      		$this->data['heading_title'] = 'Dịch vụ';
			
    	$this->language->load('information/information');
		$this->load->model('tool/seo_url');
		$this->load->model('catalog/information');
		
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

// dich vu info
		$this->data['dichvus'] = array();
		$dichvu_yes = false;
		foreach ($this->model_catalog_information->getInformationsSortOrder(101) as $result) {
			$this->data['dichvus'][] = array(
				'title' 	   => $result['title'],
				'information_id' => $result['information_id'],
				'lienketnhanh' => $result['lienketnhanh'],
				'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
			);
			if($information_id == $result['information_id']) {
				$dichvu_yes = true;
			}
		}
		$this->data['information_id'] = $information_id;
		$this->data['dichvu_yes'] = $dichvu_yes;
		
// end dich vu info

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/dichvu.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/dichvu.tpl';
			} else {
				$this->template = 'default/template/information/dichvu.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer'
			);
		
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}
  	}
}
?>
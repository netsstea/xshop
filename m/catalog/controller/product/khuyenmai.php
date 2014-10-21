<?php 
class ControllerProductkhuyenmai extends Controller { 	
	public function index() { 
    	$this->data['heading_title'] = 'Khuyến mãi';
		
		$this->data['description'] = html_entity_decode($this->config->get('khuyenmai_code'), ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/khuyenmai.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/khuyenmai.tpl';
		} else {
			$this->template = 'default/template/product/khuyenmai.tpl';
		}
	
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));			
  	}
}
?>
<?php  
class ControllerModuleLienKet extends Controller {

	protected function index() {
		$this->language->load('module/lienket');
		$this->load->model('tool/seo_url');
		if($this->config->get('lienket_title')) {
			$this->data['heading_title'] = html_entity_decode($this->config->get('lienket_title'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['heading_title'] = $this->language->get('heading_title');
		}
		
		$this->data['code'] = html_entity_decode($this->config->get('lienket_code'), ENT_QUOTES, 'UTF-8');
		
		$this->data['lienket_heading_title'] = $this->config->get('lienket_heading_title');
		
		$this->id = 'lienket';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/lienket.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/lienket.tpl';
		} else {
			$this->template = 'default/template/module/lienket.tpl';
		}
		
		$this->render();
	}

}
?>
<?php 
class ControllerInformationshowroom extends Controller {
	public function index() {
		$this->load->model('tool/seo_url');
		if (isset($this->request->get['showroom_id'])) {
			$showroom_id = $this->request->get['showroom_id'];
		} else {
			$showroom_id = 0;
		}
		$this->data['showroom_id'] = $showroom_id;
		
//showroom
		$this->load->model('catalog/showroom');
		
		$this->data['showroorms'] = array();
		
		foreach ($this->model_catalog_showroom->getshowrooms() as $showroom) {
			$this->data['showroorms'][] = array(
				'name' 			 	 => $showroom['name'],
				'address' 			 => $showroom['address'],
				'hotline' 			 => $showroom['hotline'],
				'telephone' 		 => $showroom['telephone'],
				'google_maps' 		 => $showroom['google_maps'],
				'fax' 			 	 => $showroom['fax'],
				'showroom_id' 		 => $showroom['showroom_id']
			);
		}
//end showroom
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/showroom.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/showroom.tpl';
		} else {
			$this->template = 'default/template/information/showroom.tpl';
		}
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
}
?>
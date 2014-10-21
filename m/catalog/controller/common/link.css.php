<?php  
class ControllerCommonLinkCss extends Controller {
	public function index() {
		header("Content-type: text/css");
		echo "/*  */";
		if ($this->config->get('background_status')) { 
			$this->data['background_status'] = 1;
		} else {
			$this->data['background_status'] = 0;
		}
		$this->data['background_image'] = HTTP_SERVER .'image/' . $this->config->get('config_background_image');
		$this->data['background_repeat'] = $this->config->get('config_background_repeat');
		$this->data['background_color'] = $this->config->get('config_background_color');
		$this->data['background_position'] = $this->config->get('config_background_position');
		$this->data['background_attachment'] = $this->config->get('config_background_attachment');
		$this->data['background_container_color'] = $this->config->get('config_background_container_color');
		
		$this->data['backgroundheader_image'] = HTTP_SERVER .'image/' . $this->config->get('config_backgroundheader_image');
		$this->data['backgroundheader_repeat'] = $this->config->get('config_backgroundheader_repeat');
		$this->data['backgroundheader_color'] = $this->config->get('config_backgroundheader_color');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/link.css.tpl')) {
			$this->template = $this->config->get('config_template') . '/stylesheet/link.css.tpl';
		} else {
			$this->template = 'default/stylesheet/link.css.tpl';
		}
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>
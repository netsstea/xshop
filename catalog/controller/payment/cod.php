<?php
class ControllerPaymentCod extends Controller {
	protected function index() {
		$this->load->model('tool/seo_url');
		
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['continue'] = $this->model_tool_seo_url->rewrite($this->url->https('checkout/success'));

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = $this->model_tool_seo_url->rewrite($this->url->https('checkout/payment'));
		} else {
			$this->data['back'] = $this->model_tool_seo_url->rewrite($this->url->https('checkout/guest_step_2'));
		}
		
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cod.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/cod.tpl';
		} else {
			$this->template = 'default/template/payment/cod.tpl';
		}	
		
		$this->render();
	}
	
	public function confirm() {
		$this->load->model('checkout/order');
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
	}
}
?>
<?php 
class ControllerCheckoutSuccess extends Controller { 
	public function index() {
		$this->load->model('tool/seo_url');
		if (isset($this->session->data['payment_method_id'])) {
			$payment_method_id = $this->session->data['payment_method_id'];
		} else {
			$payment_method_id = 'cod';
		}
		
		if (isset($this->session->data['order_id'])) {
			$order_id = $this->session->data['order_id'];
		} else {
			$order_id = false;
		}
		
		if (isset($this->request->get['payment'])) {
			$payment = $this->request->get['payment'];
		} else {
			$payment = false;
		}
		
		if (!isset($this->request->get['view']) && $payment != $order_id && $payment_method_id != 'cod') {
			$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('checkout/cart')));
		}
		
		if ((isset($this->session->data['order_id']) && $payment_method_id == 'cod') || (isset($this->session->data['order_id']) && $payment == $this->session->data['order_id'])) {
			$this->session->data['hassuccess'] = true;
			$this->cart->clear();
			unset($this->session->data['hascart']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['payment_method_id']);
		}
		
		
		if (isset($this->request->get['view'])) {
			$this->data['view'] = $this->request->get['view'];
		} else {
			$this->data['view'] = false;
		}
		$this->language->load('checkout/cart');
		$this->data['column_remove'] = $this->language->get('column_remove');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');
		
		$this->load->helper('image');
		
		$this->data['products'] = array();

		foreach ($this->cart->getProducts() as $result) {
			$option_data = array();

			foreach ($result['option'] as $option) {
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => $option['value']
				);
			}

			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}

			$this->data['products'][] = array(
				'key'      => $result['key'],
				'name'     => $result['name'],
				'model'    => $result['model'],
				'thumb'    => image_resize($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')),
				'option'   => $option_data,
				'quantity' => $result['quantity'],
				'stock'    => $result['stock'],
				'price'    => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
				'total'    => $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))),
				'href'     => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
			);
		}
		
		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged() && $this->customer->getCustomerGroupVip()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
		
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		 
		$this->load->model('checkout/extension');
		
		$sort_order = array(); 
		
		$results = $this->model_checkout_extension->getExtensions('total');
		
		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
		}
		
		array_multisort($sort_order, SORT_ASC, $results);
		
		foreach ($results as $result) {
			$this->load->model('total/' . $result['key']);

			$this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
		}
		
		$sort_order = array(); 
	  
		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);

		$this->data['totals'] = $total_data;
									   
		$this->language->load('checkout/success');
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->document->breadcrumbs = array(); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

		
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('checkout/cart')),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('checkout/success')),
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = sprintf($this->language->get('text_message'), $this->model_tool_seo_url->rewrite($this->url->https('account/account')), $this->model_tool_seo_url->rewrite($this->url->https('account/history')), $this->model_tool_seo_url->rewrite($this->url->http('information/contact')));

    	$this->data['button_yes'] = $this->language->get('button_yes');

    	$this->data['continue'] = $this->model_tool_seo_url->rewrite($this->url->http('common/home'));
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		$this->data['payment_method_id'] = $payment_method_id;
		
		$this->children = array(
			'common/header',
			'common/footer',
			'payment/' . $payment_method_id,
			'common/column_left',
			'common/column_right'
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/success.tpl';
		} else {
			$this->template = 'default/template/checkout/success.tpl';
		}
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
}
?>
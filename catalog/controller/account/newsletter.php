<?php 
class ControllerAccountNewsletter extends Controller {  
	public function index() {
		$this->load->model('tool/seo_url');
		
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->model_tool_seo_url->rewrite($this->url->https('account/newsletter'));
	  
	  		$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('account/login')));
    	} 
		
		$this->language->load('account/newsletter');
    	
		$this->document->title = $this->language->get('heading_title');
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('account/customer');
			
			$this->model_account_customer->editNewsletter($this->request->post['newsletter']);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('account/account')));
		}

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('account/account')),
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('account/newsletter')),
        	'text'      => $this->language->get('text_newsletter'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

    	$this->data['action'] = $this->model_tool_seo_url->rewrite($this->url->https('account/newsletter'));
		
		$this->data['newsletter'] = $this->customer->getNewsletter();
		
		$this->data['back'] = $this->model_tool_seo_url->rewrite($this->url->https('account/account'));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/newsletter.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/newsletter.tpl';
		} else {
			$this->template = 'default/template/account/newsletter.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));			
  	}
}
?>
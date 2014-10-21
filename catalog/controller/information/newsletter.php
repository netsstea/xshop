<?php 
class ControllerInformationNewsletter extends Controller {
	private $error = array();
	      
  	public function index() {
		$this->load->model('tool/seo_url');
		
		if ($this->customer->isLogged()) {
	  		$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('account/account')));
    	}
		
		$this->data['logged'] = $this->customer->isLogged();
		
		if (isset($this->request->get['view'])) {
			$this->data['view'] = $this->request->get['view'];
		} else {
			$this->data['view'] = false;
		}

    	$this->language->load('information/newsletter');
		
		$this->load->model('account/newsletter');
		
		$this->data['success'] = $this->language->get('text_success');
		
		if(isset($this->session->data['newsletter_success'])) {
			$this->data['newsletter_success'] = true;
		} else {
			$this->data['newsletter_success'] = false;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/newsletter.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/newsletter.tpl';
		} else {
			$this->template = 'default/template/information/newsletter.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
  	}
	
	public function createnewsletter() {
		$json = array();
		
		$this->load->model('tool/seo_url');
		
		if ($this->customer->isLogged()) {
	  		$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('account/newsletter')));
    	}

    	$this->language->load('information/newsletter');

		$this->load->model('account/newsletter');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_account_newsletter->addNewsletter($this->request->post);
			
			$json['success'] = $this->language->get('text_success');
			
			$this->session->data['newsletter_success'] = true;
			
/*			$this->language->load('mail/account_create');
			
			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_store'));
			
			$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_store')) . "\n\n";
			
			if (!$this->config->get('config_customer_approval')) {
				$message .= $this->language->get('text_login') . "\n";
			} else {
				$message .= $this->language->get('text_approval') . "\n";
			}
			
			$message .= $this->model_tool_seo_url->rewrite($this->url->https('account/login')) . "\n\n";
			$message .= $this->language->get('text_services') . "\n\n";
			$message .= $this->language->get('text_thanks') . "\n";
			$message .= $this->config->get('config_store');
			
			$mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password')), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
			$mail->setTo($this->request->post['email']);
	  		$mail->setFrom($this->config->get('config_email'));
	  		$mail->setSender($this->config->get('config_store'));
	  		$mail->setSubject($subject);
			$mail->setText($message);
      		$mail->send(); */
		} else {
			unset($this->session->data['newsletter_success']);
			$json['error'] = $this->error;
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
  	private function validate() {
    	if (!$this->request->post['gender']) {
      		$this->error['gender'] =  array($this->language->get('error_gender'));
    	}

    	if ($this->model_account_newsletter->getTotalNewslettersByEmail($this->request->post['email'])) {
      		$this->error['email'] =  array($this->language->get('error_exists'));
    	}
		
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

    	if (!preg_match($pattern, $this->request->post['email'])) {
      		$this->error['email'] =  array($this->language->get('error_email'));
    	}

    	if (!$this->error) {
      		return TRUE;
    	} else {
      		return FALSE;
    	}
  	}  
}
?>
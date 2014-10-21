<?php
class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('tool/seo_url');
		
		if ($this->customer->isLogged()) {
			$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('account/forgotten')));
		}

		$this->language->load('account/forgotten');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->language->load('mail/account_forgotten');
			
			$password = substr(md5(rand()), 0, 7);
			
			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_store'));
			
			$message  = sprintf($this->language->get('text_greeting'), $this->config->get('config_store')) . "\n\n";
			$message .= $this->language->get('text_password') . "\n\n";
			$message .= $password;
			
			$mail = new PHPMailer();
			$mail->IsSMTP(); // set mailer to use SMTP
			$mail->Host = $this->config->get('config_smtp_host'); // specify main and backup server
			$mail->Port = $this->config->get('config_smtp_port'); // set the port to use
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->SMTPSecure = 'ssl';
			$mail->Username = $this->config->get('config_smtp_username'); // your SMTP username or your gmail username
			$mail->Password = html_entity_decode($this->config->get('config_smtp_password')); // your SMTP password or your gmail password

			$Name = html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8');
			$mail->Sender = $this->config->get('config_email');
			$mail->FromName = $Name; // Name to indicate where the email came from when the recepient received
			$mail->AddAddress($this->request->post['email']);
			$mail->AddReplyTo($this->config->get('config_email'),$Name);
			$mail->WordWrap = 50; // set word wrap
			$mail->IsHTML(true); // send as HTML
			$mail->Subject = $subject;
			$mail->Body = $message; //HTML Body
			$mail->AltBody = sprintf($this->language->get('text_subject'), $Name); //Text Body
			$mail-> CharSet  = 'utf-8';
			$mail->send();
			
			$this->model_account_customer->editPassword($this->request->post['email'], $password);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->model_tool_seo_url->rewrite($this->url->https('account/login')));
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
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('account/forgotten')),
        	'text'      => $this->language->get('text_forgotten'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_email'] = $this->language->get('text_your_email');
		$this->data['text_email'] = $this->language->get('text_email');

		$this->data['entry_email'] = $this->language->get('entry_email');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['message'])) {
			$this->data['error'] = $this->error['message'];
		} else {
			$this->data['error'] = '';
		}
		
		$this->data['action'] = $this->model_tool_seo_url->rewrite($this->url->https('account/forgotten'));
 
		$this->data['back'] = $this->model_tool_seo_url->rewrite($this->url->https('account/account'));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/forgotten.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/forgotten.tpl';
		} else {
			$this->template = 'default/template/account/forgotten.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
	}

	private function validate() {
		if (!isset($this->request->post['email'])) {
			$this->error['message'] = $this->language->get('error_email');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['message'] = $this->language->get('error_email');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
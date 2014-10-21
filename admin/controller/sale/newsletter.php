<?php    
class ControllerSalenewsletter extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('sale/newsletter');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newsletter');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('sale/newsletter');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newsletter');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      	  	$this->model_sale_newsletter->addNewsletter($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
		  
			$url = '';
			
			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
							
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('sale/newsletter' . $url));
		}
    	
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('sale/newsletter');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newsletter');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_newsletter->editNewsletter($this->request->get['newsletter_id'], $this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('sale/newsletter' . $url));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('sale/newsletter');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('sale/newsletter');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $newsletter_id) {
				$this->model_sale_newsletter->deleteNewsletter($newsletter_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('sale/newsletter' . $url));
    	}
    
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		}

		if (isset($this->request->get['filter_gender'])) {
			$filter_gender = $this->request->get['filter_gender'];
		} else {
			$filter_gender = NULL;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}		
		
		$url = '';

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('sale/newsletter' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('sale/newsletter/insert' . $url);
		$this->data['delete'] = $this->url->https('sale/newsletter/delete' . $url);

		$this->data['newsletters'] = array();

		$data = array(
			'filter_email'      => $filter_email, 
			'filter_gender'     => $filter_gender, 
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * 20,
			'limit'             => 20
		);
		
		$newsletter_total = $this->model_sale_newsletter->getTotalnewsletters($data);
	
		$results = $this->model_sale_newsletter->getNewsletters($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('sale/newsletter/update&newsletter_id=' . $result['newsletter_id'] . $url)
			);
			
			$this->data['newsletters'][] = array(
				'newsletter_id' => $result['newsletter_id'],
				'gender'        => $result['gender'],
				'email'       => $result['email'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'    => isset($this->request->post['selected']) && in_array($result['newsletter_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_gender'] = $this->language->get('column_gender');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_email'] = $this->url->https('sale/newsletter&sort=email' . $url);
		$this->data['sort_gender'] = $this->url->https('sale/newsletter&sort=gender' . $url);
		$this->data['sort_date_added'] = $this->url->https('sale/newsletter&sort=date_added' . $url);
		
		$url = '';
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $newsletter_total;
		$pagination->page = $page;
		$pagination->limit = 20; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('sale/newsletter' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_email'] = $filter_email;
		$this->data['filter_gender'] = $filter_gender;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/newsletter_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
  
  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');

    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_newsletter_group'] = $this->language->get('entry_newsletter_group');
		$this->data['entry_status'] = $this->language->get('entry_status');
    	
		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
	
		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['gender'])) {
			$this->data['error_gender'] = $this->error['gender'];
		} else {
			$this->data['error_gender'] = '';
		}

 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		    
		$url = '';
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('sale/newsletter' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['newsletter_id'])) {
			$this->data['action'] = $this->url->https('sale/newsletter/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('sale/newsletter/update&newsletter_id=' . $this->request->get['newsletter_id'] . $url);
		}
		  
    	$this->data['cancel'] = $this->url->https('sale/newsletter' . $url);

    	if (isset($this->request->get['newsletter_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$newsletter_info = $this->model_sale_newsletter->getnewsletter($this->request->get['newsletter_id']);
    	}

    	if (isset($this->request->post['email'])) {
      		$this->data['email'] = $this->request->post['email'];
    	} elseif (isset($newsletter_info)) { 
			$this->data['email'] = $newsletter_info['email'];
		} else {
      		$this->data['email'] = '';
    	}

    	if (isset($this->request->post['gender'])) {
      		$this->data['gender'] = $this->request->post['gender'];
    	} elseif (isset($newsletter_info)) { 
			$this->data['gender'] = $newsletter_info['gender'];
		} else {
      		$this->data['gender'] = '';
    	}
		
		$this->template = 'sale/newsletter_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}  
	 
	public function activate() {
		$this->load->language('sale/newsletter');
		$this->load->language('mail/newsletter');
    	
		if (!$this->user->hasPermission('modify', 'sale/newsletter')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['newsletter_id'])) {
				$this->load->model('sale/newsletter');			
			
				$newsletter_info = $this->model_sale_newsletter->getnewsletter($this->request->get['newsletter_id']);
		
				if (($newsletter_info) && (!$newsletter_info['status'])) {
					$this->model_sale_newsletter->activate($this->request->get['newsletter_id']);
			
					$message  = sprintf($this->language->get('text_welcome'), $this->config->get('config_store')) . "\n\n";;
					$message .= $this->language->get('text_login') . "\n";
					$message .= HTTP_CATALOG . 'index.php?route=account/login' . "\n\n";
					$message .= $this->language->get('text_services') . "\n\n";
					$message .= $this->language->get('text_thanks') . "\n";
					$message .= $this->config->get('config_store');
			
					$mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password')), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
					$mail->setTo($newsletter_info['email']);
					$mail->setFrom($this->config->get('config_email'));
	    			$mail->setSender($this->config->get('config_store'));
	    			$mail->setSubject(sprintf($this->language->get('text_subject'), $this->config->get('config_store')));
					$mail->setText($message);
	    			$mail->send();
				
					$this->session->data['success'] = sprintf($this->language->get('text_activated'), $newsletter_info['firstname'] . ' ' . $newsletter_info['lastname']);
				}
			}			
		}
		
		$url = '';
	
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
	
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}
	
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
					
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}		

		$this->redirect($this->url->http('sale/newsletter' . $url));
	} 
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/newsletter')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if (!$this->request->post['gender']) {
      		$this->error['gender'] = $this->language->get('error_gender');
    	}

		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';
    	
		if ((strlen(utf8_decode($this->request->post['email'])) > 32) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/newsletter')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
	  	 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	} 	
}
?>

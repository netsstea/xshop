<?php    
class ControllerCatalogredirecturl extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('catalog/redirect_url');
		
		$this->document->title = $this->language->get('heading_title');
		 
		$this->load->model('catalog/redirect_url');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('catalog/redirect_url');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/redirect_url');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_redirect_url->addredirect_url($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/redirect_url' . $url));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('catalog/redirect_url');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/redirect_url');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_redirect_url->editredirect_url($this->request->get['redirect_url_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/redirect_url' . $url));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('catalog/redirect_url');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/redirect_url');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $redirect_url_id) {
				$this->model_catalog_redirect_url->deleteredirect_url($redirect_url_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/redirect_url' . $url));
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
			$sort = 'redirect_url_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		$url = '';
			
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
       		'href'      => $this->url->https('catalog/redirect_url' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('catalog/redirect_url/insert' . $url);
		$this->data['delete'] = $this->url->https('catalog/redirect_url/delete' . $url);	

		$this->data['redirect_urls'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$redirect_url_total = $this->model_catalog_redirect_url->getTotalredirect_urls();
	
		$results = $this->model_catalog_redirect_url->getredirect_urls($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/redirect_url/update&redirect_url_id=' . $result['redirect_url_id'] . $url)
			);
						
			$this->data['redirect_urls'][] = array(
				'redirect_url_id' 		  => $result['redirect_url_id'],
				'url_goc'            => $result['url_goc'],
				'url_dich'      	  => $result['url_dich'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['redirect_url_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
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

		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_url_goc'] = $this->url->https('catalog/redirect_url&sort=url_goc' . $url);
		$this->data['sort_url_dich'] = $this->url->https('catalog/redirect_url&sort=url_dich' . $url);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $redirect_url_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/redirect_url' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'catalog/redirect_url_list.tpl';
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
    	$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_code'] = $this->language->get('entry_code');
  
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
	  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/redirect_url'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		    
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
							
		if (!isset($this->request->get['redirect_url_id'])) {
			$this->data['action'] = $this->url->https('catalog/redirect_url/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('catalog/redirect_url/update&redirect_url_id=' . $this->request->get['redirect_url_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/redirect_url' . $url);

    	if (isset($this->request->get['redirect_url_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$redirect_url_info = $this->model_catalog_redirect_url->getredirect_url($this->request->get['redirect_url_id']);
    	}

    	if (isset($this->request->post['url_goc'])) {
      		$this->data['url_goc'] = $this->request->post['url_goc'];
    	} elseif (isset($redirect_url_info)) {
			$this->data['url_goc'] = $redirect_url_info['url_goc'];
		} else {	
      		$this->data['url_goc'] = '';
    	}
		
		if (isset($this->request->post['url_dich'])) {
      		$this->data['url_dich'] = $this->request->post['url_dich'];
    	} elseif (isset($redirect_url_info)) {
			$this->data['url_dich'] = $redirect_url_info['url_dich'];
		} else {
      		$this->data['url_dich'] = '';
    	}
		
		$this->template = 'catalog/redirect_url_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/redirect_url')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/redirect_url')) {
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
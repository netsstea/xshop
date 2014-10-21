<?php    
class ControllerCatalogshowroom extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('catalog/showroom');
		
		$this->document->title = $this->language->get('heading_title');
		 
		$this->load->model('catalog/showroom');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('catalog/showroom');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/showroom');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_showroom->addshowroom($this->request->post);

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
			
			$this->redirect($this->url->https('catalog/showroom' . $url));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('catalog/showroom');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/showroom');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_showroom->editshowroom($this->request->get['showroom_id'], $this->request->post);

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
			
			$this->redirect($this->url->https('catalog/showroom' . $url));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('catalog/showroom');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/showroom');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $showroom_id) {
				$this->model_catalog_showroom->deleteshowroom($showroom_id);
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
			
			$this->redirect($this->url->https('catalog/showroom' . $url));
    	}
	
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/showroom' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('catalog/showroom/insert' . $url);
		$this->data['delete'] = $this->url->https('catalog/showroom/delete' . $url);	

		$this->data['showrooms'] = array();
		
		$showroom_total = $this->model_catalog_showroom->getTotalshowrooms();
	
		$results = $this->model_catalog_showroom->getshowrooms();
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/showroom/update&showroom_id=' . $result['showroom_id'] . $url)
			);
						
			$this->data['showrooms'][] = array(
				'showroom_id' 	  => $result['showroom_id'],
				'name'            => $result['name'],
				'address'      	  => $result['address'],
				'hotline'      	  => $result['hotline'],
				'telephone'       => $result['telephone'],
				'fax'      	  	  => $result['fax'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['showroom_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
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

		$pagination = new Pagination();
		$pagination->total = $showroom_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/showroom&page=%s');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'catalog/showroom_list.tpl';
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
  
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
	  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/showroom'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		    
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
							
		if (!isset($this->request->get['showroom_id'])) {
			$this->data['action'] = $this->url->https('catalog/showroom/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('catalog/showroom/update&showroom_id=' . $this->request->get['showroom_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/showroom' . $url);

    	if (isset($this->request->get['showroom_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$showroom_info = $this->model_catalog_showroom->getshowroom($this->request->get['showroom_id']);
    	}

    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (isset($showroom_info)) {
			$this->data['name'] = $showroom_info['name'];
		} else {	
      		$this->data['name'] = '';
    	}
		
		if (isset($this->request->post['address'])) {
      		$this->data['address'] = $this->request->post['address'];
    	} elseif (isset($showroom_info)) {
			$this->data['address'] = $showroom_info['address'];
		} else {
      		$this->data['address'] = '';
    	}
		
		if (isset($this->request->post['hotline'])) {
      		$this->data['hotline'] = $this->request->post['hotline'];
    	} elseif (isset($showroom_info)) {
			$this->data['hotline'] = $showroom_info['hotline'];
		} else {
      		$this->data['hotline'] = '';
    	}
		
		if (isset($this->request->post['telephone'])) {
      		$this->data['telephone'] = $this->request->post['telephone'];
    	} elseif (isset($showroom_info)) {
			$this->data['telephone'] = $showroom_info['telephone'];
		} else {
      		$this->data['telephone'] = '';
    	}
		
		if (isset($this->request->post['fax'])) {
      		$this->data['fax'] = $this->request->post['fax'];
    	} elseif (isset($showroom_info)) {
			$this->data['fax'] = $showroom_info['fax'];
		} else {
      		$this->data['fax'] = '';
    	}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($showroom_info)) {
			$this->data['sort_order'] = $showroom_info['sort_order'];
		} else {
      		$this->data['sort_order'] = 0;
    	}
		
		$this->load->model('localisation/zone');
		
		$this->data['zones'] = $this->model_localisation_zone->getZonesByCountryId(230);
		
		if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id'];
    	} elseif (isset($showroom_info)) {
			$this->data['zone_id'] = $showroom_info['zone_id'];
		} else {
      		$this->data['zone_id'] = 0;
    	}
		
		if (isset($this->request->post['google_maps'])) {
      		$this->data['google_maps'] = $this->request->post['google_maps'];
    	} elseif (isset($showroom_info)) {
			$this->data['google_maps'] = $showroom_info['google_maps'];
		} else {
      		$this->data['google_maps'] = '';
    	}
		
		$this->template = 'catalog/showroom_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/showroom')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/showroom')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	}	
		
		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $showroom_id) {
  			$product_total = $this->model_catalog_product->getTotalProductsByshowroomId($showroom_id);
    
			if ($product_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);	
			}	
	  	} 
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	}
}
?>
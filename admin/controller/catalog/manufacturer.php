<?php    
class ControllerCatalogmanufacturer extends Controller {
	private $error = array();
  
  	public function index() {
		$this->load->language('catalog/manufacturer');
		
		$this->document->title = $this->language->get('heading_title');
		 
		$this->load->model('catalog/manufacturer');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('catalog/manufacturer');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/manufacturer');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_manufacturer->addmanufacturer($this->request->post);

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
			
			$this->redirect($this->url->https('catalog/manufacturer' . $url));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('catalog/manufacturer');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/manufacturer');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_manufacturer->editmanufacturer($this->request->get['manufacturer_id'], $this->request->post);

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
			
			$this->redirect($this->url->https('catalog/manufacturer' . $url));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('catalog/manufacturer');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/manufacturer');
			
		$this->load->model('user/history');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
		
			$list = 'list';
			foreach ($this->request->post['selected'] as $manufacturer_id) {
				$this->model_catalog_manufacturer->deletemanufacturer($manufacturer_id);
				$list = $list . '_' . $manufacturer_id;
			}
			
			$this->model_user_history->addHistory('manufacturer_delete','manufacturer_id=' . $list);

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
			
			$this->redirect($this->url->https('catalog/manufacturer' . $url));
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
			$sort = 'cd.name';
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
       		'href'      => $this->url->https('catalog/manufacturer' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('catalog/manufacturer/insert' . $url);
		$this->data['delete'] = $this->url->https('catalog/manufacturer/delete' . $url);	

		$this->data['manufacturers'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 100,
			'limit' => 100
		);
		
		$manufacturer_total = $this->model_catalog_manufacturer->getTotalmanufacturers();
	
		$results = $this->model_catalog_manufacturer->getmanufacturers($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/manufacturer/update&manufacturer_id=' . $result['manufacturer_id'] . $url)
			);
						
			$this->data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['manufacturer_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
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
		
		$this->data['sort_name'] = $this->url->https('catalog/manufacturer&sort=md.name' . $url);
		$this->data['sort_sort_order'] = $this->url->https('catalog/manufacturer&sort=m.sort_order' . $url);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $manufacturer_total;
		$pagination->page = $page;
		$pagination->limit = 100; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/manufacturer' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'catalog/manufacturer_list.tpl';
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
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
  
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
       		'href'      => $this->url->https('catalog/manufacturer'),
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
							
		if (!isset($this->request->get['manufacturer_id'])) {
			$this->data['action'] = $this->url->https('catalog/manufacturer/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('catalog/manufacturer/update&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/manufacturer' . $url);

    	if (isset($this->request->get['manufacturer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$manufacturer_info = $this->model_catalog_manufacturer->getmanufacturer($this->request->get['manufacturer_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['manufacturer_description'])) {
			$this->data['manufacturer_description'] = $this->request->post['manufacturer_description'];
		} elseif (isset($this->request->get['manufacturer_id'])) {
			$this->data['manufacturer_description'] = $this->model_catalog_manufacturer->getmanufacturerDescriptions($this->request->get['manufacturer_id']);
		} else {
			$this->data['manufacturer_description'] = array();
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($manufacturer_info)) {
			$this->data['image'] = $manufacturer_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->helper('image');
		
		$this->data['no_image'] = image_resize('no_image.jpg', 100, 100);

		if (isset($manufacturer_info) && $manufacturer_info['image'] && file_exists(DIR_IMAGE . $manufacturer_info['image'])) {
			$this->data['preview'] = image_resize($manufacturer_info['image'], 100, 100);
		} else {
			$this->data['preview'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['banner'])) {
			$this->data['banner'] = $this->request->post['banner'];
		} elseif (isset($manufacturer_info)) {
			$this->data['banner'] = $manufacturer_info['banner'];
		} else {
			$this->data['banner'] = '';
		}

		if (isset($manufacturer_info) && $manufacturer_info['banner'] && file_exists(DIR_IMAGE . $manufacturer_info['banner'])) {
			$this->data['preview_banner'] = image_resize($manufacturer_info['banner'], 100, 100);
		} else {
			$this->data['preview_banner'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['icon_menu'])) {
			$this->data['icon_menu'] = $this->request->post['icon_menu'];
		} elseif (isset($manufacturer_info)) {
			$this->data['icon_menu'] = $manufacturer_info['icon_menu'];
		} else {
			$this->data['icon_menu'] = '';
		}

		if (isset($manufacturer_info) && $manufacturer_info['icon_menu'] && file_exists(DIR_IMAGE . $manufacturer_info['icon_menu'])) {
			$this->data['preview_icon_menu'] = image_resize($manufacturer_info['icon_menu'], 100, 100);
		} else {
			$this->data['preview_icon_menu'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($manufacturer_info)) {
			$this->data['sort_order'] = $manufacturer_info['sort_order'];
		} else {
      		$this->data['sort_order'] = '';
    	}
		
		if (isset($this->request->post['menu_status'])) {
      		$this->data['menu_status'] = $this->request->post['menu_status'];
    	} elseif (isset($manufacturer_info)) {
			$this->data['menu_status'] = $manufacturer_info['menu_status'];
		} else {
      		$this->data['menu_status'] = 0;
    	}
		
		$this->template = 'catalog/manufacturer_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/manufacturer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		foreach ($this->request->post['manufacturer_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	}
}
?>
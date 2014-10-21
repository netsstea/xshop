<?php
class ControllerCatalogattribute extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('catalog/attribute');

		$this->document->title = $this->language->get('heading_title');
		 
		$this->load->model('catalog/attribute');

		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/attribute');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/attribute');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_attribute->addattribute($this->request->post);
			
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
			
			$this->redirect($this->url->https('catalog/attribute' . $url));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/attribute');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/attribute');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_attribute->editattribute($this->request->get['attribute_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->https('catalog/attribute' . $url));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('catalog/attribute');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/attribute');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attribute_id) {
				$this->model_catalog_attribute->deleteattribute($attribute_id);
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
			
			$this->redirect($this->url->https('catalog/attribute' . $url));
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
			$sort = 'a.attribute_group_id';
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
       		'href'      => $this->url->https('catalog/attribute' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('catalog/attribute/insert' . $url);
		$this->data['delete'] = $this->url->https('catalog/attribute/delete' . $url);	

		$this->data['attributes'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 100,
			'limit' => 100
		);
		
		$attribute_total = $this->model_catalog_attribute->getTotalattributes();
	
		$results = $this->model_catalog_attribute->getattributes($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/attribute/update&attribute_id=' . $result['attribute_id'] . $url)
			);
			
			$this->load->model('catalog/attribute_group');
			
			$attribute_group_info = $this->model_catalog_attribute_group->getattributegroup($result['attribute_group_id']);
			
			$attribute_group_name = '';
			
			if($attribute_group_info) {
				$attribute_group_name = $attribute_group_info['name'];
			}
						
			$this->data['attributes'][] = array(
				'attribute_id' => $result['attribute_id'],
				'name'      => $result['name'],
				'attribute_group_name'      => $attribute_group_name,
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['attribute_id'], $this->request->post['selected']),
				'action'     => $action
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
		
		$this->data['sort_name'] = $this->url->https('catalog/attribute&sort=a.name' . $url);
		$this->data['sort_sort_order'] = $this->url->https('catalog/attribute&sort=a.sort_order' . $url);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $attribute_total;
		$pagination->page = $page;
		$pagination->limit = 100; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/attribute' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'catalog/attribute_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_cattribute'] = $this->language->get('entry_cattribute');
		$this->data['entry_sdt'] = $this->language->get('entry_sdt');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['text_none'] = $this->language->get('text_none');
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
       		'href'      => $this->url->https('catalog/attribute'),
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
							
		if (!isset($this->request->get['attribute_id'])) {
			$this->data['action'] = $this->url->https('catalog/attribute/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('catalog/attribute/update&attribute_id=' . $this->request->get['attribute_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/attribute' . $url);

		if (isset($this->request->get['attribute_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$attribute_info = $this->model_catalog_attribute->getattribute($this->request->get['attribute_id']);
		}
		
		$this->load->model('catalog/attribute_group');
		
    	$this->data['attributegroups'] = $this->model_catalog_attribute_group->getattributegroups();

    	if (isset($this->request->post['attribute_group_id'])) {
      		$this->data['attribute_group_id'] = $this->request->post['attribute_group_id'];
		} elseif (isset($attribute_info)) {
			$this->data['attribute_group_id'] = $attribute_info['attribute_group_id'];
		} else {
      		$this->data['attribute_group_id'] = 0;
    	}
		
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($attribute_info)) {
			$this->data['name'] = $attribute_info['name'];
		} else {
			$this->data['name'] = '';
		}
		
		if (isset($this->request->post['text_default'])) {
			$this->data['text_default'] = $this->request->post['text_default'];
		} elseif (isset($attribute_info)) {
			$this->data['text_default'] = $attribute_info['text_default'];
		} else {
			$this->data['text_default'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($attribute_info)) {
			$this->data['sort_order'] = $attribute_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		$this->template = 'catalog/attribute_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 2) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
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
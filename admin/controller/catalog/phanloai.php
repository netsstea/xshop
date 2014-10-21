<?php 
class ControllerCatalogphanloai extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/phanloai');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/phanloai');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/phanloai');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/phanloai');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_phanloai->addphanloai($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/phanloai')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/phanloai');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/phanloai');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_phanloai->editphanloai($this->request->get['phanloai_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/phanloai'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/phanloai');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/phanloai');
		
		$this->load->model('user/history');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
		
			$list = 'list';
			
			foreach ($this->request->post['selected'] as $phanloai_id) {
				$this->model_catalog_phanloai->deletephanloai($phanloai_id);
				$list = $list . '_' . $phanloai_id;
			}
			
			$this->model_user_history->addHistory('phanloai_delete','phanloai_id=' . $list);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('catalog/phanloai'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/phanloai'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->https('catalog/phanloai/insert');
		$this->data['delete'] = $this->url->https('catalog/phanloai/delete');
		
		$this->data['phanloais'] = array();
		
		$results = $this->model_catalog_phanloai->getPhanloais(0);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/phanloai/update&phanloai_id=' . $result['phanloai_id'])
			);
					
			$this->data['phanloais'][] = array(
				'phanloai_id' => $result['phanloai_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['phanloai_id'], $this->request->post['selected']),
				'action'      => $action
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
		
		$this->template = 'catalog/phanloai_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_phanloai'] = $this->language->get('entry_phanloai');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
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
       		'href'      => $this->url->https('catalog/phanloai'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['phanloai_id'])) {
			$this->data['action'] = $this->url->https('catalog/phanloai/insert');
			$this->data['phanloai_id'] = 0;
		} else {
			$this->data['action'] = $this->url->https('catalog/phanloai/update&phanloai_id=' . $this->request->get['phanloai_id']);
			$this->data['phanloai_id'] = $this->request->get['phanloai_id'];
		}
		
		$this->data['cancel'] = $this->url->https('catalog/phanloai');

		if (isset($this->request->get['phanloai_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$phanloai_info = $this->model_catalog_phanloai->getphanloai($this->request->get['phanloai_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['phanloai_info'])) {
			$this->data['phanloai_info'] = $this->request->post['phanloai_info'];
		} elseif (isset($phanloai_info)) {
			$this->data['phanloai_info'] = $this->model_catalog_phanloai->getphanloaiss($this->request->get['phanloai_id']);
		} else {
			$this->data['phanloai_info'] = array();
		}
		
		$this->data['phanloais'] = $this->model_catalog_phanloai->getPhanloais(0);

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($phanloai_info)) {
			$this->data['parent_id'] = $phanloai_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($phanloai_info)) {
			$this->data['image'] = $phanloai_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->helper('image');

		if (isset($phanloai_info) && $phanloai_info['image'] && file_exists(DIR_IMAGE . $phanloai_info['image'])) {
			$this->data['preview'] = image_resize($phanloai_info['image'], 100, 100);
		} else {
			$this->data['preview'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($phanloai_info)) {
			$this->data['sort_order'] = $phanloai_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		$this->load->model('catalog/category');
		
		$this->data['categories'] = $this->model_catalog_category->getCategories1(0);
		
		if (isset($this->request->post['phanloai_category'])) {
			$this->data['phanloai_category'] = $this->request->post['phanloai_category'];
		} elseif (isset($phanloai_info)) {
			$this->data['phanloai_category'] = $this->model_catalog_phanloai->getPhanloaiCategories($this->request->get['phanloai_id']);
		} else {
			$this->data['phanloai_category'] = array();
		}
		
		$this->template = 'catalog/phanloai_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/phanloai')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['phanloai_info'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 64)) {
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
		if (!$this->user->hasPermission('modify', 'catalog/phanloai')) {
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
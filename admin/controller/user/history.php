<?php  
class ControllerUserHistory extends Controller {  
   
  	public function index() {

    	$this->document->title = 'Lịch sử thay đổi';
	
		$this->load->model('user/history');
		
    	$this->getList();
  	}
 
  	public function delete() {

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('user/history');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach ($this->request->post['selected'] as $history_id) {
				$this->model_user_history->deleteHistory($history_id);	
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
					
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->https('user/history' . $url));
    	}
	
    	$this->getList();
  	}

  	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
			$sort = 'history_id';
		
			$order = 'ASC';
	
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
       		'href'      => $this->url->https('user/history' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['delete'] = $this->url->https('user/history/delete' . $url);			
			
    	$this->data['historis'] = array();

		$data = array(
			'start' => ($page - 1) * 50,
			'limit' => 50
		);
		
		$generics = array (
			'product' 		=> 'Sản phẩm',
			'cinformation' 	=> 'Danh mục thông tin',
			'download' 		=> 'Download',
			'information' 	=> 'Thông tin',
			'manufacturer' 	=> 'Hãng sản xuất',
			'phanloai' 		=> 'Bộ lọc',
			'review' 		=> 'Nhận xét',
			'slideshow' 	=> 'Banner',
			'news' 			=> 'Tin tức',
			'cnews' 		=> 'Danh mục tin tức',
			'category' 		=> 'Danh mục sản phẩm'
		);
		
		$formats = array (
			'add' 			=> 'thêm',
			'edit' 			=> 'chỉnh sửa',
			'updateprice' 	=> 'cập nhật giá',
			'delete' 		=> 'Xoá'
		);
		
		$history_total = $this->model_user_history->getTotalHistoris();
		
		$results = $this->model_user_history->getHistoris($data);
    	
		foreach ($results as $result) {
		
			$generic = explode('_', $result['generic']);
			
			$model = current($generic);
			
			$gformat = end($generic);
			
			$datah = '';
			
			if($model == 'news' || $model == 'cnews') {
				
				$code_id = explode('=', $result['code']);
				
				$start_codes = current($code_id);
				
				$end_codes =  end($code_id);

				$codes = explode('_', $end_codes);
				
				if(current($codes) == 'list') {
					for($i = 1; $i < sizeof($codes); $i++) {
						$datah = $datah . '<a target="_blank" href="' . $this->url->https('news/' . $model . '/update&' .$start_codes . '=' . $codes[$i]) . '">' . $codes[$i] . '</a>, ';
						
					}
				} else {
					$datah = '<a target="_blank" href="' . $this->url->https('news/' . $model . '/update&' .$start_codes . '=' . $end_codes) . '">' . $end_codes . '</a>';
				}
			} else {
				$code_id = explode('=', $result['code']);
				
				$start_codes = current($code_id);
				
				$end_codes =  end($code_id);

				$codes = explode('_', $end_codes);
				
				if(current($codes) == 'list') {
					for($i = 1; $i < sizeof($codes); $i++) {
						$datah = $datah . '<a href="' . $this->url->https('catalog/' . $model . '/update&' .$start_codes . '=' . $codes[$i]) . '">' . $codes[$i] . '</a>, ';
						
					}
				} else {
					$datah = '<a href="' . $this->url->https('catalog/' . $model . '/update&' .$start_codes . '=' . $end_codes) . '">' . $end_codes . '</a>';
				}
			}
			
      		$this->data['historis'][] = array(
				'history_id' => $result['history_id'],
				'username'   => $result['username'],
				'generic'    => $generics[$model],
				'format'     => $formats[$gformat],
				'datah'      => $datah,
				'date_added' => date('h:iA d/m/Y',strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['history_id'], $this->request->post['selected'])
			);
		}	
 
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
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 50; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('user/history&page=%s');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'user/history_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}

  	private function validateDelete() { 
    	if (!$this->user->hasPermission('modify', 'user/history')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	} 
	  	  
    	if ($this->user->getUserGroupId() != 1) {
      		$this->error['warning'] = 'Bạn không có quyền xoá';  
    	}
		 
		if (!$this->error) {
	  		return TRUE;
		} else { 
	  		return FALSE;
		}
  	}
  
}
?>
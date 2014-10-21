<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		if(isset($this->request->get['_route_'])){
			$this->data['href_full'] = str_replace('http://m.','http://www.',HTTP_SERVER . $this->request->get['_route_']) . '&view=full';
		} else {
			$this->data['href_full'] = str_replace('http://m.','http://www.',$this->model_tool_seo_url->rewrite($this->url->http('common/home'))) . '&view=full';
		}
/* làm mobile		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['currency_code'])) {
      		$this->currency->set($this->request->post['currency_code']);

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('common/home')));
			}
   		}
*/
		$this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), date('Y', time()),$this->language->get('text_semer'),$this->language->get('text_arr'));
		$this->data['text_powered'] = $this->language->get('text_powered');
		$this->data['logo'] = HTTP_HOME . 'catalog/view/theme/default/image/logo_black.jpg';
		$this->data['icon_comp'] = HTTP_SERVER . 'catalog/view/theme/default/image/icon_computer.png';
		$this->data['home'] = HTTP_SERVER;
		
		if(!isset($this->request->get['route'])){
			$this->data['home_select'] = 1;
		} else {
			$this->data['home_select'] = 0;
			// danh muc
			$this->load->model('catalog/category');
			$this->data['cats'] = array();

			$results = $this->model_catalog_category->getCategories_menu(0);

			foreach ($results as $result) {
				$this->data['cats'][] = array(
					'name' => $result['name'],
					'category_id' => $result['category_id'],
					'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result['category_id']))
				);
			}
			// end danh muc

			// dich vu info
			$this->load->model('catalog/information');
			$this->data['dichvus'] = array();
			$i = 0;
			$this->data['dichvu'] = '';
			foreach ($this->model_catalog_information->getInformationsSortOrder(101) as $result) {
				$i ++;
				if($i == 1) {
					$this->data['dichvu'] = $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']));
				}
			}
			//

			// end dich vu info
			$this->data['tintuc'] = $this->model_tool_seo_url->rewrite($this->url->http('news/tintuc'));
		}
		
		$this->id = 'footer';
		
		if ($this->config->get('footer_title')) {
			$this->data['footer_title'] = html_entity_decode($this->config->get('footer_title'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['footer_title'] = '';
		}
		
		if ($this->config->get('footer_status')) {
			$this->data['footer'] = html_entity_decode($this->config->get('footer_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['footer'] = '';
		}
		if ($this->config->get('hotkeyword_status')) {
			$this->data['hotkeyword'] = html_entity_decode($this->config->get('hotkeyword_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['hotkeyword'] = '';
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>
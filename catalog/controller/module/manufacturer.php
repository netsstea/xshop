<?php  
class ControllerModuleManufacturer extends Controller {
	protected function index() {
		$this->language->load('module/manufacturer');
		$this->load->model('catalog/product');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_select'] = $this->language->get('text_select');
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}	
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.price';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['manufacturer_id'])) {
			$this->load->model('catalog/manufacturer');
			
			$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
	
			if ($manufacturer_info) {
				$this->data['manufacturer_name'] = $manufacturer_info['name'];
			}
		} else {
			$this->data['manufacturer_id'] = 0;
		}
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		$query = '';
		
		if (isset($this->request->get['plid'])) {
			$query .= '&plid=' . $this->request->get['plid'];
			$plid = $this->request->get['plid'];
		} else {
			$plid = 0;
		}
		
		if (isset($this->request->get['category_id']) && isset($this->request->get['manufacturer_id'])) {
			$this->data['category_href_all'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'])) . $url . $query;
		} else {
			$this->data['category_href_all'] = '';
		}
		
		$this->load->model('catalog/manufacturer');
		 
		$this->data['manufacturers'] = array();
		
		$results = $this->model_catalog_manufacturer->getManufacturers($category_id);
		
		foreach ($results as $result) {
		
			if($category_id) {
				$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id, $result['manufacturer_id'], $plid);
				
				$href = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_id . '&manufacturer_id=' . $result['manufacturer_id']));
			} else {
				$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($result['manufacturer_id'], $plid);
				
				$href = $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $result['manufacturer_id']));
			}

			if($product_total) {
				$this->data['manufacturers'][] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => $result['name'],
					'product_total'   => $product_total,
					'href'            => $href . $query
				);
			}
		}
		
		$this->id = 'manufacturer';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/manufacturer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/manufacturer.tpl';
		} else {
			$this->template = 'default/template/module/manufacturer.tpl';
		}
		
		$this->render(); 
	}
}
?>
<?php  
class ControllerModulephanloai extends Controller {
	protected function index() {
		$this->load->model('catalog/phanloai');
		$this->load->model('tool/seo_url');
		
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
			$manufacturer_id = $this->request->get['manufacturer_id'];
			$url_manu = '&manufacturer_id=' . $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
			$url_manu = '';
		}
		
		$query = '';
		
		if (isset($this->request->get['plid'])) {
			$query .= '&plid=' . $this->request->get['plid'];
			$plid = $this->request->get['plid'];
		} else {
			$plid = 0;
		}
		
		if (isset($this->request->get['category_id'])) {
			$this->data['phanloai_href_all'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $this->request->get['category_id'] . $url_manu)) . $url . $query;
		} else {
			$this->data['phanloai_href_all'] = '';
		}
		
		if (isset($this->request->get['plid'])) {
			$this->data['plid'] =  explode('_',$this->request->get['plid']);
		} else {
			$this->data['plid'] = array();
		}
		
		$this->data['phanloais'] = $this->getPhanloais(0);
												
		$this->id = 'phanloai';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/phanloai.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/phanloai.tpl';
		} else {
			$this->template = 'default/template/module/phanloai.tpl';
		}
		
		$this->render();
  	}
	
	private function getPhanloais($parent_id, $level = 0) {
		$level++;
		
		$this->load->model('catalog/product');
		
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
			$manufacturer_id = $this->request->get['manufacturer_id'];
			$url_manu = '&manufacturer_id=' . $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
			$url_manu = '';
		}
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		$plids = '';
		
		if (isset($this->request->get['plid'])) {
			$plids = $this->request->get['plid'];
		}
		
		$href = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_id . $url_manu)) . $url;
		
		$data = array();
		
		if (isset($this->request->get['category_id'])) {
			
			$results = $this->model_catalog_phanloai->getPhanloaisByCategoryId($parent_id, $this->request->get['category_id']);	

			foreach ($results as $result) {
				$plid = $plids;
				if($plid) {
					$plid .= '_' . $result['phanloai_id'];
				} else {
					$plid = $result['phanloai_id'];
				}
				if($level > 1) {
					$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id, $manufacturer_id, $plid);
					
					$children = $this->getPhanloais($result['phanloai_id'], $level);
					
					if($product_total) {
						$data[] = array(
							'phanloai_id' 	  => $result['phanloai_id'],
							'href'        	  => $href . '&plid=' . $plid,
							'children'		  => $children,
							'product_total'	  => $product_total,
							'name'        	  => $result['name']
						);
					}
				} else {
					$children = $this->getPhanloais($result['phanloai_id'], $level);
				
					$data[] = array(
						'phanloai_id' 	  => $result['phanloai_id'],
						'href'        	  => $href . '&plid=' . $plids,
						'children'		  => $children,
						'product_total'	  => 0,
						'name'        	  => $result['name']
					);
				}
			}
		}
		
		return $data;
	}		
}
?>
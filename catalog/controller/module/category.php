<?php  
class ControllerModuleCategory extends Controller {
	protected function index() {
		$this->language->load('module/category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
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
			$sort = 'p.viewed';
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
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		if (isset($this->document->path)) {
			$parts = explode('_', $this->document->path);
		} else {
			$parts = array();
		}
		
		if($this->getCategories($category_id)) {
			$this->data['category'] = $this->getCategories($category_id);
			$this->data['category_href_all'] = '';
			$cat_id = $category_id;
		} else {
			if(sizeof($parts)-2 <= 0) {
				$num_cat = 0;
			} else {
				$num_cat = sizeof($parts)-2;
			}
			$this->data['category'] = $this->getCategories($parts[$num_cat]);
			$this->data['category_href_all'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $parts[$num_cat] . $url_manu)) . $url . $query;
			
			$cat_id = $parts[$num_cat];
		}
		
		$category_info = $this->model_catalog_category->getCategory($category_id);
	
		if ($category_info) {			
			$this->data['category_name'] = $category_info['name'];
		}
		
		if(isset($parts[0])) {
			$category_start = $this->model_catalog_category->getCategory($parts[0]);
		
			if ($category_start) {
				$this->data['ct_href'] = $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $category_start['category_id']));
				
				$this->data['ct_name'] = $category_start['name'];
			}
		}
		$cat_info = $this->model_catalog_category->getCategories($cat_id);
		
		$this->data['numcat'] = sizeof($cat_info);

		$this->id = 'category';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category.tpl';
		} else {
			$this->template = 'default/template/module/category.tpl';
		}
		
		$this->render();
  	}
	
	protected function getCategories($parent_id) {
		$this->load->model('catalog/product');
		
		if (isset($this->document->path)) {
			$parts = explode('_', $this->document->path);
		} else {
			$parts = array();
		}
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}	
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.viewed';
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
		
		$output = '';
		
		$results = $this->model_catalog_category->getCategories($parent_id);

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		foreach ($results as $result) {
			$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($result['category_id'], $manufacturer_id, $plid);
			
			if($product_total) {
			
				if ($category_id == $result['category_id']) {
					$output .= '<li class="selected">';
				} else {
					$output .= '<li>';
				}
				
				$children = '';
				if (isset($this->request->get['manufacturer_id']) || isset($this->request->get['keyword'])) {
					$children = $this->getCategories($result['category_id']);
				} else {
					if (in_array($result['category_id'],$parts)) {
						$children = $this->getCategories($result['category_id']);
					}
				}
				
				$output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('product/category&category_id=' . $result['category_id'] . $url_manu)) . $url . $query . '">' . $result['name'] . '</a>';
				
				$output .= $children;
				
				$output .= '</li>';
			}
		}
		
		return $output;
	}		
}
?>
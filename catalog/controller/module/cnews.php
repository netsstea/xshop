<?php  
class ControllerModulecnews extends Controller {
	protected $cnews_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/cnews');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/cnews');
		$this->load->model('tool/seo_url');
		
		if (isset($this->request->get['cnews_id'])) {
			$this->path = explode('_', $this->request->get['cnews_id']);
			
			$this->cnews_id = end($this->path);
		}
		
		$this->data['cnews'] = $this->getCnewss(0);

//xem nhieu
		$results = $this->model_catalog_news->newstokey("n.viewed",0,10);
		$this->data['xemnhieu'] = array();

		foreach ($results as $result) {
			$first_img = '';
			if($result['image']) {
				$first_img = image_resizec($result['image'], 68,68);
			} else {
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $matches);
				if($matches [1]){
				$first_img = $matches [1] [0];
				} else {
				$first_img = "image/no_image.jpg";
				}
			}
			
			if($result['date_added'] != '0000-00-00 00:00:00') {
				$date_added = date('h:iA d/m/Y',strtotime($result['date_added']));
			} else {
				$date_added = '';
			}
			
			$this->data['xemnhieu'][] = array(
				'name' 		 => $result['name'],
				'image'      => $first_img,
				'date_added' => $date_added,
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
			);
		}
// end xem nhieu


// tin sidebar
		$this->data['cnewss'] = array();
		$newss = array();
		foreach ($this->model_catalog_cnews->getCnewsToCshow('sidebar',10) as $cnews_info) {
			$newss[$cnews_info['cnews_id']] = array();
			foreach ($this->model_catalog_news->getnewssbycnews($cnews_info['cnews_id'],0,10) as $result) {
				$first_img = '';
				if($result['image']) {
					$first_img = image_resize_height($result['image'], 68,68);
				} else {
					$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $matches);
					if($matches [1]){
					$first_img = $matches [1] [0];
					} else {
					$first_img = "image/no_image.jpg";
					}
				}
				
				if($result['date_added'] != '0000-00-00 00:00:00') {
					$date_added = date('h:iA d/m/Y',strtotime($result['date_added']));
				} else {
					$date_added = '';
				}
				$newss[$cnews_info['cnews_id']][] = array(
					'name' 	   => $result['name'],
					'image'      => $first_img,
					'date_added' => $date_added,
					'href' 	 	   => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
				);
			}
			$this->data['cnewss'][] = array(
				'name' 			 => $cnews_info['name'],
				'cnews_id' 	 	 => $cnews_info['cnews_id'],
				'newss' 	 	 => $newss[$cnews_info['cnews_id']],
				'href'  		 => $this->model_tool_seo_url->rewrite($this->url->http('news/cnews&cnews_id=' . $cnews_info['cnews_id']))
			);
		}
//end tin sidebar
												
		$this->id = 'cnews';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cnews.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cnews.tpl';
		} else {
			$this->template = 'default/template/module/cnews.tpl';
		}
		
		$this->render();
  	}
	
	protected function getCnewss($parent_id, $current_path = '', $level = 0) {
		$level++;
		$cnews_id = array_shift($this->path);
		
		$output = '';
		
		$results = $this->model_catalog_cnews->getCnewss($parent_id);
		
		if ($results) {
			if(!$current_path){
				$output .= '<ul id="catalog">';
			} else {
				if($level == 2) {
					$output .= '<div class="div_children"><ul class="children">';
				} else {
					$output .= '<ul>';
				}
			}
    	}
		$path_id = array();
		if (isset($this->document->path)) {
			$path_id = explode('_', $this->document->path);
		} else {
			$path_id[0] = '';
		}

		$i = 0;
		foreach ($results as $result) {
			$i++;
			$new_path = $result['cnews_id'];
			
			$children = '';
			
			if ($this->cnews_id == $result['cnews_id']) {
				$select = 'cnews select';
			} else {
				$select = 'cnews';
			}
			if ($path_id[0] == $result['cnews_id']) {
				$select = 'cnews select';
			}
			if($current_path) {
				if ($this->cnews_id == $result['cnews_id']) {
					$output .= '<li class="select">';
				} else {
					$output .= '<li>';
				}
			} else {
				if($i==1) {
					$output .= '<li id="cat_top" class="' . $select . '">';
				} else {
					$output .= '<li class="' . $select . '">';
				}
			}
					$children = $this->getCnewss($result['cnews_id'], $new_path, $level);
					$output .= '<a href="' . $this->model_tool_seo_url->rewrite($this->url->http('news/cnews&cnews_id=' . $result['cnews_id']))  . '">' . $result['name'] . '</a>';
			
        	$output .= $children;
        
        	$output .= '</li>'; 
		}
 
		if ($results) {
			if(!$current_path){
				$output .= '</ul>';
			} else {
				if($level == 2) {
					$output .= '</ul></div>';
				} else {
					$output .= '</ul>';
				}
			}
		}
		
		return $output;
	}		
}
?>
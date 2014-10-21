<?php 
class Controllernewsnews extends Controller {
	public function index() {  

    	$this->language->load('news/news');
		$this->load->model('catalog/news');
		$this->load->model('catalog/cnews');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/substr');
		$this->load->helper('image');
		
		$this->document->breadcrumbs = array();
	
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->model_tool_seo_url->rewrite($this->url->http('common/home')),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
   		$this->document->breadcrumbs[] = array(
      		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('news/cnews')),
       		'text'      => $this->language->get('text_news'),
       		'separator' => $this->language->get('text_separator')
   		);
		
		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}

		$news_info = $this->model_catalog_news->getnews($news_id);
   		
		if ($news_info) {
			$url_seo = $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $this->request->get['news_id']));
			if($this->config->get('config_seo_url')) {
				if(isset($this->request->get['_route_'])){
					if ($url_seo != (HTTP_SERVER . $this->request->get['_route_'])){
						$this->redirect($url_seo);
					}
				} else {
					$this->redirect($url_seo);
				}
			}
			
			$this->model_catalog_news->updateViewed($this->request->get['news_id']);
			
			if($news_info['cnews_id']) {
				$cnews_id = $news_info['cnews_id'];
			} else {
				$cnews_id = $this->model_catalog_news->getCnewsIdByNewsId($this->request->get['news_id']);
			}
			
			if($news_info['image']) {
				$this->document->image = image_resize_fix($news_info['image'], 170, 150);
			}
			
			$cnews = $this->model_catalog_cnews->getCnews($cnews_id);
			if($cnews) {
			$path = $cnews_id;
				while ($cnews['parent_id'] != 0) {
					$path = $cnews['parent_id'] . '_' . $path;
					$cnews = $this->model_catalog_cnews->getCnews($cnews['parent_id']);
				}
				$parts = explode('_', $path);
				foreach ($parts as $part) {
				
					$cnews = $this->model_catalog_cnews->getCnews($part);
					
					$this->document->breadcrumbs[] = array(
						'href'      => $this->model_tool_seo_url->rewrite($this->url->http('product/cnews&cnews_id=' . $part)),
						'text'      => $cnews['name'],
						'separator' => $this->language->get('text_separator')
					);
				}
			}
			
	  		$this->document->title = html_entity_decode($news_info['name'], ENT_QUOTES, 'UTF-8'); 

			$this->document->description = str_replace(array("\t", "\n",'"'),'',$this->model_tool_substr->substr(strip_tags(html_entity_decode($news_info['description'], ENT_QUOTES, 'UTF-8')),290,3));

      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $this->request->get['news_id'])),
        		'text'      => $news_info['name'],
        		'separator' => $this->language->get('text_separator')
      		);		

      		$this->data['heading_title'] = $news_info['name'];
			
			$this->data['news_href'] = $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $this->request->get['news_id']));
      		
      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['description'] = html_entity_decode($news_info['description'], ENT_QUOTES, 'UTF-8');
			
			$this->data['news_id'] = $this->request->get['news_id'];
			if($news_info['date_added'] != '0000-00-00 00:00:00') {
				$this->data['date_added'] = date('d/m/Y h:iA',strtotime($news_info['date_added']));
      		} else {
				$this->data['date_added'] = '';
			}
			$this->data['continue'] = $this->url->http('href');
			
			$this->data['tags'] = array();
			if($news_info['tags']) {
				$tags = explode(',',html_entity_decode($news_info['tags'], ENT_QUOTES, 'UTF-8'));
				
				for ($i=0; $i<sizeof($tags); $i++) {
				$this->data['tags'][$i] = array(
					'tag' => trim($tags[$i]),
					'href' => $this->model_tool_seo_url->rewrite($this->url->http('news/tags&tags=' . $tags[$i]))
				);
				}
			}
			
// tin quan tam
		$results = $this->model_catalog_news->quantam(0,12);
		$this->data['quantams'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = image_resize($result['image'], 192, 192);
			} else {
				$first_img = '';
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $matches);
				if($matches [1]){
					$first_img = $matches [1] [0];
				} else {
					$first_img = "image/no_image.jpg";
				}
				$image = $first_img;
			}
			
			if($result['date_added'] != '0000-00-00 00:00:00') {
				$date_added = date('h:iA d/m/Y',strtotime($result['date_added']));
			} else {
				$date_added = '';
			}
			
			$this->data['quantams'][] = array(
				'name' 		 => $result['name'],
				'image'      => $image,
				'date_added' => $date_added,
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
			);
		}
// end tin quan tam

// tin lien quan

			$this->data['tinmois'] = array();
			$this->data['tinkhacs'] = array();

			$cnews_info = $this->model_catalog_cnews->getCnews($cnews_id);
	
			if ($cnews_info) {
				$this->data['cnews_name'] = $cnews_info['name'];
				$result0s = $this->model_catalog_news->getnewssbyCnewss($cnews_id);
				$i = 0;
				$j = 0;
				foreach ($result0s as $result) {
					if($news_id == $result['news_id']){$j = $i;}
					$i++;
				}
				if ($j <= 5) { $j = 5;}
				$result1s = $this->model_catalog_news->getNewssLienQuanByCnews($cnews_id,0,5);
				$result2s = $this->model_catalog_news->getNewssLienQuanByCnews($cnews_id,$j,10);

				foreach ($result1s as $result) {
					$this->data['tinmois'][] = array(
						'name'    => $result['name'],
						'date_added' => date('d/m/Y',strtotime($result['date_added'])),
						'href'    => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
					);
				}
				foreach ($result2s as $result) {
					$this->data['tinkhacs'][] = array(
						'name'    => $result['name'],
						'date_added' => date('d/m/Y',strtotime($result['date_added'])),
						'href'    => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
					);
				}
			}
// het tin lien quan
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/news.tpl';
			} else {
				$this->template = 'default/template/news/news.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'module/cnews',
				'common/column_left',
				'common/column_right'
			);		
			
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->url->http('news/news&news_id=' . $this->request->get['news_id']),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->title = $this->language->get('text_error');
			
      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->http('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
			);
		
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}

  	}
}
?>
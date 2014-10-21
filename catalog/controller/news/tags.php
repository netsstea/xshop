<?php 
class Controllernewstags extends Controller {
	public function index() {
		$this->load->model('tool/seo_url');  
		$this->load->model('tool/substr');
		$this->load->model('catalog/cnews');
		$this->load->model('catalog/news');
		$this->language->load('news/cnews');
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

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['tags'])) {
			$this->document->breadcrumbs[] = array(
				'href'      => $this->model_tool_seo_url->rewrite($this->url->http('news/tags' . $this->request->get['tags'])),
				'text'      => $this->request->get['tags'],
				'separator' => $this->language->get('text_separator')
			);
			
			if($this->model_catalog_news->gettotalnewstag($this->request->get['tags']) == 0) {
				$this->redirect($this->model_tool_seo_url->rewrite($this->url->http('news/cnews')));
			}
			
			$this->document->title = $this->request->get['tags'];
			
			$this->document->keywords = $this->request->get['tags'];
			
			$this->data['heading_title'] = $this->request->get['tags'];
			
//cnews		
		$this->load->model('catalog/cnews');
		$cnews = $this->model_catalog_cnews->getCnewss(0);
		$this->data['cnews'] = array();
		foreach ($cnews as $result) {
			$this->data['cnews'][] = array(
				'name'  => $result['name'],
				'cnews_id'  => $result['cnews_id'],
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/cnews&cnews_id=' . $result['cnews_id']))
			);
		}
//end news
			
			$results = $this->model_catalog_news->getnewsbytag($this->request->get['tags'], ($page - 1) * 10, 10);
			
			$this->data['newss'] = array();

				foreach ($results as $result) {
					if ($result['image']) {
						$image = image_resize($result['image'], 139, 139);
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
					
					$description = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
					
					$this->data['newss'][] = array(
						'name' => $result['name'],
						'date_added' => $date_added,
						'description' => $this->model_tool_substr->substr($description,490,3),
						'description_no_image' => $this->model_tool_substr->substr($description,1000,3),
						'image'     => $image,
						'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
					);
				}
		
			$pagination = new Pagination();
			$pagination->total = $this->model_catalog_news->gettotalnewstag($this->request->get['tags']);
			$pagination->page = $page;
			$pagination->limit = 10;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->model_tool_seo_url->rewrite($this->url->http('news/tags&tags=' .$this->request->get['tags'])) . '?page=%s';
		
			$this->data['pagination'] = $pagination->render();				
		}
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/tags.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/tags.tpl';
		} else {
			$this->template = 'default/template/news/tags.tpl';
		}	
		
		$this->children = array(
			'common/header',
			'common/footer',
			'module/cnews',
			'common/column_left',
			'common/column_right'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
  	}
}
?>
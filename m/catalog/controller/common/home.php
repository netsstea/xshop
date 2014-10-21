<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->language->load('common/home');
        $this->load->model('catalog/product');
        $this->load->model('catalog/review');
        $this->load->model('tool/seo_url');
		$this->load->helper('image');
	
		$this->document->title = $this->config->get('config_title');
		$this->document->description = $this->config->get('config_meta_description');
		
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_store'));
		
		$this->data['dichvu_url'] = $this->model_tool_seo_url->rewrite($this->url->http('information/information'));
		
//slide
        $this->load->model('catalog/traodoilogo');

        $this->data['toplefts'] = array();

        foreach ($this->model_catalog_traodoilogo->gettraodoilogos('top_left') as $result) {
            $this->data['toplefts'][] = array(
                'title' => $result['title'],
                'linkwebsite' => $result['linkwebsite'],
                'image' => image_resize_fix($result['image'], 495, 300)
            );
        }
		
        $this->data['bottomlefts'] = array();

        foreach ($this->model_catalog_traodoilogo->gettraodoilogos('bottom_left') as $result) {
            $this->data['bottomlefts'][] = array(
                'title' => $result['title'],
                'linkwebsite' => $result['linkwebsite'],
                'image' => 'image/' . $result['image']
            );
        }
		
        $this->data['bottomrights'] = array();

        foreach ($this->model_catalog_traodoilogo->gettraodoilogos('bottom_right') as $result) {
            $this->data['bottomrights'][] = array(
                'title' => $result['title'],
                'linkwebsite' => $result['linkwebsite'],
                'image' => 'image/' . $result['image']
            );
        }
//end slide
		
// danh muc
		$this->load->model('catalog/category');
		$this->data['categories'] = array();

		$results = $this->model_catalog_category->getCategories_menu(0);

		foreach ($results as $result) {
			if ($result['logo']) {
				$image = $result['logo'];
			} else {
				$image = 'no_image.jpg';
			}
			$this->data['categories'][] = array(
				'name' => $result['name'],
				'category_id' => $result['category_id'],
				'image' => image_resize($image, 60, 60),
				'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/category&path=' . $result['category_id']))
			);
		}
		$this->data['dichvu_image'] = image_resize('data/icon_mobile/icon_dichvu.png', 60, 60);
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
	
//cnews	
		$this->data['tintuc'] = $this->model_tool_seo_url->rewrite($this->url->http('news/tintuc'));
		$this->load->model('catalog/news');
	
		// tin tuc moi
		$newss_info = $this->model_catalog_news->tinmoinhat(10);
		$this->data['newss'] = array();
		foreach ($newss_info as $result) {
			$first_img = '';
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), $matches);
			if($matches [1]){
			$first_img = $matches [1] [0];
			} else {
			$first_img = "image/no_image.jpg";
			}
			
			$this->data['newss'][] = array(
				'title' 		 => $result['title'],
				'image'      => $first_img,
				'date_added' => date('h:iA d/m/Y',strtotime($result['date_added'])),
				'href'  => $this->model_tool_seo_url->rewrite($this->url->http('news/news&news_id=' . $result['news_id']))
			);
		}
//end news

// danh muc home
        $this->load->model('catalog/danhmuchome');

        $this->data['danhmuchomes'] = array();

        $danhmuchomes = $this->model_catalog_danhmuchome->getdanhmuchomes();

        foreach ($danhmuchomes as $danhmuchome) {

            $danhmuchome['products'] = array();

            foreach ($this->model_catalog_product->getProductsBydanhmuchomeId($danhmuchome['danhmuchome_id'], 0, 20) as $result) {
                if ($result['image']) {
                    $image = $result['image'];
                } else {
                    $image = 'no_image.jpg';
                }

                $rating = $this->model_catalog_review->getAverageRating($result['product_id']);

                $special = FALSE;

                $discount = $this->model_catalog_product->getProductDiscount($result['product_id']);

                if ($discount) {
                    $price = $this->currency->format($discount);
                } else {
                    $price = $this->currency->format($result['price']);

                    $special = $this->model_catalog_product->getProductSpecial($result['product_id']);

                    if ($special) {
                        $special = $this->currency->format($special);
                    }
                }
                if ($result['quantity'] <= 0) {
                    $stock = $result['stock'];
                } else {
                    if ($this->config->get('config_stock_display')) {
                        $stock = $result['quantity'];
                    } else {
                        $stock = $this->language->get('text_instock');
                    }
                }
                if ($result['price'] == 0) {
                    $price = "Liên hệ";
                }
                $danhmuchome['products'][] = array(
                    'name' => $result['name'],
                    'model' => $result['model'],
                    'baohanh' => $result['baohanh'],
					'product_id' => $result['product_id'],
					'manufacturer' => $result['manufacturer'],
                    'stock' => $stock,
                    'motangan' => html_entity_decode($result['motangan'], ENT_QUOTES, 'UTF-8'),
                    'khuyenmai' => html_entity_decode($result['khuyenmai'], ENT_QUOTES, 'UTF-8'),
                    'rating' => $rating,
                    'stars' => sprintf($this->language->get('text_stars'), $rating),
                    'thumb' => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                    'price' => $price,
                    'special' => $special,
                    'href' => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
                );
            }
            $this->data['danhmuchomes'][] = array(
                'danhmuchome_id' => $danhmuchome['danhmuchome_id'],
				'name' => $danhmuchome['name'],
                'banner' => $danhmuchome['banner'],
                'lienket' => $danhmuchome['lienket'],
                'products' => $danhmuchome['products']
            );
        }
// end danh muc home

        if (!$this->config->get('config_customer_price')) {
            $this->data['display_price'] = TRUE;
        } elseif ($this->customer->isLogged()) {
            $this->data['display_price'] = TRUE;
        } else {
            $this->data['display_price'] = FALSE;
        }
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>
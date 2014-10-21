<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		if (isset($this->request->get['_route_'])) {
			$parts = str_replace(HTTP_SERVER,'', $this->request->get['_route_']);
			

				if ($parts) {
					$url = explode('/', $parts);
					if(sizeof($url) == 1) {
					$url[1] ="";
					}
					if ($url[0] == 'san-pham' && strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['product_id'] = $url[1];
					}
					if ($url[0] == 'hang-san-xuat') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					if ($url[0] == 'search' && !$url[1]) {
						$this->request->get['search'] = 1;
					}
					if ($url[0] == 'search' && $url[1] == 'keyword' && sizeof($url)>=3) {
						$this->request->get['keyword'] = str_replace("-"," ",$url[2]);
					}
					if ($url[0] == 'news' && !$url[1]) {
						$this->request->get['news'] = 1;
					}
					if ($url[0] == 'san-pham' && !strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['path'] = str_replace('-','_',$url[1]);
					}
					if ($url[0] == 'san-pham' && !$url[1]) {
						$this->request->get['sanpham'] = 1;
					}
					if ($url[0] == 'news' && !strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['path_news'] = str_replace('-','_',$url[1]);
					}
					if ($url[0] == 'news' && strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['news_id'] = $url[1];
					}
					if ($url[0] == 'thong-tin') {
						$this->request->get['information_id'] = $url[1];
					}
					
					if ($url[0] == 'dich-vu') {
						$this->request->get['information'] = 'information/information';
					}
					
					if ($url[0] == 'phan-loai') {
						$this->request->get['phanloai_id'] = $url[1] . '_' . $url[2];
					}
					$product_files = glob(DIR_APPLICATION . 'controller/product/*.php');
					$product = array();
					foreach ($product_files as $file) {
					$product[] = basename($file, '.php');
					}
					if ($url[0] == 'product' && (in_array($url[1], $product))) {
						$this->request->get['product'] = $parts;
					}
				}
				
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			} elseif (isset($this->request->get['information'])) {
				$this->request->get['route'] = 'information/information';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer';
			} elseif (isset($this->request->get['search'])) {
				$this->request->get['route'] = 'product/search';
			} elseif (isset($this->request->get['keyword'])) {
				$this->request->get['route'] = 'product/search';
			} elseif (isset($this->request->get['product'])) {
				$this->request->get['route'] = $this->request->get['product'];
			} elseif (isset($this->request->get['sanpham'])) {
				$this->request->get['route'] = $this->request->get['sanpham'];
			} elseif (isset($this->request->get['account'])) {
				$this->request->get['route'] = $this->request->get['account'];
			} elseif (isset($this->request->get['information'])) {
				$this->request->get['route'] = $this->request->get['information'];
			} elseif (isset($this->request->get['checkout'])) {
				$this->request->get['route'] = $this->request->get['checkout'];
			} elseif (isset($this->request->get['news_id'])) {
				$this->request->get['route'] = 'news/news';
			} elseif (isset($this->request->get['news'])) {
				$this->request->get['route'] = 'news/tintuc';
			} elseif (isset($this->request->get['path_news'])) {
				$this->request->get['route'] = 'news/category_news';
			} elseif (isset($this->request->get['phanloai_id'])) {
				$this->request->get['route'] = 'product/phanloai'; 
			}
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}
}
?>
<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		if (isset($this->request->get['_route_'])) {
			$parts = str_replace(HTTP_SERVER,'', $this->request->get['_route_']);

				if ($parts) {
					$url = explode('/', $parts);
					if(sizeof($url) == 1) {
					$url[1] = "";
					}
					
					if (!in_array($url[0],array('info','tags','search','news','account','checkout')) && !is_numeric($url[0]) && strpos($parts,".html") && $url[0] != 'san-pham') {
					
						$url_name = str_replace('.html','',$this->db->escape($url[0]));
						
						$url_alias = explode('-', $url_name);

						$this->request->get['product_id'] = end($url_alias);
					}
					
					if (!in_array($url[0],array('info','tags','search','news','account','checkout')) && !is_numeric($url[0]) && !strpos($parts,".html")) {
					
						$url_data = explode('=',$this->checkUrl($url[0]));
						
						if($url_data[0] == 'category_id' && isset($url_data[1])) {
							$this->request->get['category_id'] = $url_data[1];
						}
						
						if($url_data[0] == 'manufacturer_id' && isset($url_data[1]) && $url_data[1]) {
							$this->request->get['manufacturer_id'] = $url_data[1];
						}
						
						if(isset($url[1]) && $url[1]) {
							$url_data = explode('=',$this->checkUrl($url[1]));
							
							if($url_data[0] == 'category_id' && isset($url_data[1]) && $url_data[1]) {
								$this->request->get['category_id'] = $url_data[1];
							}
							
							if($url_data[0] == 'manufacturer_id' && isset($url_data[1]) && $url_data[1]) {
								$this->request->get['manufacturer_id'] = $url_data[1];
							}
						}
					}
					
					if ($url[0] == 'news' && !strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['cnews_id'] = $url[1];
					}
					
					if ($url[0] == 'news' && strpos($url[sizeof($url)-1],".html") && $url[1]) {
						$this->request->get['news_id'] = $url[1];
					}
					
					if ($url[0] == 'info' && is_numeric($url[1])) {
						$this->request->get['information_id'] = $url[1];
					}
					
					if ($url[0] == 'search' && !$url[1]) {
						$this->request->get['search'] = 1;
					}
					
					if ($url[0] == 'search' && $url[1] == 'keyword' && sizeof($url)>=3) {
						$this->request->get['keyword'] = str_replace("+"," ",$url[2]);
					}
					
					$information_files = glob(DIR_APPLICATION . 'controller/information/*.php');
					$information = array();
					foreach ($information_files as $file) {
					$information[] = basename($file, '.php');
					}
					if ($url[0] == 'info' && (in_array($url[1], $information))) {
						$this->request->get['information'] = str_replace('info/','information/',$parts);
					}
					
					$account_files = glob(DIR_APPLICATION . 'controller/account/*.php');
					$account = array();
					foreach ($account_files as $file) {
					$account[] = basename($file, '.php');
					}
					if ($url[0] == 'account' && (in_array($url[1], $account))) {
						$this->request->get['account'] = $parts;
					}
					
					$checkout_files = glob(DIR_APPLICATION . 'controller/checkout/*.php');
					$checkout = array();
					foreach ($checkout_files as $file) {
					$checkout[] = basename($file, '.php');
					}
					if ($url[0] == 'checkout' && (in_array($url[1], $checkout))) {
						$this->request->get['checkout'] = $parts;
					}
					
					$product_files = glob(DIR_APPLICATION . 'controller/product/*.php');
					$product = array();
					foreach ($product_files as $file) {
					$product[] = basename($file, '.php');
					}
					if ($url[0] == 'product' && (in_array($url[1], $product))) {
						$this->request->get['product'] = $url[0] . '/' . $url[1];
					}
					
					if ($url[0] == 'news' && !$url[1]) {
						$this->request->get['news'] = 1;
					}
				}
				
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['category_id'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer';
			} elseif (isset($this->request->get['search'])) {
				$this->request->get['route'] = 'product/search';
			} elseif (isset($this->request->get['keyword'])) {
				$this->request->get['route'] = 'product/search';
			} elseif (isset($this->request->get['product'])) {
				$this->request->get['route'] = $this->request->get['product'];
			} elseif (isset($this->request->get['account'])) {
				$this->request->get['route'] = $this->request->get['account'];
			} elseif (isset($this->request->get['information'])) {
				$this->request->get['route'] = $this->request->get['information'];
			} elseif (isset($this->request->get['checkout'])) {
				$this->request->get['route'] = $this->request->get['checkout'];
			} elseif (isset($this->request->get['news_id'])) {
				$this->request->get['route'] = 'news/news';
			} elseif (isset($this->request->get['news'])) {
				$this->request->get['route'] = 'news/cnews';
			} elseif (isset($this->request->get['cnews_id'])) {
				$this->request->get['route'] = 'news/cnews';
			}
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}
	public function checkUrl($url){
		$data_url = '';
		
		$check_id = false;
		
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description");
		
		foreach ($query1->rows as $result) {
			if ($url == $this->khongdau($result['name'])) {
				$data_url = 'category_id=' . $result['category_id'];
				break;
			}
		}
		
		if(!$data_url) {
			$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_description");
			
			foreach ($query2->rows as $result) {
				if ($url == $this->khongdau($result['name'])) {
					$data_url = 'manufacturer_id=' . $result['manufacturer_id'];
					break;
				}
			}
			
			if(!$data_url) {
				$query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_manufacturer");
				
				foreach ($query3->rows as $result) {
					if ($url == $this->khongdau($result['ex_name'])) {
						$data_url = 'manufacturer_id=' . $result['manufacturer_id'];
						
						break;
					}
				}
			}
		}
		
		return $data_url;
	}
	
	public function khongdau($text){
		//global $ibforums;
		//Charachters must be in ASCII and certain ones aint allowed
		$text = html_entity_decode ($text, ENT_QUOTES, 'UTF-8');
		$text = preg_replace("/(ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $text);
		$text = str_replace("ç","c",$text);
		$text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $text);
		$text = preg_replace("/(ì|í|î|ị|ỉ|ĩ)/", 'i', $text);
		$text = preg_replace("/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $text);
		$text = preg_replace("/(ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $text);
		$text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $text);
		$text = preg_replace("/(đ)/", 'd', $text);
		//CHU HOA
		$text = preg_replace("/(Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $text);
		$text = str_replace("Ç","C",$text);
		$text = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $text);
		$text = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $text);
		$text = preg_replace("/(Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $text);
		$text = preg_replace("/(Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $text);
		$text = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $text);
		$text = preg_replace("/(Đ)/", 'D', $text);
		$text = preg_replace("/[^a-zA-Z0-9\-\_]/", ' ', $text);
		$text = str_replace("     ", ' ', $text);
		$text = str_replace("    ", ' ', $text);
		$text = str_replace("   ", ' ', $text);
		$text = str_replace("  ", ' ', $text);
		$text = str_replace(" - ", ' ', trim($text));
		$text = str_replace(" -", ' ', trim($text));
		$text = str_replace("- ", ' ', trim($text));
		$text = str_replace(" ", '-', trim($text));
		return strtolower($text);
	}
}
?>
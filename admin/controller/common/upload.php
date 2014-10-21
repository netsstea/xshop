<?php
class ControllerCommonupload extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('common/filemanager');
		
		$this->data['title'] = $this->language->get('heading_title');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}
		
		if ($this->user->isLogged()) {
			$this->data['user_group_id'] = $this->user->getUserGroupId();
		} else {
			$this->data['user_group_id'] = '';
		}
		
		$this->data['error_select'] = $this->language->get('error_select');
		$this->data['error_directory'] = $this->language->get('error_directory');
		
		if (isset($this->request->get['field'])) {
			$this->data['field'] = $this->request->get['field'];
		} else {
			$this->data['field'] = '';
		}
		
		if (isset($this->request->get['CKEditorFuncNum'])) {
			$this->data['fckeditor'] = $this->request->get['CKEditorFuncNum'];
		} else {
			$this->data['fckeditor'] = FALSE;
		}

		$this->data['http_image'] = HTTP_IMAGE . 'upload/data/';
		
		$this->template = 'common/upload.tpl';
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}	
	
	public function image() {
		$this->load->helper('image');
		
		if (isset($this->request->post['image'])) {
			$this->response->setOutput(image_resize($this->request->post['image'], 168, 168));
		}
	}
	
	public function directory() {
		$json = array();
		
		if (isset($this->request->post['directory'])) {
		
			
			
			$directories = glob(rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['directory']), '/') . '/*', GLOB_ONLYDIR); 
			
			if ($directories) {
				$i = 0;
			
				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = substr($directory, strlen(DIR_IMAGE . 'upload/data/'));
					
					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
					
					if ($children)  {
						$json[$i]['children'] = ' ';
					}
					
					$i++;
				}
			}		
		}

		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));		
	}
	
	public function files() {
		$json = array();
		
		$this->load->helper('image');
		unset($this->session->data['directory']);
		if (isset($this->request->post['directory']) && $this->request->post['directory']) {
		$this->session->data['directory'] = $this->request->post['directory'];
			$directory = DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['directory']);
		} else {
			$directory = DIR_IMAGE . 'upload/data/';
		}
		
		$files = glob(rtrim($directory, '/') . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
		
		foreach ($files as $file) {
			$size = filesize($file);

			$i = 0;

			$suffix = array(
				'B',
				'KB',
				'MB',
				'GB',
				'TB',
				'PB',
				'EB',
				'ZB',
				'YB'
			);

			while (($size / 1024) > 1) {
				$size = $size / 1024;
				$i++;
			}
				
			$json[] = array(
				'file'     => substr($file, strlen(DIR_IMAGE . 'upload/data/')),
				'filename' => basename($file),
				'size'     => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
				'thumb'    => image_resize(substr($file, strlen(DIR_IMAGE)), 168, 168)
			);
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));	
	}	
	
	public function create() {
		$this->load->language('common/filemanager');
				
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
					$json['error'] = $this->language->get('error_exists');
				}
			} else {
				$json['error'] = $this->language->get('error_name');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!isset($json['error'])) {
			mkdir($directory . '/' . $this->khongdau(str_replace('../', '', $this->request->post['name'])), 0777);
			
			$json['success'] = $this->language->get('text_create');
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function delete() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path'])) {
			$path = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['path']), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = $this->language->get('error_select');
			}
			
			if ($path == rtrim(DIR_IMAGE . 'upload/data/', '/')) {
				$json['error'] = $this->language->get('error_delete');
			}
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);;
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
			
			$json['success'] = $this->language->get('text_delete');
		}				
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return FALSE;
		}
		
		while ($file = readdir($handle)) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return TRUE;
	}

	public function move() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['from']), '/');
			
			if (!file_exists($from)) {
				$json['error'] = $this->language->get('error_missing');
			}
			
			if ($from == DIR_IMAGE . 'upload') {
				$json['error'] = $this->language->get('error_default');
			}
			
			$to = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['to']), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->language->get('error_move');
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = $this->language->get('error_exsits');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
			
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = $this->language->get('text_move');
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}	
	
	public function copy() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['path']), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'upload') {
				$json['error'] = $this->language->get('error_copy');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', $this->request->post['name'] . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = $this->language->get('text_copy');
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));	
	}

	function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) { 
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 

	public function folders() {
		$this->response->setOutput($this->recursiveFolders(DIR_IMAGE . 'upload/data/'));	
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		
		$output .= '<option value="' . substr($directory, strlen(DIR_IMAGE . 'upload/data/')) . '">' . substr($directory, strlen(DIR_IMAGE . 'upload/data/')) . '</option>';
		
		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
	
	public function rename() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['path']), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'upload') {
				$json['error'] = $this->language->get('error_rename');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', $this->request->post['name'] . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exsits');
			}			
		}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = $this->language->get('text_rename');
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function upload() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
				if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}
					
				$directory = rtrim(DIR_IMAGE . 'upload/data/' . str_replace('../', '', $this->request->post['directory']), '/');
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}
				
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'application/x-shockwave-flash'
				);
						
				if (!in_array($this->request->files['image']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
				}
				
				$allowed = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv'
				);
						
				if (!in_array(strtolower(strrchr($this->request->files['image']['name'], '.')), $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
				}
				
				if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $this->request->files['image']['error'];
				}			
			} else {
				$json['error'] = $this->language->get('error_file');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!isset($json['error'])) {	
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $this->khongdau(basename(strtolower($this->request->files['image']['name']))))) {		
				$json['success'] = $this->language->get('text_uploaded');
			} else {
				$json['error'] = $this->language->get('error_uploaded');
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function uploaddragdrop() {
		$this->load->language('common/filemanager');
		
		$json = array();


		$directory = DIR_IMAGE . 'upload/data/';
		
		if (isset($this->session->data['directory'])) {
			$directory = DIR_IMAGE . 'upload/data/' . $this->session->data['directory'] . '/';
		}
		
		if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
			
			$allowed = array(
				'.jpg',
				'.jpeg',
				'.gif',
				'.png',
				'.flv'
			);
					
			if (!in_array(strtolower(strrchr($this->request->files['image']['name'], '.')), $allowed)) {
				$json['status'] = $this->language->get('error_file_type');
			}
			
			if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
				$json['status'] = 'error_upload_' . $this->request->files['image']['error'];
			}			
		} else {
			$json['status'] = $this->language->get('error_file');
		}

		
		if (!isset($json['status'])) {	
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . $this->khongdau(basename(strtolower($this->request->files['image']['name']))))) {		
				$json['success'] = $this->khongdau(basename(strtolower($this->request->files['image']['name'])));
			} else {
				$json['status'] = $this->language->get('error_uploaded');
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
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
	$text = preg_replace("/[^a-zA-Z0-9\-\.\_]/", ' ', $text);
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
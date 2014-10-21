<?php
class ModelToolDownloadImage extends Model {
	public function downloadFile ($url, $path) {
		  $newfname = $path;
		  $file = fopen ($url, "rb");
		  if ($file) {
			$newf = fopen ($newfname, "wb");

			if ($newf)
			while(!feof($file)) {
			  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
			}
		  }

		  if ($file) {
			fclose($file);
		  }

		  if ($newf) {
			fclose($newf);
		  }
	}
	
	public function downloadImage ($description, $image_id, $path, $date_added = 0, $option = false) {
	
		$this->load->helper('image');
	
		if(!is_dir(DIR_IMAGE . 'upload/')) {
			mkdir(DIR_IMAGE . 'upload/'); 
		}
	
		$pathImage  = DIR_IMAGE . 'upload/' . $path . '/';
		
		if(!is_dir($pathImage)) {
			mkdir($pathImage); 
		}
		
		if($date_added) {
			$year = (int)(date('Y',strtotime($date_added)));
			$mon = (int)(date('m',strtotime($date_added)));
			$mday = (int)(date('d',strtotime($date_added)));
		} else {
			$now = getdate();
			$year = $now["year"];
			$mon = $now["mon"];
			$mday = $now["mday"];
		}
		
		$dirYear  = $pathImage . '/' . $year . '/';
		$dirMon   = $pathImage . '/' . $year . '/' . $mon . '/';
		$dirMday  = $pathImage . '/' . $year . '/' . $mon . '/' . $mday . '/';
		$dirNow   = $pathImage . $year . '/' . $mon . '/' . $mday . '/';
		if(!is_dir($dirYear)) {
			mkdir($dirYear); 
		}
		if(!is_dir($dirMon)) {
			mkdir($dirMon);
		}
		if(!is_dir($dirMday)) {
			mkdir($dirMday);
		}
	
		$dirImage  = $dirNow . $image_id . '/';
		
		$urlDirImage = 'upload/' . $path . '/' . $year . '/' . $mon . '/' . $mday . '/' . $image_id . '/';
		
		if(!is_dir($dirImage)) {
			mkdir($dirImage); 
		}
		
		$description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", $description);
		
		$dom = new DOMDocument('1.0', 'utf-8');
		
		@$dom->loadHTML(html_entity_decode($description));

		$xpath_query = "//img";
		$xpath = new DOMXPath($dom);
		$xpath_query_results = $xpath->query($xpath_query);
		$i = 0;
		foreach($xpath_query_results as $result) {
			$i++;
			
			$src = $result->getAttribute('src');
			
			$allowed = array(
				'.jpg',
				'.jpeg',
				'.gif',
				'.png'
			);
			
			$file_type = strtolower(strrchr($src, '.'));
			
			if (!in_array($file_type, $allowed)) {
			
				$file_type = '.jpg';	
			}
			
			if(!$option) {
				$name_option = 'img';
			} else {
				$name_option = $option;
			}
			
			$imageName = $image_id . '_' . $name_option . $i . $file_type;
			
			$checkurl = str_replace(HTTP_IMAGE,' dunglalinkdomain ',$src);
			
			if(!strpos($checkurl,'dunglalinkdomain')) {
				
				$url_image = $dirImage . $imageName;
		  
				$this->downloadFile ($src,$url_image);
				
				if(file_exists($url_image)) {
				
					$url_data = $urlDirImage . $imageName;
					
					$http_image = watermark($url_data);		
				
					$description = str_replace($src, $http_image, $description);
				}
			} else {
			
				$checkcache = str_replace(HTTP_IMAGE . 'cache/',' dunglalinkcache ',$src);
				
				if (strpos($checkcache,'dunglalinkcache')) {
				  if (!file_exists(DIR_IMAGE . str_replace(HTTP_IMAGE,DIR_IMAGE,$src))) {
				  
					$url_cache = str_replace(HTTP_IMAGE . 'cache/','',$src);
					
					if(file_exists(DIR_IMAGE . $url_cache)) {
					
						$http_image = watermark($url_cache);
						
						$description = str_replace($src, $http_image, $description);
					}
				  }
				} else {
				
					$url_data = str_replace(HTTP_IMAGE,'',$src);
					
					if(file_exists(DIR_IMAGE . $url_data)) {
					
						$http_image = watermark($url_data);
						
						$description = str_replace($src, $http_image, $description);
					}
				}
			}
		}
		return $description;
	}

	public function getUrlImage ($description) {
		$first_img = '';
		
		$dom = new DOMDocument('1.0', 'utf-8');
		
		@$dom->loadHTML(html_entity_decode($description));

		$xpath_query = "//img";
		$xpath = new DOMXPath($dom);
		$xpath_query_results = $xpath->query($xpath_query);
		
		foreach($xpath_query_results as $result) {
			
			$src = $result->getAttribute('src');
			
			$checkurl = str_replace(HTTP_IMAGE . 'cache/',' dunglalinkdomain ',$src);
			$url_data = str_replace(HTTP_IMAGE . 'cache/',DIR_IMAGE,$src);
			
			if(strpos($checkurl,'dunglalinkdomain') && file_exists($url_data)) {
				$first_img = str_replace(HTTP_IMAGE . 'cache/','',$src);
			}
		}
		
		return $first_img;
	}
}
?>
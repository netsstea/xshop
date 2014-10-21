<?php 
class ControllerCatalogProduct extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('catalog/product');
    	
		$this->document->title = $this->language->get('heading_title'); 
		
		$this->load->model('catalog/product');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('catalog/product');

    	$this->document->title = $this->language->get('heading_title'); 
		
		$this->load->model('catalog/product');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . $this->request->get['filter_model'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/product' . $url));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('catalog/product');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/product');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . $this->request->get['filter_model'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/product' . $url));
		}

    	$this->getForm();
  	}
// phân loại danh mục và giá model/product, catalog/product, product.tpl
    public function updateprice() {
       
        $this->load->model('catalog/product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_catalog_product->updateProPrice($this->request->post['ele_id'], $this->request->post['ele_val']);
        }

    }
	
    public function updateprice_hc() {
       
        $this->load->model('catalog/product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_catalog_product->updateProPriceHc($this->request->post['proid'], $this->request->post['price_hc_val']);
        }

    }
	
    public function updatepriceHistory() {
       
        $this->load->model('user/history');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_user_history->addHistory('product_updateprice','product_id=' . $this->request->post['list_product']);
        }

    }
	
// end phân loại danh mục và giá

  	public function delete() {
    	$this->load->language('catalog/product');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/product');
		
		$this->load->model('user/history');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$list_product = 'list';
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
				$list_product = $list_product . '_' . $product_id;
	  		}
			
			$this->model_user_history->addHistory('product_delete','product_id=' . $list_product);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . $this->request->get['filter_model'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/product' . $url));
		}

    	$this->getList();
  	}
	
  	public function copy() {
    	$this->load->language('catalog/product');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . $this->request->get['filter_model'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('catalog/product' . $url));
		}

    	$this->getList();
  	}

  	private function getList() {				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.product_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = NULL;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = NULL;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = NULL;
		}
		
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/product' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['insert'] = $this->url->https('catalog/product/insert' . $url);
		$this->data['copy'] = $this->url->https('catalog/product/copy' . $url);
		$this->data['delete'] = $this->url->https('catalog/product/delete' . $url);
										
    	$this->data['products'] = array();

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * 50,
			'limit'           => 50
		);
		
// phân loại danh mục và giá model/product, catalog/product, product.tpl     
        $this->data['cat_id'] = 0 ; 
        if (isset($_POST['cat_id']) && $_POST['cat_id'] != '') {
            $this->session->data['curr_cat'] = $_POST['cat_id'];
            $this->data['cat_id'] = $data['cat_id'] = $_POST['cat_id'];
        }else if (isset($this->session->data['curr_cat'])) {
            $this->data['cat_id'] =  $data['cat_id'] = $this->session->data['curr_cat'];
        }
        
        if(isset($_POST['filtertype']) && $_POST['filtertype'] == 'category')
            $this->data['filtertype'] = 'category';
        else
            $this->data['filtertype'] = '';
			
		$this->load->model('catalog/category');
        $this->data['categories'] = $this->model_catalog_category->getCategoriesFilter(0);  
// end phân loại danh mục và giá model/product, catalog/product, product.tpl, header.tpl
		
		$this->load->helper('image');
		
		$product_total = $this->model_catalog_product->getTotalProducts($data);
			
		$results = $this->model_catalog_product->getProducts($data);
				    	
		foreach ($results as $result) {
		
			$cat_id = $this->model_catalog_product->getProductCategoryId($result['product_id']);
			if($cat_id) {
				$product_href = $this->url->https('catalog/product/update&product_id=' . $result['product_id'] . $url) . '&category_id=' . $cat_id['category_id'];
			} else {
				$product_href = $this->url->https('catalog/product/update&product_id=' . $result['product_id'] . $url);
			}
			
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $product_href
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = image_resize($result['image'], 40, 40);
			} else {
				$image = image_resize('no_image.jpg', 40, 40);
			}

      		$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price' 	 => $this->currency->format($result['price']),
				'price_hc' 	 => $this->currency->format($result['price_hc']),
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
    	$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_name'] = $this->url->https('catalog/product&sort=pd.name' . $url);
		$this->data['sort_model'] = $this->url->https('catalog/product&sort=p.model' . $url);
		$this->data['sort_quantity'] = $this->url->https('catalog/product&sort=p.quantity' . $url);
		$this->data['sort_status'] = $this->url->https('catalog/product&sort=p.status' . $url);
		$this->data['sort_order'] = $this->url->https('catalog/product&sort=p.sort_order' . $url);
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = 50; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/product' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}

  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_brief_description'] = $this->language->get('entry_brief_description');
		$this->data['entry_technical_description'] = $this->language->get('entry_technical_description');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_tags'] = $this->language->get('entry_tags');
		$this->data['entry_description'] = $this->language->get('entry_description');
    	$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
    	$this->data['entry_status'] = $this->language->get('entry_status');
    	$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
    	$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_subtract'] = $this->language->get('entry_subtract');
    	$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
    	$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_measurement'] = $this->language->get('entry_measurement');
    	$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_download'] = $this->language->get('entry_download');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_phanloai'] = $this->language->get('entry_phanloai');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_prefix'] = $this->language->get('entry_prefix');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');
		
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		$this->data['button_add_special'] = $this->language->get('button_add_special');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_special'] = $this->language->get('tab_special');
		$this->data['tab_option'] = $this->language->get('tab_option');
    	$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['text_separator'] = $this->language->get('text_separator');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = '';
		}		
   
   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}	
		
   		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}		
     	
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}	

		$url = '';
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
			$this->data['category_id'] = $this->request->get['category_id'];
			
			$url .= '&category_id=' . $this->request->get['category_id'];
		} else {
			$category_id = 0;
			$this->data['category_id'] = 0;
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . $this->request->get['filter_model'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}	
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
			'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/product' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['product_id'])) {
			$this->data['product_id'] = 0;
			$this->data['action'] = $this->url->https('catalog/product/insert' . $url);
		} else {
			$this->data['product_id'] = $this->request->get['product_id'];
			$this->data['action'] = $this->url->https('catalog/product/update&product_id=' . $this->request->get['product_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/product' . $url);

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
    	}

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($product_info)) {
			$this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$this->data['product_description'] = array();
		}
		
		if (isset($this->request->post['model'])) {
      		$this->data['model'] = $this->request->post['model'];
    	} elseif (isset($product_info)) {
			$this->data['model'] = $product_info['model'];
		} else {
      		$this->data['model'] = '';
    	}

		if (isset($this->request->post['sku'])) {
      		$this->data['sku'] = $this->request->post['sku'];
    	} elseif (isset($product_info)) {
			$this->data['sku'] = $product_info['sku'];
		} else {
      		$this->data['sku'] = '';
    	}
		
		if (isset($this->request->post['warranty'])) {
      		$this->data['warranty'] = $this->request->post['warranty'];
    	} elseif (isset($product_info)) {
			$this->data['warranty'] = $product_info['warranty'];
		} else {
      		$this->data['warranty'] = '';
    	}
		
		if (isset($this->request->post['location'])) {
      		$this->data['location'] = $this->request->post['location'];
    	} elseif (isset($product_info)) {
			$this->data['location'] = $product_info['location'];
		} else {
      		$this->data['location'] = '';
    	}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($product_info)) {
			$this->data['image'] = $product_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->helper('image');
		
		if (isset($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['preview'] = image_resize($product_info['image'], 100, 100);
		} else {
			$this->data['preview'] = image_resize('no_image.jpg', 100, 100);
		}
	
		$this->load->model('catalog/manufacturer');
		
		if($category_id) {
			$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturersByCategoryId($category_id);
		} else {
			$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		}

    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (isset($product_info)) {
			$this->data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = 0;
    	}

		$this->load->model('catalog/chome');
		
    	$this->data['chomes'] = $this->model_catalog_chome->getchomes();

    	if (isset($this->request->post['product_chome'])) {
      		$this->data['product_chome'] = $this->request->post['product_chome'];
		} elseif (isset($product_info)) {
			$this->data['product_chome'] = $this->model_catalog_product->getProductChomes($this->request->get['product_id']);
		} else {
      		$this->data['product_chome'] = array();
    	}	
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (isset($product_info)) {
      		$this->data['shipping'] = $product_info['shipping'];
    	} else {
			$this->data['shipping'] = 1;
		}
      	
		if (isset($this->request->post['date_available'])) {
       		$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (isset($product_info)) {
			$this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d', time());
		}
											
    	if (isset($this->request->post['quantity'])) {
      		$this->data['quantity'] = $this->request->post['quantity'];
    	} elseif (isset($product_info)) {
      		$this->data['quantity'] = $product_info['quantity'];
    	} else {
			$this->data['quantity'] = 10;
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($product_info)) {
			$this->data['sort_order'] = $product_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		$this->load->model('localisation/stock_status');
		
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
    	
		if (isset($this->request->post['stock_status_id'])) {
      		$this->data['stock_status_id'] = $this->request->post['stock_status_id'];
    	} else if (isset($product_info)) {
      		$this->data['stock_status_id'] = $product_info['stock_status_id'];
    	} else {
			$this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}
		
		if (isset($this->request->post['stock_status_id_hc'])) {
      		$this->data['stock_status_id_hc'] = $this->request->post['stock_status_id_hc'];
    	} else if (isset($product_info)) {
      		$this->data['stock_status_id_hc'] = $product_info['stock_status_id_hc'];
    	} else {
			$this->data['stock_status_id_hc'] = $this->config->get('config_stock_status_id_hc');
		}
		
    	if (isset($this->request->post['price'])) {
      		$this->data['price'] = $this->request->post['price'];
    	} else if (isset($product_info)) {
			$this->data['price'] = $product_info['price'];
		} else {
      		$this->data['price'] = '';
    	}
		
    	if (isset($this->request->post['price_hc'])) {
      		$this->data['price_hc'] = $this->request->post['price_hc'];
    	} else if (isset($product_info)) {
			$this->data['price_hc'] = $product_info['price_hc'];
		} else {
      		$this->data['price_hc'] = '';
    	}
		
    	if (isset($this->request->post['template'])) {
      		$this->data['template'] = $this->request->post['template'];
    	} else if (isset($product_info)) {
			$this->data['template'] = $product_info['template'];
		} else {
      		$this->data['template'] = '';
    	}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} else if (isset($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
    	
		if (isset($this->request->post['tax_class_id'])) {
      		$this->data['tax_class_id'] = $this->request->post['tax_class_id'];
    	} else if (isset($product_info)) {
			$this->data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
      		$this->data['tax_class_id'] = 0;
    	}
		
		if (isset($this->request->post['total_promotion'])) {
      		$this->data['total_promotion'] = $this->request->post['total_promotion'];
    	} else if (isset($product_info)) {
			$this->data['total_promotion'] = $product_info['total_promotion'];
		} else {
      		$this->data['total_promotion'] = 0;
    	}
		
		if (isset($this->request->post['total_promotion_hc'])) {
      		$this->data['total_promotion_hc'] = $this->request->post['total_promotion_hc'];
    	} else if (isset($product_info)) {
			$this->data['total_promotion_hc'] = $product_info['total_promotion_hc'];
		} else {
      		$this->data['total_promotion_hc'] = 0;
    	}

    	if (isset($this->request->post['weight'])) {
      		$this->data['weight'] = $this->request->post['weight'];
		} else if (isset($product_info)) {
			$this->data['weight'] = $product_info['weight'];
    	} else {
      		$this->data['weight'] = '';
    	} 
		
		$this->load->model('localisation/weight_class');
		
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
    	
		if (isset($this->request->post['weight_class_id'])) {
      		$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
    	} elseif (isset($product_info)) {
      		$this->data['weight_class_id'] = $product_info['weight_class_id'];
    	} else {
      		$this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
    	}
		
		if (isset($this->request->post['length'])) {
      		$this->data['length'] = $this->request->post['length'];
    	} elseif (isset($product_info)) {
			$this->data['length'] = $product_info['length'];
		} else {
      		$this->data['length'] = '';
    	}
		
		if (isset($this->request->post['width'])) {
      		$this->data['width'] = $this->request->post['width'];
		} elseif (isset($product_info)) {	
			$this->data['width'] = $product_info['width'];
    	} else {
      		$this->data['width'] = '';
    	}
		
		if (isset($this->request->post['height'])) {
      		$this->data['height'] = $this->request->post['height'];
		} elseif (isset($product_info)) {	
			$this->data['height'] = $product_info['height'];
    	} else {
      		$this->data['height'] = '';
    	}

		$this->load->model('localisation/measurement_class');
		
		$this->data['measurement_classes'] = $this->model_localisation_measurement_class->getMeasurementClasses();
    	
		if (isset($this->request->post['measurement_class_id'])) {
      		$this->data['measurement_class_id'] = $this->request->post['measurement_class_id'];
    	} elseif (isset($product_info)) {
      		$this->data['measurement_class_id'] = $product_info['measurement_class_id'];
    	} else {
      		$this->data['measurement_class_id'] = $this->config->get('config_measurement_class_id');
    	}
		
		$this->data['language_id'] = $this->config->get('config_language_id');
		
		if (isset($this->request->post['product_option'])) {
			$this->data['product_options'] = $this->request->post['product_option'];
		} elseif (isset($product_info)) {
			$this->data['product_options'] = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		} else {
			$this->data['product_options'] = array();
		}
		
		$this->load->model('sale/customer_group');
		
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		$this->data['config_customer_group_id'] = $this->config->get('config_customer_group_id');
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($product_info)) {
			$this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($product_info)) {
			$this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		$this->load->model('catalog/color');
		
    	$this->data['colors'] = $this->model_catalog_color->getcolors();
		
		$this->data['no_image'] = image_resize('no_image.jpg', 100, 100);
		
		$this->data['product_images'] = array();
		
		if (isset($this->request->post['product_image'])) {
			foreach ($this->request->post['product_image'] as $result) {
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = image_resize($result['image'], 100, 100);
				} else {
					$image = image_resize('no_image.jpg', 100, 100);
				}
				
				$this->data['product_images'][] = array(
					'preview'  			=> $image,
					'color_id' 			=> $result['color_id'],
					'title_image' 		=> $result['title_image'],
					'description_image' => $result['description_image'],
					'slide_status' 		=> $result['slide_status'],
					'sort_order' 		=> $result['sort_order'],
					'file'     			=> $result['image']
				);
			}
		} elseif (isset($product_info)) {
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			
			foreach ($results as $result) {
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = image_resize($result['image'], 100, 100);
				} else {
					$image = image_resize('no_image.jpg', 100, 100);
				}
				
				$this->data['product_images'][] = array(
					'preview'  			=> $image,
					'color_id' 			=> $result['color_id'],
					'title_image' 		=> $result['title_image'],
					'description_image' => $result['description_image'],
					'slide_status' 		=> $result['slide_status'],
					'sort_order' 		=> $result['sort_order'],
					'file'     			=> $result['image']
				);
			}
		}

        if (isset($this->request->post['product_video'])) {
			$this->data['product_videos'] = $this->request->post['product_video'];
		} elseif (isset($product_info)) {
            $this->data['product_videos'] = $this->model_catalog_product->getProductVideos1($this->request->get['product_id']);
        } else {
			$this->data['product_videos'] = array();
        }

		$this->load->model('catalog/download');
		
		$this->data['downloads'] = $this->model_catalog_download->getDownloads();
		
		if (isset($this->request->post['product_download'])) {
			$this->data['product_download'] = $this->request->post['product_download'];
		} elseif (isset($product_info)) {
			$this->data['product_download'] = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$this->data['product_download'] = array();
		}
		
		$this->load->model('catalog/category');
		
		$this->data['categories'] = $this->model_catalog_category->getCategories2($category_id);
				
		$this->data['phukiens'] = $this->model_catalog_category->getCategories2(0);
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($product_info)) {
			$this->data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$this->data['product_category'] = array();
		}
		
 		if (isset($this->request->post['product_phukien'])) {
			$this->data['product_phukien'] = $this->request->post['product_phukien'];
		} elseif (isset($product_info)) {
			$this->data['product_phukien'] = $this->model_catalog_product->getProductPhukien($this->request->get['product_id']);
		} else {
			$this->data['product_phukien'] = array();
		}
		
 		if (isset($this->request->post['product_related'])) {
			$this->data['product_related'] = $this->request->post['product_related'];
		} elseif (isset($product_info)) {
			$this->data['product_related'] = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$this->data['product_related'] = array();
		}
		
		$this->load->model('catalog/phanloai');
				
		$this->data['phanloais'] = $this->model_catalog_phanloai->getPhanloais(0);
		
		if (isset($this->request->post['product_phanloai'])) {
			$this->data['product_phanloai'] = $this->request->post['product_phanloai'];
		} elseif (isset($product_info)) {
			$this->data['product_phanloai'] = $this->model_catalog_product->getProductPhanloais($this->request->get['product_id']);
		} else {
			$this->data['product_phanloai'] = array();
		}
		
		$this->load->model('catalog/attribute_group');
		$this->load->model('catalog/attribute');
		
		$this->data['attribute_groups'] = array();
		
		$attribute_groups = $this->model_catalog_attribute_group->getAttributeGroupsByCategoryId($category_id);
		
		if($attribute_groups) {
			
			$k = 0;
			
			foreach ($attribute_groups as $attribute_group) {
				$attributes = array();
				
				$attribute_infos = $this->model_catalog_attribute->getAttributesByAttributeGroupId($attribute_group['attribute_group_id']);

				foreach ($attribute_infos as $attribute_info) {
					if (isset($this->request->post['product_attribute'])) {
						$product_attribute = $this->request->post['product_attribute'];
						if($product_attribute[$k]['attribute_id'] == $attribute_info['attribute_id']) {
							$attribute_text = $product_attribute[$k]['text'];
						} else {
							$attribute_text = '';
						}
					} elseif(isset($product_info)) {
						$product_attribute = $this->model_catalog_product->getProductAttributeId($this->request->get['product_id'],$attribute_info['attribute_id']);
						if($product_attribute && $product_attribute['text']) {
							$attribute_text = $product_attribute['text'];
						} else {
							$attribute_text = $attribute_info['text_default'];
						}
					} else {
						$attribute_text = $attribute_info['text_default'];
					}
					
					$attributes[] = array(
						'name' 		   => $attribute_info['name'],
						'attribute_id' => $attribute_info['attribute_id'],
						'text' => $attribute_text
					);
					
					$k++;
				}
				
				$this->data['attribute_groups'][] = array(
					'name' 		 => $attribute_group['name'],
					'attribute_group_id' 		 => $attribute_group['attribute_group_id'],
					'attributes' => $attributes
				);
			}
		}
		
		$this->data['category_attribute'] = $this->model_catalog_category->getCategories1(0);
		
		if ($category_id) {
			$this->template = 'catalog/product_form.tpl';
		} else {
			$this->template = 'catalog/product_category.tpl';
		}
		
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['product_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 3) || (strlen(utf8_decode($value['name'])) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
    	if (!$this->error) {
      		return TRUE;
    	} else {
      		return FALSE;
    	}
  	}

	public function category() {
		$this->load->model('catalog/product');
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		$product_data = array();
		
		$results = $this->model_catalog_product->getProductsByCategoryId($category_id);
		
		foreach ($results as $result) {
			$product_data[] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name']
			);
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}
	
	public function related() {
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} else {
			$products = array();
		}
	
		$product_data = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				$product_data[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}
	
	public function phukien() {
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['product_phukien'])) {
			$products = $this->request->post['product_phukien'];
		} else {
			$products = array();
		}
	
		$product_data = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				$product_data[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}

    	if ($this->user->getUserGroupId() != 1) {
      		$this->error['warning'] = $this->language->get('error_permission_user');  
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
	
 	protected function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
}
?>
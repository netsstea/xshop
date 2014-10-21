<?php 
class List_Form_Search extends Cl_Form_Search
{

	public function init()
	{
		parent::init();
		$this->method= "GET";
		$this->fieldList = array('name',
				'items_type',
				'slug',
				'prefich'
				);
    	$this->setCbHelper('List_Form_Helper');
    	//$this->setDisplayInline();
	}
	public function setStep($step, $currentRow = null)
	{
	    parent::setStep($step);
	}


	//we must have it here as separate from $_fieldListConfig
	//because some configs will be merged with another file
	protected function _formFieldsConfig()
	{
		$sourceList = Dao_Node_Source::getInstance()->findAll();
		if ($sourceList['success'])
			$sourceList = $sourceList['result'];
		$t = Story_Form_Helper::getInstance()->getCategoryTreeSlug(false);
		if ($t['success'])
			$prefiches = $t['result'];
		$prefiches['home'] = 'home';
		foreach ($prefiches as $i => $name)
			$prefiches[$i] = str_replace('---', '', $name);
		return array(
				'status' => array(
						'type' => 'MultiCheckbox', /* 'MultiCheckbox', */
						'options' => array(
								'label' => "",
								'disableLoadDefaultDecorators' => true,
								//    			'required' => true,
		    		'filters' => array('StringTrim', 'StripTags', 'Int'),
						),
						'op' => '$in',
						'multiOptionsCallback' => array(array('Story_Form_Helper', 'getStatus')),
						'defaultValue' => array(0,1)
				),
				
				'name' => array(
						'type' => 'Text',
						'options' => array(
								'label' => "Name",
		    		'filters' => array('StringTrim', 'StripTags')
						),
						'op' => '$like',
				),
				'slug' => array(
						'type' => 'Text',
						'options' => array(
								'label' => "Slug",
								'filters' => array('StringTrim', 'StripTags')
						),
						'op' => '$like',
				),
	
				'items_per_page' => array(
						'type' => 'Select',
						'options' => array(
								'label' => "Display",
								'disableLoadDefaultDecorators' => false,
								'required' => true,
								'filters' => array('StringTrim', 'StripTags')
						),
						//or you can implement getItemsPerPageList here
						//'multiOptions' => array('getItemsPerPageList'),
						'multiOptions' => array(
								'-1' => "All",
								'10' => "10/page",
								'20' => "20/page",
								'30' => "30/page",
								'50' => "50/page",
								'100' => "100/page",
								'200' => "200/page",
								'5' => "5/page"
						),
						'defaultValue' => 10
				),
				'order_ots' => $this->generateFormElement('_cl_order', 'Order O-Time', -1),
				'items_type' => array(
						'type' => 'Select',
						'options' => array(
								'label' => t('items_type', 1),
								'disableLoadDefaultDecorators' => false,
								//'filters' => array('StringTrim', 'StripTags', 'Int')
						),
						'multiOptions' => array('story' => 'story', 'category' => 'Category'),
						'op' => '$like',
				),
				'prefich' => array(
						'type' => 'MultiCheckbox',
						'options' => array(
								'label' => t('category', 1),
								'disableLoadDefaultDecorators' => false,
								//'filters' => array('StringTrim', 'StripTags', 'Int')
						),
						'multiOptions' => $prefiches,
						'op' => '$in'
				),
		);
	}
		    
    /*
    public function extraCond()
    {
    	$lu = Zend_Registry::get('user');
    	$where = array();
    	if (get_value('tags'))
    	{
    	    $where[] = array('tags.slug' => )
    	}
    	if(in_array('sydney', $lu['roles'])){
    		$where[] = array('Location' => array('$regex' => 'Sydney'));
    	}
    	if(in_array('seattle', $lu['roles'])){
    		$where[] = array('Location' => array('$regex' => 'Seattle'));
    	}
    	if(in_array('seattle', $lu['roles']) && in_array('sydney', $lu['roles']) ){
    		$where[] = array('Location' => array('$regex' => 'Seattle','$regex' => 'Sydney'));
    	}
    	return array('where' => $where);
    }
    */
    
}

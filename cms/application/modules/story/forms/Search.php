<?php 
class Story_Form_Search extends Cl_Form_Search
{

	public function init()
	{
		parent::init();
		$this->method= "GET";
		$this->fieldList = array('name','source', 'status', 'category', 'order_ots', 'f', 'tags.slug', 'type');
    	$this->setCbHelper('Story_Form_Helper');
    	//$this->setDisplayInline();
	}
	public function setStep($step, $currentRow = null)
	{
		if ($step == 'list_items_order')
			$this->fieldList = array('name', 'order_ots', 'category');
		
	    parent::setStep($step);
	}
	//protected $_fieldListConfig; @see Cl_Dao_Foo
	
	
    //we must have it here as separate from $_fieldListConfig
    //because some configs will be merged with another file
    protected function _formFieldsConfig()
    {
    	$t = Dao_Node_Source::getInstance()->findAll();
    	if ($t['success'])
    	{
    		foreach ($t['result'] as $s)
    		{
	    		$sourceList[$s['id']] = $s['name'];
    		}
    	}
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
        'category' => array(
        		'type' => 'Select', /* 'MultiCheckbox', */
        		'options' => array(
        				'label' => "Category",
        				'disableLoadDefaultDecorators' => true,
        				//    			'required' => true,
        				'filters' => array('StringTrim', 'StripTags'),
        		),
                'multiOptionsCallback' => array(array('Story_Form_Helper', 'getCategoryTreeSlug')),
        		'$op' => '$eq'
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
    	'order_ots' => $this->generateFormElement('_cl_order', t('order_posted_time', 1), -1),
        'f' => array(
        		'type' => 'Checkbox',
        		'options' => array(
        				'label' => "Hot (featured) ?",
        				'disableLoadDefaultDecorators' => false,
        				'filters' => array('StringTrim', 'StripTags', 'Int')
        		),
                //'defaultValue' => 1
        		//or you can implement getItemsPerPageList here
        		//'multiOptions' => array('getItemsPerPageList'),
        ),
        "source" => array(
        		'type' => 'Select',
        		'options' => array(
        				'label' => "Source",
        				'disableLoadDefaultDecorators' => false,
        				'filters' => array('StringTrim', 'StripTags', 'Int')
        		),
                'multiOptions' => $sourceList,
                'op' => '$like',
        ),
        'tags.slug' => array(
        		'type' => 'Hidden',
        		'options' => array(
        				'label' => "Tags slug",
        				'disableLoadDefaultDecorators' => false,
        				'filters' => array('StringTrim', 'StripTags')
        		),
        		'op' => '$eq',
        ),
                 
        'type' => array(
        		'type' => 'MultiCheckbox',
        		'options' => array(
        			'label' => t('story_type', 1),
        			'disableLoadDefaultDecorators' => false,
        			'required' => true,
        			'filters' => array('StringTrim', 'StripTags', 'Int')
        		),
        		'op' => '$in',
        		'multiOptions' => array('1' => 'story', '2' => 'Image', '3' => 'video', '4' => 'Links'),
        		'defaultValue' => array('1','2','3')
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

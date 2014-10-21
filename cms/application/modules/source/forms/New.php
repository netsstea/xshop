<?php 
class Source_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array(
				 //'avatar',
				 'name','url',
				 'domains',
				 'slug','country', 'language',
				 'chapo',  
		         );
		$this->setCbHelper('Source_Form_Helper');
		
	}
	
	public function setStep($step, $currentRow = null)
	{
		parent::setStep($step);
	}
	
    protected function _formFieldsConfigCallback()
    {
        $ret = array(
        	'name' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Name",
        			'required' => true,
    	    		'filters' => array('StringTrim', 'StripTags'),
                    'validators' => array('NotEmpty'),
        		),
                //'permission' => 'update_task'
        	),
        	'domains' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Possible domains (Separated by commas ,)",
        						'required' => true,
        						'placeholder' => 'Separated by commas, wildcards allowed',
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        						'transformers' => array('commaSeparatedTextToArray')
        				),
        				//'permission' => 'update_task'
        		),        		
        	'slug' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Short code name",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				//'permission' => 'update_task'
        	),
        	'country' => array(
        				'type' => 'Select',
        				'options' => array(
        						'label' => "Country",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				'multiOptions' => country_list(),
        				//'permission' => 'update_task'
        		),
        	'language' => array(
        				'type' => 'Select',
        				'options' => array(
        						'label' => "Language",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				'multiOptions' => language_list(),
        				//'permission' => 'update_task'
        		),
        		         		 
            'chapo' => array(
            		'type' => 'Textarea',
            		'options' => array(
            				'label' => "Source Summary",
            				//'class' => 'isEditor',
            				'rows' => '5',
            				'width' => '100%',
            				'filters' => array('StringTrim', 'NodePost'),
            				'prefixPath' => array(
            						"filter" => array (
            								"Filter" => "Filter/"
            						)
            				)
            		),
            ),
            'content' => array(
        		'type' => 'Textarea',
        		'options' => array(
        	        'label' => "Source Content",
        	        'class' => 'isEditor',
    	    		'filters' => array('StringTrim', 'NodePost'),
        			'prefixPath' => array(
        				"filter" => array (
        					"Filter" => "Filter/"
        				)
        			)
        		),
        	),
            'status' => array(
            		'type' => 'Select',
            		'options' => array(
            				'label' => 'Status',
            				'required' => true,
            				'filters' => array('StringTrim', 'Int'),
            		),
            		'multiOptionsCallback' => array('getStatus'),
                    'defaultValue' => 1,
                    'permission' => 'admin_source'
            ),
        	'avatar' => array(
        				'type' => 'Hidden',
        				'options' => array(
        						'class' => 'edx_avatar',
        						'attribs' => array('data-upload-label' => t('upload_new_avatar', 1),
        								'data-upload-btn-class' => 'btn btn-primary fileinput-button'
        						)
        				)
        		),
        	'oavatar' => array(
        				'type' => 'Hidden',
        				'options' => array(
        				)
        		),
        		
        	'seed_id' => array( //crawled seed id
            		'type' => 'Hidden',
            		'options' => array(
            				'filters' => array('StringTrim', 'StripTags')
            		),
            ),
            'f' => array( //featured or not
            		'type' => 'Hidden',
            		'options' => array(
            				'filters' => array('StringTrim', 'StripTags', 'Int')
            		),
            ),
            'ots' => array( //featured or not
            		'type' => 'Hidden',
            		'options' => array(
            				'filters' => array('StringTrim', 'StripTags')
            		),
            ),
            'url' => array( //featured or not
            		'type' => 'Text',
            		'options' => array(
            		        'label' => "Main URL (a source can have multiple URLs)",
            				'filters' => array('StringTrim', 'StripTags')
            		),
            ),
            'category' => array(
            		'type' => 'Select',
            		'options' => array(
            				'label' => 'Category',
            				'required' => true,
            		),
            		'multiOptionsCallback' => array('getCategoryTreeSlug')
            ),
            'tags' => $this->generateFormElement('tags', 'Tags','', array(
                    'data-url' => '/suggest.php?node=tag&addnew=1'
                    )),
        		'weight' => array( //featured or not
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Weight in category",
        						'filters' => array('StringTrim', 'StripTags', 'Int')
        				),
        	),
        	'type' => array(
        				'type' => 'Hidden',
        				'options' => array(
        						'label' => t("type_of_source"),
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				'defaultValue'=> 1
        	),
        	'items_order' => array(
        				'type' => 'Hidden'
        	)
        		
        		
        );
        return $ret;
    }
    /**TODO: hook here if needed
    public function customIsValid($data)
    {
        return array('success' => false, 'err' => "If customIsValid exist. You must implement it");
    }
    */
}

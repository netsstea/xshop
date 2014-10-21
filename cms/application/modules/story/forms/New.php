<?php 
class Story_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array(
				'type',
				 'avatar', 
				'name','chapo', 'content','seed_id', 'suggest_tags',
		         'category', 'status', 'ourl', 'f', 'ots', 'tags', 'weight', 'list','multicheck');
		$this->setCbHelper('Story_Form_Helper');
		
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
        	'slug' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Slug",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				//'permission' => 'update_task'
        	),
            'chapo' => array(
            		'type' => 'Textarea',
            		'options' => array(
            				'label' => "Story Summary",
            				'class' => 'isEditor',
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
        	        'label' => "Story Content",
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
                    'permission' => 'admin_story'
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
            'ourl' => array( //featured or not
            		'type' => 'Text',
            		'options' => array(
            		        'label' => "Original url - ourl",
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
   				//'transformers' => array("tokensJSONStringToArray")
        	),
        	'type' => array(
        				'type' => 'Hidden',
        				'options' => array(
        						'label' => t("type_of_story"),
        						//'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        				'defaultValue'=> 1
        	),
        	'list' => array(
        				'type' => 'MultiCheckbox',
        				'options' => array(
        						'label' => t("add_to_list"),
        						//'required' => true,
        						//'filters' => array('StringTrim', 'StripTags'),
        						//'validators' => array('NotEmpty'),
        				),
        				'multiOptions'=> Dao_Node_Story::getInstance()->getAvailableLists(),
        				'permissions' => 'admin_list',
        	),
            'multicheck' => array(
                    'type' => 'Multiselect',
                    'options' => array(
                            'label' => t("add_to_list"),
                            'required' => false,
                            'filters' => array('StringTrim', 'StripTags'),
                            'validators' => array('NotEmpty'),
                    ),
                    'multiOptions'=> array(array('Story_Form_Helper', 'getSuggestTags')),
            ),
            'suggest_tags' => array(
                    'type' => 'MultiCheckbox',
                    'options' => array(
                            'label' => t("add_to_tag_list"),
                            //'required' => true,
                            //'filters' => array('StringTrim', 'StripTags'),
                            //'validators' => array('NotEmpty'),
                    ),
                    'multiOptions'=> array(array('Story_Form_Helper', 'getSuggestTags')),
                    'permissions' => 'admin_list',
            ),
        	'items_order' => array(
        				'type' => 'Hidden'
        	),
            'items_sticky' => array(
                    'type' => 'Hidden'
            )
        );
        if ($this->step == 'avatar')
        	$ret['avatar'] = array(
        				'type' => 'Hidden',
        				'options' => array(
        						'class' => 'edx_avatar',
        						'attribs' => array('data-upload-label' => t('upload_new_avatar', 1),
        								'data-upload-btn-class' => 'btn btn-primary fileinput-button'
        						)
        				)
        		);
        else 
        {
        	$ret['avatar'] = array(
        			'type' => 'Hidden',
        			'options' => array(
        					'class' => 'cl_upload',
        					'attribs' => array('data-upload-label' => t('upload_new_avatar', 1),
        							'data-upload-btn-class' => 'btn btn-primary fileinput-button'
        					)
        			)
        	);
        }
        return $ret;
    }
    
    /**TODO: hook here if needed
    public function customIsValid($data)
    {
        return array('success' => false, 'err' => "If customIsValid exist. You must implement it");
    }
    */
}

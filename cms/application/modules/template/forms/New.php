<?php 
class Template_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array(
				 'name',
				 'lists',
			     'themes',
				'categories'
				
         );
		$this->setCbHelper('Template_Form_Helper');
		
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
        	'lists' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Possible lists, Separated by commas (,)",
        						'required' => true,
        						'placeholder' => 'Separated by commas, wildcards allowed',
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        						//'transformers' => array('commaSeparatedTextToArray', 'prefixWithName')
        						'transformers' => array('commaSeparatedTextToArray')
        				),
        				//'permission' => 'update_task'
        		),        		

        	'themes' => array(
        				'type' => 'MultiCheckbox',
	        			'options' => array(
	        					'label' => "Applicable Themes",
	        					
	        			),
        				'multiOptions' => available_themes()
        	),
        		'categories' => array(
        				'type' => 'MultiCheckbox',
        				'options' => array(
        						'label' => "Create default lists for categories (giao-duc:category:top1) as well",
        		
        				),
        				'multiOptionsCallback' => array('getCategoryTreeSlug')
        		),
        		
        		
        		
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

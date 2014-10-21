<?php 
class Story_Form_SearchComment extends Cl_Form_SearchCommentNode
{
    public $nodeType = "story";
	public function init()
	{
        parent::init();
		if (method_exists($this, "_customFormFieldsConfig"))
			$this->_formFieldsConfig = array_merge($this->_formFieldsConfig(), $this->_customFormFieldsConfig());
	
		$this->fieldList = array('status', 'is_spam');
    	$this->setCbHelper('Story_Form_Helper');
	}
	public function setStep($step)
	{
	    if ($step == '')
	    {
    		$this->fieldList = array(
                'status', 'is_spam'
        	);
	        
	    }
	    parent::setStep($step);
	}
	
    protected function _customFormFieldsConfig()
    {
        return array(
        );
    }
    
}

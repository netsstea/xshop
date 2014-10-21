<?php 
class Template_Form_Update extends Template_Form_New
{
    public function init()
    {
        parent::init();
    }
    
    public function setStep($step, $currentRow = '')
    {
        if ($step == '' )
        {
            //$this->fieldList = array('name', 'content', 'status');
        }
        elseif ($step == 'status')
        {
            $this->fieldList = array('status');
        }
        elseif ($step == 'feature')
        {
        	$this->fieldList = array('f');
        }
        elseif ($step == 'tags')
        {
        	$this->fieldList = array('tags');
        }
        
        
        $this->setCbHelper('Template_Form_Helper');
	    parent::setStep($step);
    }
    
    /**
     * TODO: lots of checking here
     * Update a node can be divided into multiple step,each step updating certain fields
     * Depending on the step $this->step, we can check for the permission here
     * @param $data :Form data . For example $data['marker__id'] for field "marker.id" 
     * @see Cl_Form::customPermissionFilter()
     */
    public function customPermissionFilter($data, $currentRow)
    {
        $lu = Zend_Registry::get('user');
        if ($this->step == '') //a full update
        {
            assure_perm('update_own_template');
            return array('success' => true, 'err' => "Permission failed in Template");
        }
        
        return array('success' => true);
    }
}
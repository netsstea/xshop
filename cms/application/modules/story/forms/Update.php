<?php 
class Story_Form_Update extends Story_Form_New
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
        	$this->fieldList = array(
        			'type',
        			//'avatar', 
        			'name','chapo', 'content',
        			//'seed_id',
        			'category', 'status', 'ourl', 'f', 
        			//'ots', 
        			'tags', 'weight', 'list');
        	 
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
        elseif ($step == 'avatar')
        {
        	$this->fieldList = array('avatar');
        }
        
        
        $this->setCbHelper('Story_Form_Helper');
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
            assure_perm('update_own_story');
            return array('success' => true, 'err' => "Permission failed in Story");
        }
        
        return array('success' => true);
    }
}
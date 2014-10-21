<?php 
class List_Form_New extends Story_Form_New
{
	public function init()
	{
		parent::init();
		$this->fieldList = array(
				///'avatar', 
				'name',
				'slug', 
				'items_type',
				'lim',
				'kriteria'
				//'content',
				//'status', 'ourl',
		        //'category', 'f', 'ots', 'tags', 'weight'
				);
		$this->setCbHelper('Story_Form_Helper');
	}
	
	public function setStep($step, $currentRow = null)
	{
		parent::setStep($step);
	}
	
	protected function _formFieldsConfigCallback()
	{
		$ret = parent::_formFieldsConfigCallback();
		$ret['items_type'] = array(
            		'type' => 'Select',
            		'options' => array(
            				'label' => 'Item type',
            				'required' => true,
            				'filters' => array('StringTrim'),
            		),
            		'multiOptions' => array(
            			'category' => "Category",'story' => "News", "ad" => "Link",
            			'misc' => "Misc"
            		),
            );
		$ret['lim'] = array(
				'type' => 'Text',
				'options' => array(
						'label' => "List limit (maximum number of items in this list)",
						//'required' => true,
						'placeholders' => "maximum number of items in this list",
						'filters' => array('StringTrim', 'Int'),
				),
				'defaultValue' => 5
		);
		$ret['kriteria'] = array(
				'type' => 'Text',
				'options' => array(
						'label' => "Criteria",
						//'required' => true,
						'placeholders' => "Criteria an item must meet in order to be accepted into this list, such as hotness > x",
						'filters' => array('StringTrim','StripTags'),
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

<?php
class Dao_Comment_Story extends Cl_Dao_Comment
{
    protected function relationConfigs($subject = 'user')
    {
    	if ($subject == 'user')
    	{
    		return array(
    				'1' => '1', //vote|likes
    		);
    	}
    }
    protected $nodeType = "story";
    //public $nodeDaoClass = "Dao_Node_Story";
    
    protected function _configs()
    {
        return array(
    		'collectionName' => 'comments_story',
        	'documentSchemaArray' => array(
        		'content'	=>	'string',
                'content_uf' => "string", //unfiltered content
                'name' => "string", //sort of title for the comment. A substr of fcontent
                'node' => $this->cSchema,
        	    'pid' => 'string', //parent comment id        	
        		'u'	=>	$this->cSchema, //user who posted this
        		'ts'	=>	'int',
        		'attachments' => array(
        				array(
        						'u' => $this->cSchema,
        						'id' => 'string',
        						'ext' => 'string',
        						'path' => 'string',
        						'name' => 'string'
        				)
        		),
        	    'counter' => array(
        	        'vote' => 'int',
                    'spam' => 'int'
        	    ),
                'status' => 'string', // approved|queued
                'is_spam' => 'int', // 0 | 1
        	));
    }
    
    //protected  $nodeType;
    public function init($options = null)
    {
        $this->nodeType = 'story';
        $this->nodeDaoClass = 'Dao_Node_Story';
        parent::init();
    }       
    
    /**
     * @see Cl_Dao_Abstract::afterInsertRelation
     * 
     * @param unknown_type $data
     * @param unknown_type $newRelations
     * @param unknown_type $currentRow
     * @return multitype:boolean unknown
     */
    public function afterInsertRelation($data, $newRelations, $currentRow)
    {
        //increase vote counter
        $update = array('$inc' => array('counter.vote' => 1));
        $where = array('id' => $currentRow['o']['id']);
        $this->update($where, $update);
    	return array('success' => true, 'result' => $data);
    }

    //======================================Attachment==========================
	public function deleteAttachment($commentId, $fileId, $nodeId = false)
	{
        $r = Cl_Dao_File::getInstance()->delete(array('id' => $fileId));
        if ($r['success'])
        {
            //TODO: remove attachments from comments table or story table
            $where = array('id' => $commentId);
            $update = array('$pull' => array('attachments' => array('id' => $fileId)));
            $t = $this->update($where, $update);
            
            if (!$nodeId)
            {
                 $r2 = $this->findOne($where);
                 if ($r2['success'])
                     $nodeId = $r2['result']['node']['id'];
                 else     
                     return array('success' => "story not found for this comment");   
            }
            
            //$where2 = array('id' => $nodeId);
            //$update2 = array('$pull' => array('attachments' => array('id' => $fileId)));
            //Cl_Dao_Node_Story::getInstance()->update($where2,$update2);
            Dao_Node_Story::getInstance()->compressFiles($nodeId);
                        
            return $t;
        }
        return $r;	    
	}
    
}
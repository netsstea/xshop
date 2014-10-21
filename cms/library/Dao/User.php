<?php
class Dao_User extends Cl_Dao_User
{
	
	protected function _configs()
	{
		return array(
				'collectionName' => 'users',
				'documentSchemaArray' => array(
						'name' => 'string',
						'lname' => 'string',
						'mail' => 'string',
						'mail_token' => 'string', ////mail verification token. If not empty => not yet verified
						'pass' => 'string',
						'ts' => 'int',
						'avatar' => 'string',
						'last_login' => 'int',
						'token' => array(
								array(
										'token' => 'string',
										'ts' => 'int',
										'expire' => 'string'
								),
						),
						'status' => 'string', //unactivated|activated|banned
						'activation_code' => 'string',
						'roles' => 'array', // with prefixes
						'permissions' => 'array', //permissions with prefixes ('dmn')
						'oauth' => array(
								'facebook' => array(
										'id' => 'string',
										'name' => 'string',
										'access_token' => 'string',
										'avatar' => 'string',
										'mail' => 'string',
										'profile_url' => 'string',
										'duplicate_acc' => 'string' //id of an already-registered user id
								),
				 		 'twitter' => array(
				 		 		'id' => 'string',
				 		 		'name' => 'string',
				 		 		'access_token' => 'string',
				 		 		'avatar' => 'string',
				 		 		'mail' => 'string',
				 		 		'profile_url' => 'string',
				 		 		'duplicate_acc' => 'string' //id of an already-registered user id
				 		 ),
						),
						'counter' => array(
								'un' => 'int', //unread notifications count
								'ur' => 'int', //unread requests count
								'followers' => 'int',
								'following' => 'int',
								'fuc' => 'int', // friends activities update counter
								//	                 'at' => 'int', //assigned tasks
						//                     'ict' => 'int' , //in charge tasks
						//	                 'co' => 'int', //company
						),
						'inviter' => array( //person who invited this user
								'id' => 'string',
								'name' => 'string',
								'avatar' => 'string',
								'reason' => array(
										'type' =>  'string', //invitation can occur from different scenarios:
										//such as adding staff to school,
										//invite friends to join the site
										'id' => 'string' //course id or school id...
								)
						),
	
						'settings' => array(
								'notif_mail' => 'array', //when to send notifications via email
								'broadcast' => array(
										'post' => 'int', // [1|2|3] 1 => disabled, 2 => always, 3 => ask
										'associate' => 'int',
										'comment' => 'int',
										'like' => 'int',
										'follow' => 'int'
								), //1.post , 2. associate, 3.
								'digest' => 'array', //[1,2] 1 For weekly, 2 for monthly
								'as' => 'array', // [1,2,3] . Activity stream settings. What to show on newsfeed:
								//1 for showing post activity, 2 for showing follow activity
								//3 for showing comment activity... By default, all will be inserted.
								'language' => 'string' //prefered language
						),
						'notif' => array(
								'0' => 'array', // array of activities which are simple notices
								'1' => 'array', // array of activities which are simple notices
								'2' => 'array', //unread activities which request attention
								'3' => 'array', //read activities which request attention
						), //array of activity ids
						'nrts' => 'int', //last notif read timestamp
						'nmts' => 'int', //last notif mailed timestamp user notifications sent via email. We might have daily digest
						//so we need to remember this timestamp
						'f' => 'int', //is fake or not
						'crawler_apikey' => 'string', //api key from sand/io
						//'foo' => 'subdocument'
				),
				/*
				 'indexes' => array(
				 		array(
				 				array(
				 						'lname' => 1,
				 				),
				 				array("unique" => true, "dropDups" => true)
				 				 
				 		),
				 		array(
				 				array('iid' => 1),
				 				array("unique" => true, "dropDups" => true)
				 		)
				 )
		*/
		);
	}
	
}
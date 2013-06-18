<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    
	private $_id;
	public $email;
	private $_name;
	
	public function __construct($email, $password)
	{
	    $this->email = $email;
	    $this->password = $password;
	}
	
    
	public function authenticate()
	{
		$user = Users::model()->findByAttributes( array( 'email' => $this->email ) );
	    
		if(! $user)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if( $user->initialPassword != sha1($this->password) )
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->_id = $user->id;
			$this->_name = $user->name;
			$this->errorCode=self::ERROR_NONE;
			Yii::app()->user->setState('admin', true );
		}
		
		return $this->_setErrorMessage( $this->errorCode );
	}
	
	public function getId()
	{
	    return $this->_id;
	}
	
	public function getName(){
		return $this->_name;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	private function _setErrorMessage($errorCode)
	{
		switch( $errorCode ){
		    case 1 : 
			$this->errorMessage = 'Invalid email!';
			 break;
		     case 2 :
			 $this->errorMessage = 'Wrong password!';
			 break;
		     default:
			 $this->errorMessage = '';
		}  
		return ! $this->errorMessage;
	}
	
	
}
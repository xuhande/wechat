<?php
 namespace Pay;
 
//class  SDKRuntimeException extends Exception {
 class  SDKRuntimeException{
	public function errorMessage()
	{
		return $this->getMessage();
	}

}

?>
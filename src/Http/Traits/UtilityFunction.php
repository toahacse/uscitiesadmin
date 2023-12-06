<?php

namespace Toaha\UsCitiesAdmin\Http\Traits;

use Exception;

trait UtilityFunction
{
    protected function catchException($e)
	{
		$ExceptionData = [
			'success'	=> false,
			'msg'		=>$e->getMessage(),
			'code'		=>$e->getCode(),
			'line'		=>$e->getLine()
		];
		return $ExceptionData;
    }

    protected function exceptionCode($e) : int
    {
        $exception_code = $e->getCode();
        return $exception_code < 200 || $exception_code > 500 ? 500 : $exception_code;
    }

	protected function checkValidation($validator)
	{
		if($validator->fails()) 
		{

			$validations = $validator->errors()->messages();

			$errorsArray = [];
			foreach($validations as $field_name=>$errors) 
			{
				foreach($errors as $errorMsg)
				{
					$errorsArray[] = $errorMsg;
				}
			}
			$allErrorMsg = implode("\n", $errorsArray);
			throw new Exception($allErrorMsg,403);
		}
	}
}

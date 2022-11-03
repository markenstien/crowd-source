<?php

	function uploadSingle($fileName , $uploadPath , $customName = null)
	{
		$returnData = [
			'status' => true,
			'errors' => [],
			'name'   => ''
		];
		$uploaderImage = new UploaderImage();

        $uploaderImage->setImage($fileName)
        ->setName($customName)
        ->setPath($uploadPath)
        ->upload();

        if(!empty($uploaderImage->getErrors()))
        {
        	$returnData['status'] = false;
        	$returnData['errors'] = $uploaderImage->getErrors();
        }else{
        	$returnData['name'] = $uploaderImage->getName();
        }

        return $returnData;
	}
?>
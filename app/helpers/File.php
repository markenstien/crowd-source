<?php 	

	class File 
	{
		/*Required*/

		private $_acceptedFileType = ['png' , 'jpeg' , 'jpg' , 'bitmap' , 'pdf' , 'docx' , 'doc' , 'xls'];

		private static $imageExtensions = ['png' , 'jpeg' , 'jpg' , 'bitmap'];
		private $_errors = [] , $notes = [];

		/*MAXIMUM FILE SIZE (KB TYPE)*/

		private $_maxSize = 150; //300 kb
		/*set the file*/
		public function setFile($file)
		{
			try{
				if(!isset($file['tmp_name'])){
					// $this->addError('File does not exists');
					throw new Exception("File does not exists", 1);
				}

				if(!isset($file['name'])){
					// $this->addError('File does not exists');
					throw new Exception("File does not exists", 1);
				}

				$this->_fileTmp  = $file['tmp_name'];
				$this->_fileName = $file['name'];
				$this->_fileSize = $file['size'];

				return $this;
			}catch(Exception $e){

				$this->addError($e->getMessage());
			}finally{

				return $this;
			}
			
		}

		/*set upload file*/
		public function setDIR($dir)
		{
			$this->_dir = $dir;

			return $this;
		}

		/*set name prefix*/
		public function setPrefix($prefix)
		{
			$this->_prefix = $prefix;
			return $this;
		}

		/*set custom name*/
		public function setCustomName($customName)
		{	
			$this->_customName = $customName;
			return $this;
		}

		/*add file type that can be accepted*/
		public function addFileType($fileType)
		{
			if(is_array($fileType))
			{
				$difference = array_diff($fileType, $this->_acceptedFileType);

				if(!empty($difference)){
					array_merge($this->_acceptedFileType , $difference);
				}
			}else
			{
				array_push($this->_acceptedFileType, $fileType);
			}

			return $this;
		}

		/*alter file type extion accept*/
		public function alterFileType(array $fileTypeList)
		{
			$this->_acceptedFileType = $fileTypeList;
		}

		/*trigger upload*/
		public function upload()
		{
			if(! empty($this->errors)){
				return [
					'success' => false ,
					'errors'  => implode(',', $this->_errors)
				];
			}else
			{
				//upload file check extension
				$getExtension = explode('.', $this->_fileName);

				$extension    = strtolower(end($getExtension));

				if(! in_array($extension, $this->_acceptedFileType)){

					$this->addError("Invalid extension '{$extension}'");
				}

				if(!empty($this->errors)){

					return [
						'success' => false,
						'errors'  => implode(',', $this->_errors)
					];
				}else
				{
					//check if dir exits;
					if(!property_exists($this, '_dir')){

						$this->addError("Upload file directory is not set");

						return [
							'success' => false ,
							'errors'  => implode(',' , $this->_errors)
						];
					}else{

						$uploadName = $this->_customName ?? $this->makeName($extension);

						$prefix  = $this->_prefix ?? '';

						$newName = $this->_fileUploadName =  $prefix.''.$uploadName;

						$pathUpload = $this->_pathUpload = $this->_dir.DIRECTORY_SEPARATOR.$newName;

						if(!in_array($this->getExtension(), self::$imageExtensions)){
							if(!move_uploaded_file($this->_fileTmp,$pathUpload)){

								$this->addError('File is not uploaded');

								return [
									'success' => false ,
									'errors'  => implode(',' , $this->_errors)
								];
							}
						}else
						{
							if(!move_uploaded_file($this->_fileTmp,$pathUpload)){

								$this->addError('File is not uploaded');

								return [
									'success' => false ,
									'errors'  => implode(',' , $this->_errors)
								];
							}
							
							//check if file is oversize
							// if( $this->isOverSize() ) {
							// 	//we will shrink the image and append it to the note array
							// 	// $this->addError("File is too large max size is '{$this->_maxSize}kB' but the system will resize it.");
							// 	$this->shrinkSize();

							// 	$this->addNotes("Your Image is too large. the system shrink it");
							// }else{
							// 	if(!move_uploaded_file($this->_fileTmp,$pathUpload)){

							// 		$this->addError('File is not uploaded');

							// 		return [
							// 			'success' => false ,
							// 			'errors'  => implode(',' , $this->_errors)
							// 		];
							// 	}
							// }
						}
						
					}

					return [
						'success' => true
					];
				}
			}
		}

		private function isOverSize($resize = true)
		{
			if($this->_maxSize < ($this->_fileSize / 100)){
				return true;
			}else{
				return false;
			}
		}
		/*auto set name*/
		private function makeName($extension)
		{
			return strtolower(uniqid().'.'.$extension);
		}

		public function getFileUploadName()
		{
			return $this->_fileUploadName;
		}
		/*add errors*/
		private function addError($err)
		{
			$this->_errors[] = $err;
		}
		public function getErrors()
		{
			return implode(',' , $this->_errors);
		}

		private function addNotes($notes)
		{
			$this->_notes [] = $notes;
		}

		public function getNotes()
		{
			return $this->_notes;
		}

		/*SHRINK*/

		private function shrinkSize()
		{
			$fileTmp = $this->_fileTmp;
			$fileName = $this->_fileName;
			/*get image size*/
			$sourceProperty = getimagesize($fileTmp);
			/*get the image type*/
			$image_type = $sourceProperty[2];

			if( $image_type == IMAGETYPE_JPEG ) 
			{   
				$imageSourceId = imagecreatefromjpeg($fileTmp);  

				$targetLayer = $this->fileResize($imageSourceId,$sourceProperty[0],$sourceProperty[1]);

				/*second parameter is a directory*/
				imagejpeg($targetLayer,$this->_pathUpload);
			}
			elseif( $image_type == IMAGETYPE_GIF )  
			{  
				$imageSourceId = imagecreatefromgif($fileTmp);

				$targetLayer = $this->fileResize($imageSourceId,$sourceProperty[0],$sourceProperty[1]);

				imagegif($targetLayer, $this->_pathUpload);
			}
			elseif( $image_type == IMAGETYPE_PNG )
			{
				$imageSourceId = imagecreatefrompng($fileTmp); 

				$targetLayer = $this->fileResize($imageSourceId,$sourceProperty[0],$sourceProperty[1]);

				imagepng($targetLayer, $this->_pathUpload);
			}
		}

		/*
		*IMPORTANT!
		*@param $targetDimension will be the new image dimension 
		if you are planning to alter the default 200 200 use this following format
		array(200,200) width , height
		*/
		private function fileResize($imageSourceId,$width,$height, $targetDimension = null) 
		{

			if($targetDimension == null) {

				$targetWidth = 400;
				$targetHeight = 640;

				$ratio = $width / $height; //original file ratio;

				if($targetWidth / $targetHeight > $ratio)
				{
					$targetWidth = $width * $ratio;
					$targetHeight = $h;
				}else{
					$targetHeight = $height * $ratio;
					$targetWidth  = $width;
				}

			}else{

				list($targetWidth , $targetHeight) = $targetDimension;
			}

			$targetLayer  = imagecreatetruecolor($targetWidth,$targetHeight);

			imagecopyresampled($targetLayer,$imageSourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

			return $targetLayer;
		}


		public function getSize()
		{
			return $this->_fileSize;
		}


		public function getExtension()
		{
			$getExtension = explode('.', $this->_fileName);

			return strtolower(end($getExtension));
		}
		private function changeMaxSize($size)
		{
			$this->_maxSize = $size;
		}
	}
?>

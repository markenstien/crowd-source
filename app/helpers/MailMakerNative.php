<?php 	

	class MailMakerNative
	{	
		private static $instance = null;

		public static function getInstance()
		{
			if(self::$instance === null)
			{
				self::$instance = new MailMakerNative();
			}

			return self::$instance;
		}

		public function setReciever($email , $name = 'No Name')
		{
			$this->email = $email;
			$this->name  = $name;

			return $this;
		}

		public function setSubject($subject)
		{
			$this->subject = $subject;
			return $this;
		}

		public function setBody($body)
		{
			$this->body = $body;
			return $this;
		}

		public function useHTMLHeader()
		{
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: <".MAILER_AUTH['username'].">" . "\r\n";
			$headers .= "Cc:".$this->email."" . "\r\n";

			$this->headers = $headers;
			return $this;
		}

		public function usePlainHeader()
		{
			$headers = "From:".MAILER_AUTH['username']."" . "\r\n" .
			"CC:".$this->email."";

			$this->headers = $headers;
			return $this;
		}


		public function send()
		{
			$to       = $this->email;
			$subject  = $this->subject;
			$body     = $this->body;

			$headers   = null;

			if(!isset($this->headers))
			{
				$this->usePlainHeader();

				$headers = $this->headers;
			}
			else{
				$headers = $this->headers;
			}

			try
			{
				mail($to,$subject,$body,$headers);

			}catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
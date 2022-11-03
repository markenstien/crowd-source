<?php 

	class ExaminationResult
	{
		private $table_name = 'application_examinations';

		public function __construct($examinationid)
		{
			$this->db = DB::getInstance();

			$sql = "SELECT * FROM $this->table_name where id = '$examinationid'";

			$query = $this->db->query($sql);

			$result = fetchSingle($query);

			$this->id = $result['id'];
			$this->examid = $result['examid'];
			$this->applicationid = $result['applicationid'];
			$this->userid = $result['userid'];
			$this->exam_date = $result['exam_date'];
			$this->status = $result['status'];
		}

		

		public function getTimeConsumed()
		{
			$now = date("Y-m-d H:i:s");

			$start_date = new DateTime($now);
			$since_start = $start_date->diff(new DateTime($this->exam_date));

			return $since_start->i;
		}

		public function computeResult()
		{

		}


		public function getRemarks()
		{
			$correctTotal  = count($this->getCorrects());
			$totalQuestion = count($this->getInCorrects()) + $correctTotal;

			if($correctTotal > 0)
			{
				$denominator = 100 / $totalQuestion;

				$percentage = (($correctTotal  * $denominator) / ($totalQuestion * $denominator)) * 100;

				if($percentage >= 75) {
					return [
						'remarks' => 'passed',
						'score'   => $percentage
					];
				}else{
					return [
						'remarks' => 'failed' , 
						'score'   => $percentage
					];
				}
			}
			return [
				'remarks' => 'failed',
				'score'   => 0
			];
			
		}

		public function getCorrects(){
			$examinationid = $this->id;

			$sql = "SELECT * FROM exam_answers where examinationid = '$examinationid' and remarks = 'correct'";

			$query = $this->db->query($sql);

			return fetchAll($query);
		}

		public function getInCorrects(){
			$examinationid = $this->id;

			$sql = "SELECT * FROM exam_answers where examinationid = '$examinationid' and remarks = 'incorrect'";

			$query = $this->db->query($sql);

			return fetchAll($query);
		}

		public function getSummary()
		{
			$examinationid = $this->id;

			$sql = "SELECT ea.answer as useranswer , ea.remarks as remarks , eqca.id as qaid,
			eqca.answer as answer , eqca.question as question,eqca.question_img as question_img , 
			choice_1 , choice_2 , choice_3, choice_4,
			image_1, image_2, image_3, image_4 

			FROM exam_answers as ea 
			LEFT JOIN

			exam_question_choices_answer as eqca 
			ON ea.questionid = eqca.id  

			WHERE examinationid = '$examinationid'";


			$query = $this->db->query($sql);

			$rowList   = fetchAll($query);
			
			$questionAnswerList = array();


			foreach ($rowList as $key => $row) {

				$sql = "SELECT {$row['answer']} as correctanswer from exam_question_choices_answer where id  = '{$row['qaid']}'";

				$query = $this->db->query($sql);

				$append = fetchSingle($query);


				$questionAnswer = [
					'question' => $row['question'],
					'correctanswer' => $append['correctanswer'],
					'useranswer'  => $row['useranswer'],
					'remarks'   => $row['remarks']
				];

				$questionAnswerList[] = $questionAnswer;
			}

			return $questionAnswerList;	
		}
	}
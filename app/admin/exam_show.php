<?php require_once '../dependencies.php';?>
<?php $exam   = getExam($_GET['id']);?>
<?php $examQuestions = getExamQAList($exam['id'])?>
<?php build('content') ?>
    <?php spaceUp()?>

    <div class="card card-theme-dark">
        <div class="card-header">
            <h4 class="card-title">Exam Preview : <?php echo $exam['name']?> </h4>
        </div>
        <?php Flash::show('examcreate');?>
        <?php Flash::show();?>
        <div class="card-body">
            <div class="panel-body">
                <div class="well">
                    <h3>Summaries</h3>
                    <p>Total Questions : <?php echo count($examQuestions)?>
                        &nbsp; Description : <?php echo $exam['description']?>
                        &nbsp; Time to complete : <?php echo $exam['duration']?>(hh:mm)
                    </p>
                </div>
                <div class="well">
                    <h3>QA list</h3> <a href="exam_qa_create.php?id=<?php echo $exam['id']?>">Add More Question</a>
                    <?php $questionAndAnswers = getExamQAList($exam['id']);?>
                    <div class="row">
                        <?php foreach($questionAndAnswers as $key => $qa) :?>
                            <div class="col-md-5 question">
                                <strong><?php echo $qa['orderNumber']?>.</strong>
                                <?php
                                    if(empty($row['question'])) {
                                        FormText('' , $qa['question'] , [
                                            'class' => 'form-control',
                                            'readonly' => ''
                                        ]);
                                    }else{
                                        echo '<p>....</p>';
                                    }
                                ?>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <?php
                                                $correctAnswerHTML = '';
                                                if( isEqual(examQAtoAlphabet('choice_1') , 'A') )
                                                    $correctAnswerHTML = "style='font-weight:bold'";
                                            ?>
                                            <span <?php echo $correctAnswerHTML?>>A.</span>

                                            <?php echo $qa['choice_1']?>
                                            <div><?php  echo convertImage($qa['image_1'])?></div>
                                        </p>
                                        <p>
                                            <?php
                                                $correctAnswerHTML = '';
                                                if( isEqual(examQAtoAlphabet('choice_2') , 'B') )
                                                    $correctAnswerHTML = "class='text-bold text-success'";
                                            ?>
                                            <span <?php echo $correctAnswerHTML?>>B.</span>
                                            <?php echo $qa['choice_2']?>
                                            <div><?php  echo convertImage($qa['image_2'])?></div>
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <p>
                                            <?php
                                                $correctAnswerHTML = '';
                                                if( isEqual(examQAtoAlphabet('choice_3') , 'C') )
                                                    $correctAnswerHTML = "class='text-bold text-success'";
                                            ?>
                                            <span <?php echo $correctAnswerHTML?>>C.</span>
                                            <?php echo $qa['choice_3']?>
                                            <div><?php echo convertImage($qa['image_3'])?></div>
                                        </p>
                                        <p>
                                            <?php
                                                $correctAnswerHTML = '';
                                                if( isEqual(examQAtoAlphabet('choice_4') , 'D') )
                                                    $correctAnswerHTML = "class='text-bold text-success'";
                                            ?>
                                            <span <?php echo $correctAnswerHTML?>>D</span>
                                            <?php echo $qa['choice_4']?>
                                            <div><?php  echo convertImage($qa['image_4'])?></div>
                                        </p>
                                    </div>
                                </div>

                                <p ><strong>Answer : <?php echo examQAtoAlphabet($qa['answer']) ?> </strong> </p>

                                <a href="exam_qa_edit.php?id=<?php echo $qa['id']?>" target="_blank">Edit</a>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('headers')?> 
    <style type="text/css">
        .space-up{
            margin: 5px;
        }
        .choices img
        {
            width: 70px;
            height: 70px;
        }

        .question{
            background: #fff;
            margin: 10px;
            padding-top: 10px;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .question img{
            width: 150px;
            height: 150px;
        }
    </style>
<?php endbuild()?>

<?php loadTo('orbit/app-admin')?>
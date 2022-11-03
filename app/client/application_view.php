<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php 
    if(postRequest('cancelJobApplication'))
    {
        //cancel application
        $result = updateApplicationStatus($_POST['applicationid'] , 'cancelled');
    }
?>
<?php $applicationid = $_GET['id']?>
<?php  $ja = new JobApplication($applicationid) ;?>
<?php
    $jaInfo   = $ja->getJobApplicationInfo();
    $job      = $ja->getJobInfo();
    $company  = $ja->getCompany();
    $applicant = $ja->getApplicantInfo();
    $applicant = [
        'personal'        => $applicant->getPersonal(),
        'workExperiences' => $applicant->getWorkExperience(),
        'skills'          => $applicant->getSkills(),
        'education'       => $applicant->getEducation()
    ];
?>
<?php build('content') ?>

<div id="wrapper">
    <div style="margin-top: 50px;"></div>

    <div class="card">
        <div class="card-header">
            <h3>Application Preview</h3>
            <?php Flash::show()?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo URL.DS.'public/assets/'.$company['logo']?>" id="logo">
                </div>
                <div class="col-md-9">
                    <h3><?php echo $company['name'] . ' , ' . $company['type']?></h3>
                    <small><?php echo $company['description']?> <strong><?php echo $company['address']?></strong> </small>
                    <ul>
                        <li><?php echo $company['email']?></li>
                        <li><?php echo $company['phone']?></li>
                        <li><a href="catalog.php?keyword=<?php echo $company['name']?>" target="_blank">Vacancies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4>Job Description</h4>
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li> Title : <?php echo $job['title']?> </li>
                                <li> Sub : <?php echo $job['sub_title']?> </li>
                                <li> Position : <?php echo $job['position']?> </li>
                                <li> Salary : <?php echo $job['salary']?> </li>
                                <li> Salary Type : <?php echo $job['salary_type']?> </li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul>
                                <li> Education : <?php echo $job['education']?> </li>
                                <li> Gender : <?php echo $job['gender']?> </li>
                                <li> Categories : <?php echo $job['categories']?> </li>
                                <li> Urgency : <?php echo $job['urgency']?> </li>
                                <li> Employee Needed : <?php echo $job['employee_needed']?> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Job Exams</h4>
                    <?php $hasJobExam = false?>
                    <?php for($i = 1; $i < 4 ; $i++) :?>
                    <?php
                        $exam = getJobExam($job['id'], $i);
                        if(is_null($exam)){
                            continue;
                        }else{
                            $hasJobExam = true;
                        }
                    ?>
                    <div class="exam1">
                        <div> <strong>Exam <?php echo $i?></strong> </div>
                        <?php
                            $examTooked = hasTookExam($applicationid , $exam['examid']);

                            if($examTooked) 
                            {
                                if(isEqual($examTooked['status'] , 'unfinished'))
                                {
                                    $lastQuestion = getExaminationLastQuestion($examTooked['id']);

                                    if(empty($lastQuestion)){
                                        $firstQuestion = getFirstQuestion($examTooked['examid']);
                                        print <<<EOF
                                            <a href="take_exam.php?examinationid={$examTooked['id']}&question={$lastQuestion['questionid']}">
                                                Continue Exam
                                            </a>
                                        EOF;
                                    }else
                                    {
                                        //not empty last question
                                        print <<<EOF
                                        <a href="take_exam.php?examinationid={$examTooked['id']}&question={$lastQuestion['questionid']}">
                                            Continue Exam
                                        </a>
                                        EOF;
                                    }
                                    
                                }else
                                {
                                    $result = getExamResult(" WHERE examinationid = '{$examTooked['id']}'");

                                    if(! is_null($result))
                                    {
                                        print <<<EOF
                                            <div>
                                                <div>{$result['score']}.'%'{$result['remarks']}</div>
                                                <a href="examination_result.php?resultid={$result['id']}">Review</a>
                                            </div>
                                        EOF;
                                    }else{
                                        echo 'exam has no result';
                                    }
                                    
                                }
                            }else
                            {
                                if(empty($exam)) {
                                    echo 'job has no exam';
                                }else{
                                    print <<<EOF
                                        <a href="take_exam.php?applicationid={$applicationid}&examid={$exam['examid']}">Take Exam</a>
                                    EOF;
                                }
                            }
                        ?>
                    </div>
                    <?php endfor?>

                    <?php if(!$hasJobExam) :?>
                        <p>No Exam</p>
                    <?php endif?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h4>Application Details</h4>
            <h3><?php echo $applicant['personal']['fullname']?></h3>
            <div class="row">
                <div class="col">
                    <ul>
                        <li>Date Applied : <?php echo $jaInfo['date_applied']?></li>
                        <li>Status : <?php echo $jaInfo['status']?></li>
                        <li>Resume Image : <a href="file_viewer.php?filename=<?php echo $jaInfo['resume_image']?>" target="_blanks">Preview</a></li>
                        <li>Resume Document : <a href="file_viewer.php?filename=<?php echo $jaInfo['resume_text']?>" target="_blanks">Preview</a></li>
                    </ul>
                </div>
                <div class="col">
                    <p>
                        <strong>Pitch</strong> <br/>
                        <?php echo $jaInfo['applicant_pitch']?>
                    </p>
                </div>
            </div>
        </div>

        <?php if(! isEqual( $jaInfo['status'] , 'cancelled')) :?>
        <div class="card-body">
            <section>
                <h3 style="background: red ; color: #fff; padding: 10px;">Danger Zone</h3>
                <form method="post">
                    <input type="hidden" name="applicationid" value="<?php echo $_GET['id']?>">
                    <input type="submit" name="cancelJobApplication" class="btn btn-danger" value="Cancel Application">
                </form>
            </section>
        </div>
        <?php else:?>
            <section class="alert alert-danger">
                <p>This job application is already cancelled.</p>
            </section>
        <?php endif?>
    </div>
</div>

<?php endbuild()?>

<?php build('headers')?>
    <style type="text/css">
        #logo{
            width: 150px;
            height: 150px;
        }
    </style>
<?php endbuild()?>  
<?php loadTo('orbit/app')?>


<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php $user = new Profile();?>
<?php $employee = getEmployee($_GET['workid']) ;?>
<?php $company  = getCompanyInfo($employee['companyid'])?>
<?php $applicant = new Applicant($employee['userid']);?>
<?php $employee_evaluations = evaluationGroup($employee['empid']);?>

<?php build('content') ?>

<div id="wrapper">
    <div style="margin-top: 50px;"></div>

    <div class="card">
        <div class="card-header">
            <h3>Work Details</h3>
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

    <div class="card col-md-12 mx-auto">
    	<div class="card-header">
    		<h4>Employement Details</h4>
    	</div>
    	<div class="card-body">
    		<h3><?php echo $employee['fullname']?></h3>
    		<div class="row">
    			<div class="col-md-6">
    				<table class="table table-sm">
    					<tbody>
    						<tr>
			    				<td>Employmenent ID</td>
			    				<td><?php echo $employee['empcode']?></td>
			    			</tr>
			    			<tr>
			    				<td>Status</td>
	    						<td><?php echo $employee['status']?></td>
			    			</tr>
    					</tbody>
    				</table>
    			</div>
    			<div class="col-md-6">
    				<table class="table table-sm">
    					<tbody>
    						<tr>
			    				<td>Started</td>
	    						<td><?php echo $employee['date_started']?></td>
			    			</tr>
			    			<tr>
			    				<td>Company</td>
	    						<td><?php echo $company['name']?></td>
			    			</tr>
			    			<tr>
			    				<td>Position</td>
	    						<td><?php echo $employee['job_position']?></td>
			    			</tr>
    					</tbody>
    				</table>
    			</div>
    		</div>
    		
    		<div style="background-color: red; height: 30px;"></div>
    		<section>
    			<table class="table table-sm">
	    			<tbody>
	    				<tr>
	    					<td>Company</td>
	    					<td> <span class="badge badge-danger"><?php echo $company['name']?></span></td>
	    				</tr>

	    				<tr>
	    					<td>Job Title</td>
	    					<td><?php echo $employee['job_title']?></td>
	    				</tr>

	    				<tr>
	    					<td>Job Position</td>
	    					<td><?php echo $employee['job_position']?></td>
	    				</tr>

	    				<tr>
	    					<td>Employement</td>
	    					<td><?php echo $employee['emp_type']?></td>
	    				</tr>

	    				<tr>
	    					<td>Salary Type</td>
	    					<td><?php echo $employee['salary_type']?></td>
	    				</tr>

	    				<tr>
	    					<td>Salary</td>
	    					<td><?php echo $employee['salary']?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    		<p> <strong>Company Note</strong> <br>
	    			<?php echo $employee['notes']?>
	    		</p>
    		</section>

    		<section>
    			<h4>Employement Remarks</h4>
    			<table class="table">
    				<thead>
    					<th>Season</th>
    					<th>Remarks</th>
    					<th>Average</th>
    				</thead>
	    			<tbody>
	    				<?php $total = 0?>
	    				<?php foreach($employee_evaluations as $row) :?>
	    					<?php $total += $row['remarks'] ?>
		    				<tr>
		    					<td><?php echo $row['season']?></td>
		    					<td><?php echo $row['remarks']?></td>
		    					<td><?php echo evaluationCriteriaScore(round($row['average']))?></td>
		    				</tr>
		    			<?php endforeach?>
	    			</tbody>
    			</table>
    			<?php if($total > 0) :?>
				<div>
					<h3>Evaluation Summary</h3>
					<p>
						<?php $placeHolder = count($employee_evaluations) * 25;?>

						<?php $percentage = getPercentage($total , $placeHolder)?>
					</p>
					<h3><?php echo $percentage.'%';?> <?php  echo passFail($percentage ,$placeHolder)?></h3>
				</div>
				<?php endif;?>
    		</section>
    	</div>
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

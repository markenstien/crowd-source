truncate applicant_appointments;
truncate applicant_educations;
truncate applicant_skills;
truncate application_informations;
truncate companies;
truncate employees;
truncate employee_evaluations;
truncate employee_jobs;
truncate jobs;
truncate job_applications;

truncate work_experiences;


delete from users where id != 1;
delete from user_informations where userid != 1;


	

delete from application_examinations;
delete from exam_answers;
	
delete from jobs_exam;

delete from jobs where id != 1;


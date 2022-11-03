--9/21/2019 FIRST DATABASE

create database th_job_recruitment;

DROP TABLE IF EXISTS users;
create table users(
	id int(10) not null primary key auto_increment,
	username varchar(100) not null unique,
	password varchar(100) not null,
	type enum('HR' ,'Admin' , 'Applicant'),
	created_at timestamp default now(),
	status enum('active' , 'inactive'),
	is_online boolean default false
);
DROP TABLE IF EXISTS user_informations;
create table user_informations(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	firstname varchar(100) not null,
	lastname varchar(100) not null,
	gender enum('male' , 'female') not null,
	birthday date ,
	nationality varchar(50) not null,
	phone varchar(20) not null,
	email varchar(50) not null,
	address text ,
	profile text
);
DROP TABLE IF EXISTS application_informations;
create table application_informations(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	educations text ,
	skills text ,
	experiences text
);
DROP TABLE IF EXISTS applicant_skills;
create table applicant_skills(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	category int(10) not null,
	name varchar(50)
);

DROP TABLE IF EXISTS jobs;
create table jobs(
	id int(10) not null primary key auto_increment,
	userid int(10) not null,
	date_posted date ,
	title varchar(100) ,
	sub_title varchar(50),
	position varchar(50),	
	company varchar(50),	
	email varchar(50),	
	phone varchar(50),
	salary decimal(10 ,2),
	salary_type enum('per hour' , 'daily' , 'weekly' ,'monthly'),	
	description text,
	address text,	
	notes text,
	status enum('active' , 'inactive')
);

DROP TABLE IF EXISTS job_categories;
create table job_categories(
	id int(10) not null primary key auto_increment,
	category varchar(100) not null,
	description text,
	created_at timestamp default now(),
	status enum('active' ,'inactive')
);

DROP TABLE IF EXISTS job_post_categories;
create table job_post_categories(
	id int(10) not null primary key auto_increment,
	jobid int(10),
	categoryid int(10)
);

DROP TABLE IF EXISTS job_applications;
create table job_applications(
	id int(10) not null primary key auto_increment,
	jobid int(10) not null,
	userid int(10) not null,
	date_applied date ,
	applicant_pitch text comment 'job application pitch',
	resume text not null ,
	attachment text
);

DROP TABLE IF EXISTS job_exams;
create table job_exams(
	id int(10) not null primary key auto_increment,
	jobid int(10) not null,
	userid int(10) not null,
	date_created date ,
	title text ,
	sub_title varchar(50),
	exam_time int(10) comment 'exam time on minutes',
	max_time int(10) comment 'max time on minutes',
	rules text comment 'guidelines set by examinator',
	reference text comment 'references for exam',
	status enum('active' , 'inactive') 
);

DROP TABLE IF EXISTS exam_questions;
create table exam_questions(
	id int(10) not null primary key auto_increment,
	examid int(10) not null,
	question text,
	choices text ,
	answer text
);

DROP TABLE IF EXISTS exam_answers;
create table exam_answers(
	id int(10) not null primary key auto_increment,
	examinationid int(10) not null,
	questionid int(10) not null,
	answer char(10),
	remarks enum('correct' , 'incorrect')
);

DROP TABLE IF EXISTS application_examinations;

create table application_examinations(
	id int(10) not null primary key auto_increment,
	applicationid int(10) comment 'points to whoever post an application',
	examid int(10) not null comment 'job_exam id',
	userid int(10) not null ,
	exam_date timestamp default now() ,
	status enum('finis' , 'unfinish'),
	exam_time int(10) not null comment 'exam time on minutes'
);


DROP TABLE IF EXISTS examination_results;
create table examination_results(
	id int(10) not null primary key auto_increment,
	examinationid int(10) not null,
	time_consumed int(10) not null comment 'time on minutes',
	corrects  tinyint(10) not null ,
	incorrects  tinyint(10) not null ,
	result enum('passed' , 'failed'),
	notes text comment 'free notes by examinator'
);


/*9-26-2019*/

alter table job_applications add column attachment_notes varchar(100) after attachment;

/*10/2/2019*/

drop table if exists applicant_educations;
create table applicant_educations(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	highest_attainment varchar(50) not null,
	year char(10) ,
	school varchar(100) not null,
	status enum('active' , 'inactive')
);

drop table if exists work_experiences;
create table work_experiences(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	field varchar(100) ,
	position varchar(100) not null,
	role_description varchar(255) not null,
	date char(10) not null,
	year char(10) not null,
	status enum('active' , 'inactive')
);

alter table applicant_skills drop column name;


/**/

truncate users;
truncate user_informations;
truncate work_experiences;
truncate applicant_educations;
truncate applicant_educations;

/*10/7/2019*/

alter table jobs drop column company;
alter table jobs add column companyid int(10);
-- companies are clients
create table companies(
	id int(10) not null primary key auto_increment,
	username varchar(100) not null unique,
	password varchar(150) not null,
	name varchar(50) not null,
	description text,
	type varchar(150),
	address varchar(150) ,
	email varchar(150) ,
	phone varchar(150) ,
	banner text comment 'picture link',
	logo text comment 'picture link',
	status enum('active' , 'inactive' , 'suspended')
);

--create dummy company

INSERT INTO companies(username , password , name , description , 
type , address , email , phone , banner , logo , status)

VALUES('comp1' , '1111', 'chromatic' ,
' Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur',
'Software Company' , 'A-3 fantail street Qc' , 'email@email.com' , '111111' ,
'companybanner.jpg' , 'companylogo.png' , 'active');

-- this will help company track their employees on the system
-- create table company_employees(
-- 	id int(10) not null primary key ,
-- 	companyid int(10) not null,
-- 	userid int(10) not null,
-- 	date_started date ,
-- 	status enum('active' , 'inactive')
-- );

drop table company_employees;
drop table if exists employees;
create table employees(
	id int(10) not null primary key auto_increment , 
	companyid int(10) not null,
	empcode varchar(15) not null,
	userid int(10) not null,
	date_started date , 
	job_title varchar(100) not null,
	position varchar(100) not null,
	salary decimal(10 , 2) ,
	salary_type enum('per hour' , 'daily' , 'weekly' ,'monthly'),
	status enum('active' , 'inactive')
);

create table employee_jobs(
	id int(10) not null primary key ,
	ceid int(10) not null comment 'this is the primary key of the company employees',
	jobname varchar(100) not null comment 'this will be automatically filled in based on job post title',
	jobdesc text
);

drop table if exists employee_evaluations;
create table employee_evaluations(
	id int(10) not null primary key auto_increment,
	empid int(10) not null comment 'track employee job on the evaluation',
	personal_performance tinyint not null,
	performance_quality tinyint not null,
	punctuality tinyint not null,
	notes text not null
);

alter table jobs drop column status;

alter table jobs add column status enum('for posting' , 'posted' , 'closed');

DROP TABLE IF EXISTS jobs;
create table jobs(
	id int(10) not null primary key auto_increment,
	date_posted date ,
	title varchar(100) ,
	sub_title varchar(50),
	position varchar(50),	
	companyid varchar(50),	
	email varchar(50),	
	phone varchar(50),
	salary decimal(10 ,2),
	salary_type enum('per hour' , 'daily' , 'weekly' ,'monthly'),	
	description text,
	address text,	
	notes text,
	status enum('for posting' , 'posted' , 'closed')
);


create table job_post_notifications(
	id int(10) not null primary key auto_increment,
	jobid int(10) not null,
	subject varchar(150) comment ' This will have job post title and company name',
	message text not null,
	status enum('read' , 'unread'),
);


/*10/6/2019*/

status enum('for posting' , 'posted' , 'closed' , 'cancelled');

alter table job_applications add column status enum('removed' , 'cancelled' , 'active');

alter table job_applications add column label enum('average' , 'recommended' , 'pending' , 'finished');

-- admin dummy 
INSERT INTO users(
	username , password , type , created_at , status
)VALUES('admin' , '1111' , 'Admin' , now() , 'active');

INSERT INTO user_informations(
	userid , firstname , lastname , gender , birthday , nationality , 
	phone , email , address , profile
)VALUES('3' , 'Admin' , 'Tester' , 'Male' , '1998-11-16' , 'Filipino' , 
'09063387451' , 'email@email.com' , 'address' , 'profile')
;


DROP TABLE IF exists applicant_appointments;
create table applicant_appointments(
	id int(10) not null primary key auto_increment , 
	applicationid int(10) not null ,
	jobid int(10) not null,
	userid int(10) not null,
	dateset date , 
	timeset time ,
	subject varchar(100) ,
	message text,
	reciever varchar(100) comment ' this is an email' ,
	status enum('pending' , 'finished' , 'postponed')
);

-- 10/7/2019

alter table applicant_appointments add column remarks
enum('passed' , 'failed');

alter table job_applications drop column label;

alter table job_applications add column 
label enum('priority' , 'for-examination','recommended');

alter table job_applications drop column status;

alter table job_applications add column 
status enum('open' , 'failed' , 'finished');


/*truncate */

truncate applicant_appointments;
truncate job_applications;
truncate employees;
truncate employee_evaluations;


/*10-12-2019*/

alter table job_applications drop column resume;

alter table job_applications add column resume_image text;
alter table job_applications add column resume_text text;

alter table job_applications drop column resume;
alter table job_applications drop column attachment;
alter table job_applications drop column attachment_notes;

alter table employees add column companyid int(10) after 


alter table employee_evaluations add column date_start date after empid;
alter table employee_evaluations add column date_end date after date_start;


ALTER TABLE `job_categories` ADD UNIQUE(`category`);
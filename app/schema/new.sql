/*2019/10/29*/


create table exams(
	id int(10) not null primary key auto_increment,
	name varchar(100) not null unique,
	description varchar(100),
	duration char(5),
	created_at timestamp default now()
);

drop table if exists exam_question_choices_answer;
create table exam_question_choices_answer(
	id int(10) not null primary key auto_increment,
	examid tinyint(10) not null,
	question varchar(255) not null,
	choice_1 varchar(255) not null,
	choice_2 varchar(255) not null,
	choice_3 varchar(255) not null,
	choice_4 varchar(255) not null,
	answer enum('choice_1','choice_2','choice_3','choice_4') not null,
	orderNumber tinyint(10) not null
);


create table jobs_exam(
	id int(10) not null primary key auto_increment,
	jobid int(10) not null ,
	examid int(10) not null,
	status enum('active' ,'inactive') default 'active',
	attached_on timestamp default now()
);

create table user_files(
	id int(10) not null primary key auto_increment,
	title varchar(100),
	userid int(10) not null ,
	type enum('picture' , 'text'),
	filename text
);


drop table if exists employee_evaluations;
create table employee_evaluations(
	id int(10) not null primary key auto_increment,
	date_start date ,
	date_end date,
	companyid int(10) not null,
	empid int(10) not null ,
	criteria varchar(100) not null,
	remarks tinyint(10) not null,
	notes varchar(200) not null,
	status enum('active' , 'inactive')
);

drop table if exists notifications;
create table notifications(
	id int(10) not null primary key auto_increment ,
	reciever int(10) not null,
	sender int(10) not null,
	subject varchar(50) not null ,
	message text ,
	created_at timestamp default now(),
	status enum('read' , 'unread') default 'unread'
);


alter table companies add column contact_person varchar(100) not null;
alter table companies add column contact_number varchar(100) not null;

alter table companies add column permit varchar(100) not null;
alter table companies add column contract varchar(100) not null;



alter table jobs add column created_at timestamp  default now();


alter table jobs add columnd categories varchar(100);


alter table jobs add column urgency enum('low' , 'mid' , 'high') default 'low';



alter table exam_question_choices_answer add column question_img text after question;
alter table exam_question_choices_answer add column image_1 text after choice_4;
alter table exam_question_choices_answer add column image_2 text after image_1;
alter table exam_question_choices_answer add column image_3 text after image_2;
alter table exam_question_choices_answer add column image_4 text after image_3;


truncate application_examinations; truncate exam_answers;




create table job_positions(
	id int(10) not null primary key auto_increment,
	position varchar(100) unique
);

/*NEW JOB FIELDS*/

alter table jobs add column employee_needed int(10);
alter table jobs add column duration date;


alter table jobs_exam add column examnumber tinyint

alter table job_applications drop column status_label;
alter table job_applications add column status_label enum('pending' , 'interview' , 'endorsed' , 'complete' , 'failed') default 'pending';


drop table if exists employee_evaluations;
create table employee_evaluations(
	id int(10) not null primary key auto_increment,
	season varchar(50) not null ,
	companyid int(10) not null,
	empid int(10) not null,
	criteria varchar(100) not null,
	remarks int(10) not null,
	notes text
);
create table job_field_list(
	id int(10) not null primary key auto_increment,
	field varchar(100)
);


create table job_positions(
	id int(10) not null primary key auto_increment,
	position varchar(100)
);

create table business_natures(
	id int(10) not null primary key auto_increment,
	nature varchar(100)
);

alter table employees add column status enum('active' , 'inactive') default 'active';
alter table employees add column notes varchar(150)


alter table employees add column employment_status varchar(50);

/*11/13/2019*/
alter table employees add column emp_type enum('regular' , 'non-regular') default 'non-regular';

create table exam_results(
	id int(10) not null primary key auto_increment,
	examinationid int(10) not null,
	correct int(10) ,
	incorrect int(10),
	score int(10) ,
	remarks enum('failed' , 'passed') default 'passed'
);


drop table if exists applicant_other_educations;
create table applicant_other_educations(
	id int(10) not null primary key auto_increment ,
	userid int(10) not null,
	course varchar(100),
	category varchar(100) ,
	school varchar(100),
	month char(10),
	year char(5),
	description varchar(100)
);

drop table if exists education_categories;
create table education_categories(
	id int(10) not null primary key auto_increment,
	category varchar(50) not null unique
);

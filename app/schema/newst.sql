ALTER TABLE `examination_results` ADD PRIMARY KEY(`id`);
ALTER TABLE `examination_results` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `applicant_appointments` ADD PRIMARY KEY(`id`);
ALTER TABLE `applicant_appointments` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `applicant_educations` ADD PRIMARY KEY(`id`);
ALTER TABLE `applicant_educations` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `applicant_skills` ADD PRIMARY KEY(`id`);
ALTER TABLE `applicant_skills` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `application_examinations` ADD PRIMARY KEY(`id`);
ALTER TABLE `application_examinations` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `application_informations` ADD PRIMARY KEY(`id`);
ALTER TABLE `application_informations` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `business_natures` ADD PRIMARY KEY(`id`);
ALTER TABLE `business_natures` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `companies` ADD PRIMARY KEY(`id`);
ALTER TABLE `companies` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `employees` ADD PRIMARY KEY(`id`);
ALTER TABLE `employees` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `employee_evaluations` ADD PRIMARY KEY(`id`);
ALTER TABLE `employee_evaluations` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `employee_jobs` ADD PRIMARY KEY(`id`);
ALTER TABLE `employee_jobs` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `examinations` ADD PRIMARY KEY(`id`);
ALTER TABLE `examinations` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


#################

ALTER TABLE `exams` ADD PRIMARY KEY(`id`);
ALTER TABLE `exams` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `exam_answers` ADD PRIMARY KEY(`id`);
ALTER TABLE `exam_answers` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `exam_questions` ADD PRIMARY KEY(`id`);
ALTER TABLE `exam_questions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `exam_question_choices_answer` ADD PRIMARY KEY(`id`);
ALTER TABLE `exam_question_choices_answer` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `jobs` ADD PRIMARY KEY(`id`);
ALTER TABLE `jobs` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `jobs_exam` ADD PRIMARY KEY(`id`);
ALTER TABLE `jobs_exam` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `job_applications` ADD PRIMARY KEY(`id`);
ALTER TABLE `job_applications` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `job_categories` ADD PRIMARY KEY(`id`);
ALTER TABLE `job_categories` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `job_positions` ADD PRIMARY KEY(`id`);
ALTER TABLE `job_positions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `job_post_categories` ADD PRIMARY KEY(`id`);
ALTER TABLE `job_post_categories` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `notifications` ADD PRIMARY KEY(`id`);
ALTER TABLE `notifications` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `users` ADD PRIMARY KEY(`id`);
ALTER TABLE `users` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `user_files` ADD PRIMARY KEY(`id`);
ALTER TABLE `user_files` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `work_experiences` ADD PRIMARY KEY(`id`);
ALTER TABLE `work_experiences` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;

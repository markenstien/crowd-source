alter table users add column is_verified boolean default false;


-- created for confirming initial client registration

create table registration_confirmation_tokens(
	id int(10) not null primary key auto_increment,
	user_id int(10) not null ,
	token varchar(50),
	is_used boolean default false,
	created_at timestamp default now(),
	updated_at datetime default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


alter table users add column done_setup boolean default false;
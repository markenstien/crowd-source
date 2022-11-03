drop table if exists notifications;
create table notifications(
	id int(10) not null primary key auto_increment,
	notification text,
	link text,
	sender_id int(10),
	meta_id int(10),
	meta_key varchar(100) comment 'notification module',
	category enum('info' , 'success' , 'primary' , 'default' , 'danger' , 'warning') default 'default',
	is_read boolean default false,
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
	
);
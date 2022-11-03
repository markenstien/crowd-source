
insert into users(
	username , password , type ,
	status , is_verified , done_setup
) VALUES('guest' , 'guest123' , 'Admin' , 'active' , true , true ),
('mt_guest' , 'guest123' , 'admin' ,  'active' , true , true );


insert into user_informations(
	userid , firstname , lastname ,
	gender, birthday , nationality,
	phone , email , address
)VALUES(
	1 , 'Monster' , 'Thesis Dept' ,
	'male' , '11-16-1998' , 'filipino',
	'10101010101' , 'demo@monsterthesis.com' , 'area-3 fantail street sitio veterans brgy. bagong silangan QC.'
),
(
	2 , 'Monster' , 'Thesis Dept' ,
	'male' , '11-16-1998' , 'filipino',
	'10101010101' , 'sales@monsterthesis.com' , 'area-3 fantail street sitio veterans brgy. bagong silangan QC.'
)
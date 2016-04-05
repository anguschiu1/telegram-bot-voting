-- for mysql

create table question (
  user_id int(11) not null,
  q1 varchar(1),
  q2 int,
  q3 int,
  ip varchar(46),
  create_date timestamp not null,
  last_modified_date timestamp not null,
  primary key (user_id)
) default charset=utf8;



create table voter (
  user_id int(11) not null,
  user_name varchar(255),
  first_name varchar(255) not null,
  last_name varchar(255) ,
  ip varchar(46),
  create_date timestamp not null,
  last_modified_date timestamp not null,
  primary key (user_id)
) default charset=utf8;
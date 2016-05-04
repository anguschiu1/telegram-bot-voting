-- for mysql

create table question (
    user_id int(11) not null,
    q1 varchar(1),
    q2 int,
    q3 int,
    q4 int,
    q5 int,
    q6 int,
    q7 int,
    q8 varchar(1),
    q9 int,
    q10 int,
    q11 int,
    q12 varchar(1),
    q13 varchar(10),
    q14 int,
    q15 int,
    round int not null default 1,
    ip varchar(46),
    create_date timestamp not null DEFAULT '0000-00-00 00:00:00',
    last_modified_date timestamp not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (user_id)
) default charset=utf8;



create table voter (
    user_id int(11) not null,
    user_name varchar(255),
    first_name varchar(255) not null,
    last_name varchar(255) ,
    chat_id int not null,
    member_type int not null default -100,
    authorized varchar(1) not null default 'N',
    lang varchar(2) not null default 'tc',
    stage varchar(50) not null default 'UNAUTHORIZED',
    voter_info int,
    age varchar(10),
    job int,
    ip varchar(46),
    create_date timestamp not null DEFAULT '0000-00-00 00:00:00',
    last_modified_date timestamp not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (user_id)
) default charset=utf8;

create table invitation (
    id int not null auto_increment,
    link varchar(20) not null,
    quota int not null,
    member_type int not null default -100,
    create_user_id int(11) not null,
    expire_date timestamp not null,
    create_date timestamp not null DEFAULT '0000-00-00 00:00:00',
    last_modified_date timestamp not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (id)
);

create table invitation_user(
    invitation_id int not null,
    user_id int not null,
    create_date timestamp not null DEFAULT '0000-00-00 00:00:00',
    last_modified_date timestamp not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key (invitation_id, user_id)
);


create table audit_log(
    id int not null auto_increment,
    message text not null,
    create_date timestamp not null DEFAULT '0000-00-00 00:00:00',
    last_modified_date timestamp not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id)
);
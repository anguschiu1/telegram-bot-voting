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
    chat_id int not null,
    member_type int not null default -100,
    authorized varchar(1) not null default 'N',
    ip varchar(46),
    create_date timestamp not null,
    last_modified_date timestamp not null,
    primary key (user_id)
) default charset=utf8;

create table invitation (
    id int not null auto_increment,
    link varchar(20) not null,
    quota int not null,
    member_type int not null default -100,
    create_user_id int(11) not null,
    expire_date timestamp not null,
    create_date timestamp not null,
    last_modified_date timestamp not null,
    primary key (id)
);

create table invitation_user(
    invitation_id int not null,
    user_id int not null,
    create_date timestamp not null,
    last_modified_date timestamp not null,
    primary key (invitation_id, user_id)
);

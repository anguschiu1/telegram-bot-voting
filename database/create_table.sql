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
    lang varchar(2) not null default 'tc',
    stage varchar(50) not null default 'UNAUTHORIZED',
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

create table bulk (
    bulk_id int not null,
    chat_id int not null,
    lang varchar(2) not null default 'tc',
    status int(1) not null default 1, -- 0=Done, 1=Create, 2=Processing, 3=Error
    last_modified_date timestamp not null default CURRENT_TIMESTAMP
);

create table media_content (
    bulk_id int not null,
    media_type int(1) not null default 1,
        -- 1=Text Message, 2=Photo, 3=Audio, 4=Document, 5=Sticker, 6=Video, 7=Voice, 8=Venue, 9=Contact, 10=ChatAction
        -- Please don't declare multiple type in same bulk_id
    lang varchar(2) not null default '*', -- * means all languages
    media_content varchar(5000),
    media_status int not null default 1
        -- 0=DISABLED, 1=INIT, 2=SAMPLE, 3=APPROVED
        --      INIT - Ready for sending sample for review
        --      SAMPLE - After sample sendout
        --      APPROVED - Available for bulk sending
        --      DISABLED - Bulk sending job will ignore the record, any status can change to DISABLED
        -- Media Lifecycle: INIT --> SAMPLE --> APPROVED
);

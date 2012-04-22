-- Track database definition.



use track;



begin



drop table if exists users;

create table users (

    id              int             not null primary key auto_increment,

    name            varchar(40)     default '' not null,

    email_id        varchar(100)    default '' not null,

    password        varchar(100)    default '' not null comment 'MDS of plain text.',

    role            enum            ('admin', 'engineer', 'client') default 'engineer',

    active          tinyint         default '1' not null

);

create index ix_users_name on users (name);



-- update users set role='admin' where id=1;



drop table if exists category;

create table category (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default '' not null,

    notes          text            default '' not null

);

create index ix_category_name on category (name);



drop table if exists severity;

create table severity (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default '' not null,

    notes          text            default ''  not null

);

create index ix_severity_name on severity (name);



drop table if exists status;

create table status (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default '' not null,

    notes          text            default '' not null

);

create index ix_status_name on status (name);



drop table if exists priority;

create table priority (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default '' not null,

    notes          text            default '' not null

);

create index ix_priority_name on priority (name);



drop table if exists primetrack;

create table primetrack (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default ''  not null,

    notes          text            default ''  not null

);

create index ix_primetrack_name on primetrack (name);



drop table if exists component;

create table component (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default ''  not null,

    notes          text            default ''  not null

);

create index ix_component_name on component (name);



drop table if exists resolution;

create table resolution (

    id             int             not null primary key auto_increment,

    name           varchar(40)     default ''  not null,

    notes          text            default ''  not null

);

create index ix_resolution_name on resolution (name);



drop table if exists tasklist;

create table tasklist (

    id                      int             not null primary key auto_increment,

    title                   varchar(60)     default '' not null,

    category_id             int             not null references category(id),

    priority_id             int             not null references priority(id),

    severity_id             int             not null references severity(id),

    status_id               int             not null references status(id),

    detected_by_id          int             not null references users(id),

    assigned_to_id          int             not null references users(id),

    component_id            int             not null references component(id),

    prime_track_id          int             not null references primetrack(id),

    resolution_id           int             not null references resolution(id),

    planned_close_date      date            not null,

    notes                   text            default ''  not null

);

create index ix_tasklist_cat on tasklist (category_id);

create index ix_tasklist_prior on tasklist (priority_id);

create index ix_tasklist_sevr on tasklist (severity_id);

create index ix_tasklist_stat on tasklist (status_id);

create index ix_tasklist_detb on tasklist (detected_by_id);

create index ix_tasklist_asst on tasklist (assigned_to_id);

create index ix_tasklist_cmpt on tasklist (component_id);

create index ix_tasklist_prtr on tasklist (prime_track_id);

create index ix_tasklist_resol on tasklist (resolution_id);



drop table if exists usertrack;

create table usertrack (

    id              int             not null primary key auto_increment,

    user_id         int             not null references users (id),

    track_id        int             not null references primetrack (id)

);

create index ix_ut_ut on usertrack (user_id, track_id);

create index ix_ut_tu on usertrack (track_id, user_id);



-- Sample tasklist row.

insert into tasklist values(1,'User record is not saved correctly.',

    1,1,1,1,1,2,1,1,1,now(),'User record is not saved correctly.');

insert into tasklist values(2,'Component record not accepting notes.',

    3,4,2,3,1,2,3,1,1,now(),'Component record not accepting notes.');

-- Resolution status to open for all defect/issues record.

update tasklist set resolution_id=1;



insert into category (id, name) values (1, 'Code defect');

insert into category (id, name) values (2, 'Build program');

insert into category (id, name) values (3, 'Feature request');

insert into category (id, name) values (4, 'Documentation');

insert into category (id, name) values (5, 'Incident');



insert into severity (id, name) values (1, 'Critical');

insert into severity (id, name) values (2, 'Severe');

insert into severity (id, name) values (3, 'Important');

insert into severity (id, name) values (4, 'Minor');

insert into severity (id, name) values (5, 'Cosmetic');



insert into status (id, name) values (1, 'Open');

insert into status (id, name) values (2, 'Closed');

insert into status (id, name) values (3, 'Fixed');

insert into status (id, name) values (4, 'Verified');

insert into status (id, name) values (5, 'Reviewed');

insert into status (id, name) values (6, 'Deferred');

insert into status (id, name) values (7, 'Tested');

insert into status (id, name) values (8, 'Reopen');



insert into priority (id, name) values (1, 'Immediate');

insert into priority (id, name) values (2, 'High');

insert into priority (id, name) values (3, 'Medium');

insert into priority (id, name) values (4, 'Low');

insert into priority (id, name) values (5, 'Zero');



insert into resolution (id, name) values (1, 'Open');

insert into resolution (id, name) values (2, 'Fixed');

insert into resolution (id, name) values (3, 'Rejected');

insert into resolution (id, name) values (4, 'Workaround');

insert into resolution (id, name) values (5, 'Unable to reproduce');

insert into resolution (id, name) values (6, 'Works as designed');

insert into resolution (id, name) values (7, 'External bug');

insert into resolution (id, name) values (8, 'Not a bug');

insert into resolution (id, name) values (9, 'Duplicate');

insert into resolution (id, name) values (10, 'Overcome by events');

insert into resolution (id, name) values (11, 'Drive by patch');

insert into resolution (id, name) values (12, 'Misconfiguration');



insert into users (id, name, email_id, password, role) values (1, 'Raman', 'raman@company.com', md5('raman'), 'admin');

insert into users (id, name, email_id, password) values (2, 'Mohan', 'mohan@company.com', md5('mohan'));

insert into users (id, name, email_id, password) values (3, 'Suresh', 'suresh@company.com', md5('suresh'));

insert into users (id, name, email_id, password) values (4, 'Ramesh', 'ramesh@company.com', md5('ramesh'));

insert into users (id, name, email_id, password) values (5, 'Venkat', 'venkat@company.com', md5('venkat'));



commit;



-- User/Track mapping.

-- select ut.*, u.name as uname, t.name as tname from usertrack ut, users u,

-- primetrack t where ut.user_id=u.id and ut.track_id=t.id order by uname;


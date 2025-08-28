create database hospital_db collate utf8mb4_general_ci;

create table room
(
    room_num      int                    primary key            not null,
    type          varchar(50)                        not null,
    description   varchar(500)                       not null,
    capacity      int      default 0                 not null,
    image         varchar(500)                       not null,
    price         decimal(10, 2)                     not null,
    available_yn  char     default 'Y'               null,
    created_date  datetime default CURRENT_TIMESTAMP null,
    modified_date datetime default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create table user
(
    email           varchar(100)         primary key              not null,
    name            varchar(100)                       not null,
    password        varchar(255)                       not null,
    role            varchar(20)                        not null,
    last_login_date datetime                           null,
    created_date    datetime default CURRENT_TIMESTAMP null,
    modified_date   datetime default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create table reservation
(
    id            int auto_increment primary key not null,
    user_email       varchar(100)                                not null,
    room_num       int                                not null,
    memo           varchar(500)                       null,
    status        varchar(20)                        not null comment 'hold, pending, confirmed, checked_in, checked_out, cancelled',
    created_date  datetime default CURRENT_TIMESTAMP null,
    modified_date datetime default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    constraint reservation_ibfk_1
        foreign key (user_email) references user (email),
    constraint reservation_ibfk_2
        foreign key (room_num) references room (room_num)   
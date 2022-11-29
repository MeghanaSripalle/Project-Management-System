create database Apple;
use Apple;

create table if not exists Employee(
    emp_id varchar(5),
    emp_name varchar(20) not null,
    emp_post varchar(20) not null,
    phone_no varchar(10),
    email varchar(40),
    primary key (emp_id)
);

create table if not exists User_Employee(
    user_id varchar(5),
    username varchar(20) not null,
    pass varchar(20) not null,
    emp_id varchar(5),
    primary key (user_id),
    foreign key (emp_id) references Employee(emp_id)
	on delete cascade
);

create table if not exists Manager(
    manager_id varchar(5),
    manager_name varchar(20)not null,
    phone_no varchar(10),
    email varchar(40),
    primary key (manager_id)
);

create table if not exists User_Manager(
    user_id varchar(5),
    username varchar(20) not null,
    pass varchar(20) not null,
    manager_id varchar(5),
    primary key (user_id),
    foreign key (manager_id) references Manager(manager_id)
	on delete cascade
);

create table if not exists Projects(
    project_id varchar(5),
    project_name varchar(30) not null,
    -- emp_id varchar(5),
    -- manager_id varchar(5),
    prereq varchar(80),
    details varchar(100),
    due_date varchar(10),
    primary key (project_id)
    -- foreign key (manager_id) references Manager(manager_id)
	-- on delete cascade,
    -- foreign key (emp_id) references Employee(emp_id)
	-- on delete cascade
    
);

create table if not exists Assigned(
    project_id varchar(5),
    manager_id varchar(5),
    emp_id varchar(5),
    primary key (project_id,manager_id,emp_id),
    foreign key (project_id) references Projects(project_id)
	on delete cascade,
    foreign key (manager_id) references Manager(manager_id)
	on delete cascade,
    foreign key (emp_id) references Employee(emp_id)
	on delete cascade
);

-- create table if not exists Deadlines(
--     project_id varchar(5),
--     due_date varchar(10),
--     primary key (project_id),
--     foreign key (project_id) references Projects(project_id)
-- 	on delete cascade
  
-- );

create table if not exists Skills(
    emp_id varchar(5),
    skill varchar(50) ,
    primary key (emp_id,skill),
    foreign key (emp_id) references Employee(emp_id)
	on delete cascade

);

create table if not exists Updates(
    project_id varchar(5),
    emp_id varchar(5),
    updates varchar(100) not null,
    update_date varchar(10),
    primary key (project_id,emp_id,update_date),
    foreign key (project_id) references Projects(project_id)
	on delete cascade,
    foreign key (emp_id) references Employee(emp_id)
	on delete cascade
    
);








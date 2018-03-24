--Eric Mott
--Team HotSauce
--Hackathon 2018

drop table org_account cascade constraints;
drop table event cascade constraints;
drop table volunteer cascade constraints;
drop table org_has_event cascade constraints;
drop table vol_for_event cascade constraints;

--Used to hold all of the data for the Organizations
create table org_account
(org_id			int not null,
 org_username	varchar(15) not null,
 org_password	varchar(40) not null,
 org_name 		varchar(50),
 org_address 	varchar(50),
 org_phone_num	char(10),
 org_url		varchar(50),
 primary key 	(org_id)
 );
 
--Used to hold all of the data for the events
create table event
(event_id		int not null,
 event_name varchar(50) not null,
 event_description varchar(140),
 event_date	varchar(20),
 event_time	varchar(10),
 event_loc		varchar(50),
 event_address	varchar(75),
 event_city 	varchar(50),
 event_state	varchar(50),
 event_zip		varchar(50),
 primary key 	(event_id)
 );
  
--Used to hold all of the data for volunteers
create table volunteer
(vol_id 		int not null,
 vol_email		varchar(50),
 primary key	(vol_id)
 );

--Used for connecting an organization to a event
create table org_has_event
(org_id		 	int not null,
 event_id		int not null,
 primary key	(org_id, event_id),
 foreign key	(org_id) references org_account(org_id),
 foreign key	(event_id) references event(event_id)
 );
 
--Used for connecting a volunteer to an event
create table vol_for_event
(vol_id			int not null,
 event_id		int not null,
 primary key	(vol_id, event_id),
 foreign key 	(vol_id) references volunteer(vol_id),
 foreign key	(event_id) references event(event_id) 
 );

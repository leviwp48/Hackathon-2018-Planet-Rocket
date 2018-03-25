--Eric Mott
--Team HotSauce
--Hackathon 2018


delete from org_has_event;
delete from vol_for_event;
delete from org_account;
delete from event;
delete from volunteer;

insert into org_account
values
(1111, 'test1', 'password1', 'Planet Rocket', 'Arcata, CA', '7071234567', 'www.planetrocket.com');

insert into org_account
values
(2222, 'test2', 'password2', 'Red Cross', 'Eureka, CA', '7072222222', 'www.redcross.org');

insert into org_account
values
(3333, 'test3', 'password3', 'Greenpeace', 'McKinleyville, CA', '7071111111', 'www.greenpeace.org');

insert into org_account
values
(4444, 'test4', 'password4', 'Friends of the Dunes', '220 Stamps Ln, Arcata, CA 95521', '7077654321', 'www.friendsofthedunes.org');

insert into event
values
(1111, 'Test Event 1', 'This event is for blah blah blah', '31-MAR-2018 17:00', '1 Harpst St', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(2222, 'Test Event 2', 'This event is for blah blah blah', '20-APR-2018 10:00', '569 S G St', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(3333, 'Test Event 3', 'This event is for blah blah blah', '29-JUL-2018 17:00', 'Arcata Community Forest', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(4444, 'Test Event 4', 'This event is for blah blah blah', '21-MAY-2018 12:00', 'Sunny Brea', 'Arcata', 'CA',
 '95521');
 
 insert into org_has_event
 values
 (1111, 1111);
 
 insert into org_has_event
 values
 (2222, 2222);
 
 insert into org_has_event
 values
 (3333, 3333);
 
 insert into org_has_event
 values
 (4444, 4444);
 
 
 /*
 select *
 from org_account;
 
 select *
 from event;
 
 select *
 from org_has_event;
 */

--Eric Mott, Alec Levin
--Team HotSauce
--Hackathon 2018 


delete from org_has_event;
delete from vol_for_event;
delete from org_account;
delete from event;
delete from volunteer;
 insert into org_account
 values
 (1452, 'arl505', '1234', 'Lumber',
 '355 Granite Ave', '7078225555', 'humboldt.edu');
 
 insert into org_account
 values
 (1612, 'arl', '1234', 'Hacks',
 '355 Granite Ave', '7078225555', 'humboldt.edu');
 
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
 (5153, 'Alecs two owner test', 
 'This is an event to test if the title displays two different owners from the database', 
 sysdate, '1o clock', '2232 Baldwin St', 'Arcata', 'CA', '95521');

insert into event
values
(1111, 'Test Event 1', 'This event is for startups', '31-MAR-2018', '4:00 pm', '1 Harpst St', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(2222, 'Test Event 2', 'Blood donation event in Arcata', '20-APR-2018', '10:00 AM', '569 S G St', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(3333, 'Test Event 3', 'This is forest restoration volunteering', '29-JUL-2018',  '12:30 P.M.', 'Arcata Community Forest', 'Arcata', 'CA',
 '95521');
 
insert into event
values
(4444, 'Test Event 4', 'Beach Nature Walk And Trash Pickup', '21-MAY-2018',  '7:00 am', 'Sunny Brea', 'Arcata', 'CA',
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
 
  insert into org_has_event
 values
 (1452, 5153);
 
 insert into org_has_event
 values
 (1612, 5153);

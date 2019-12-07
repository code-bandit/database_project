drop function changecrossfaculty;
drop function changehod;
drop trigger delete_hod on currenthod;
drop trigger delete_cross on currentcrossfaculty;

create or replace function changecrossfaculty(newid varchar(50), newdesignation varchar (50))
	returns void as $$
	declare
		count_previous_cross integer;
		
	begin
		select count(designation) into count_previous_cross from currentcrossfaculty where designation = newdesignation;
		
		if(count_previous_cross = 1) then
			update currentcrossfaculty set id = newid, starttime = now() where designation = newdesignation;
			
		else
			insert into currentcrossfaculty (id,designation,starttime) values (newid,newdisgnation,now());
			
		end if;
		
	end;
	$$ language plpgsql;
	
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


create or replace function changehod(newid varchar(50),newdepartment varchar (20))
	returns void as $$
	declare
		count_previous_hod integer;
		
	begin
		select count (department) into count_previous_hod from currenthod where department = newdepartment;
		
		if(count_previous_hod = 1) then
			update currenthod set id = newid, starttime = now() where department = newdepartment;
			
		else
			insert into currenthod (id,department,starttime) values (newid,newdepartment,now());
			
		end if;
	
	end;
	$$ language plpgsql;
	
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create or replace function hod_delete()
	returns trigger as $$
	
	begin
		insert into pasthod (id,department,starttime,endtime) values (old.id,old.department,old.starttime,now());
		
		return old;
		
	end;
	$$ language plpgsql;
	
create trigger delete_hod
	before delete
	on currenthod
	for each row
	execute procedure hod_delete();
	
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create or replace function cross_delete()
	returns trigger as $$
	
	begin
		insert into pastcrossfaculty (id,designation,starttime,endtime) values (old.id,old.designation,old.starttime,now());
		
		return old;
		
	end;
	$$ language plpgsql;
	
create trigger delete_cross
	before delete
	on currentcrossfaculty
	for each row
	execute procedure cross_delete();

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

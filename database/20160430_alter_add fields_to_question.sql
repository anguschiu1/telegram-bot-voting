alter table question add column q4 int, add column q5 int,  add column q6 int,  add column q7 int,  add column q8 varchar(1),  add column q9 int,  add column q10 int,  add column q11 int,  add column q12 varchar(1),  add column q13 varchar(10), add column q14 int, add column q15 int;
alter table voter add column voter2012 int, add column is_voter int, add column age varchar(10), add column job int;


alter table question modify column q13 varchar(10);
alter table voter modify column age varchar(10);
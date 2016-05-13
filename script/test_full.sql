use votsonar;
SET @bulk_id = 100;
insert into bulk(bulk_id, chat_id, lang, status) select @bulk_id, chat_id, lang, 0 from voter;

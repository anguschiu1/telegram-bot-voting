use votsonar;
INSERT INTO `bulk` (`bulk_id`, `chat_id`, `lang`, `status`, `last_modified_date`) VALUES (2, 198674682, 'tc', 0, CURRENT_TIMESTAMP);
INSERT INTO `bulk` (`bulk_id`, `chat_id`, `lang`, `status`, `last_modified_date`) VALUES (2, 198674682, 'en', 0, CURRENT_TIMESTAMP);
select count(1) from `bulk` where chat_id = 198674682;

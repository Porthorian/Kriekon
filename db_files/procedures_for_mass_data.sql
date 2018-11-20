USE kriekon;
DELIMITER //
	DROP PROCEDURE IF EXISTS mass_data;
    CREATE PROCEDURE mass_data()
	BEGIN
		DECLARE x	INT DEFAULT 0;
        DECLARE i	INT DEFAULT 1;
        WHILE x <= 1000 DO
			WHILE i<= 180 DO
				INSERT INTO forum_replies (reply_id, thread_id, user_id, reply_author, reply_content, reply_date) VALUES (x, i, 1, 'Marone', 'Hi I just populated your mother', CURRENT_TIMESTAMP());
				SET i = i + 1;
            END WHILE;
			SET x = x + 1;
		END WHILE;
END//

call mass_data();
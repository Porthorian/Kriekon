DROP DATABASE IF EXISTS kriekon;
CREATE DATABASE kriekon;
USE kriekon;

CREATE TABLE users
(
	user_id			INT				PRIMARY KEY		AUTO_INCREMENT,
    user_first		VARCHAR(45)		NULL,
    user_last		VARCHAR(45)		NULL,
    user_email		VARCHAR(255)	NOT NULL,
    user_DOB		DATE			NOT NULL,
    user_username	VARCHAR(45)		NOT NULL,
    user_password	VARCHAR(255)	NOT NULL,
    user_regTime	DATETIME		NOT NULL,
    user_timezone   VARCHAR(120)    NULL,
    user_loginTime	DATETIME		NULL,
    user_ip_address	VARCHAR(120)	NULL,
    user_avatar		VARCHAR(255)	NULL,
    logged_in		INT				DEFAULT 0
);

CREATE TABLE steamdata
(
	userid			INT		PRIMARY KEY		NOT NULL,
    steamid			VARCHAR(255)			DEFAULT NULL,
    personaname		VARCHAR(255)			DEFAULT NULL,
    profileurl		VARCHAR(255)			DEFAULT NULL,
    avatarfull		varchar(255)			DEFAULT NULL,
    timecreated		VARCHAR(255)			DEFAULT NULL,
    loccountrycode	VARCHAR(255)			DEFAULT NULL,
    
    CONSTRAINT steamdata_userid_fk_user_user_id
		FOREIGN KEY(userid)
        REFERENCES users(user_id)
);
    
CREATE TABLE permissions
(
    permission_id       INT             PRIMARY KEY     AUTO_INCREMENT,
    permission_name     VARCHAR(120)    NOT NULL
);

CREATE TABLE tags
(
    tag_id              INT             PRIMARY KEY     AUTO_INCREMENT,
    tag_name            VARCHAR(120)    NOT NULL
);

CREATE TABLE tag_permissions
(
    tag_permission_id           INT             PRIMARY KEY     AUTO_INCREMENT,
    tag_id                      INT             NOT NULL,
    permission_id               INT             NOT NULL,

    CONSTRAINT tag_perm_tag_id_fk
        FOREIGN KEY (tag_id)
        REFERENCES tags(tag_id),
    CONSTRAINT tag_perm_perm_id_fk
        FOREIGN KEY (permission_id)
        REFERENCES permissions(permission_id)         
);

CREATE TABLE tag_user
(
    tag_user_id         INT             PRIMARY KEY     AUTO_INCREMENT,
    tag_id              INT             NOT NULL,
    user_id             INT             NOT NULL,

    CONSTRAINT tag_user_tag_id_fk
        FOREIGN KEY (tag_id)
        REFERENCES tags(tag_id),
    CONSTRAINT tag_user_user_id_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

CREATE TABLE permission_user
(
    permission_user_id         INT             PRIMARY KEY     AUTO_INCREMENT,
    permission_id              INT             NOT NULL,
    user_id                    INT             NOT NULL,

    CONSTRAINT permission_user_perm_id_fk
        FOREIGN KEY (permission_id)
        REFERENCES permissions(permission_id),
    CONSTRAINT permission_user_user_id_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

CREATE TABLE banned_users
(
	banned_user_id		INT				PRIMARY KEY		AUTO_INCREMENT,
    user_id				INT				NOT NULL,
    banned_reason		VARCHAR(120)	NOT NULL,
    banned_time			DATETIME		NOT NULL,
    
    CONSTRAINT banned_users_fk
		FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);


CREATE TABLE forum
(
	forum_id			INT			PRIMARY KEY			AUTO_INCREMENT,
    forum_name			VARCHAR(40)	NOT NULL
);

CREATE TABLE forum_category
(
	category_id			INT					PRIMARY KEY		AUTO_INCREMENT,
    forum_id			INT					NOT NULL,
    category_name			VARCHAR(120)		NOT NULL,
    category_description		VARCHAR(120)		NULL,
    
    CONSTRAINT forum_category_fk
		FOREIGN KEY(forum_id)
        REFERENCES forum(forum_id)
);


CREATE TABLE forum_thread
(
	thread_id			INT 			PRIMARY KEY		AUTO_INCREMENT,
	category_id			INT				NOT NULL,
    user_id				INT				NOT NULL,
    thread_author		VARCHAR(45)		NOT NULL,
    thread_subject		VARCHAR(80)		NOT NULL,
    thread_description	VARCHAR(120)	NULL,
    thread_content		LONGTEXT		NOT NULL,
    thread_date			DATETIME		NOT NULL,
    thread_modTime		DATETIME		NULL,
    
    CONSTRAINT forum_thread_user_id_fk
		FOREIGN KEY(user_id)
        REFERENCES users(user_id),
	CONSTRAINT forum_thread_category_fk
		FOREIGN KEY(category_id)
        REFERENCES forum_category(category_id)
);

CREATE TABLE forum_replies
(
	reply_id		INT				PRIMARY KEY		AUTO_INCREMENT,
    thread_id		INT 			NOT NULL,
    user_id			INT				NOT NULL,
    reply_parent_id INT				DEFAULT 0,
    reply_author	VARCHAR(45)		NOT NULL,
    reply_content	VARCHAR(250)	NOT NULL,
    reply_date		DATETIME		NOT NULL,
    reply_modTime	DATETIME		NULL,
    reply_upvotes	INT				DEFAULT 0,
    reply_downvotes	INT				DEFAULT 0,
    
    CONSTRAINT forum_replies_threads_fk
		FOREIGN KEY(thread_id)
        REFERENCES forum_thread(thread_id),
	CONSTRAINT forum_replies_user_fk
		FOREIGN KEY(user_id)
        REFERENCES users(user_id)        
    
);
CREATE TABLE forum_upvote_downvote
(
    upvote_downvote_id      INT             PRIMARY KEY     AUTO_INCREMENT,
    user_id                 INT             NOT NULL,
    thread_id               INT             NULL,
    reply_id                INT             NULL,
    upvote_downvote_time	DATETIME		NOT NULL,
    upvoted                 TINYINT         DEFAULT 0,
    downvoted               TINYINT         DEFAULT 0,

    CONSTRAINT like_dislike_user_id_fk
        FOREIGN KEY(user_id)
        REFERENCES users(user_id),
    CONSTRAINT like_dislike_thread_id_fk
        FOREIGN KEY(thread_id)
        REFERENCES forum_thread(thread_id),
    CONSTRAINT like_dislike_reply_id_fk
        FOREIGN KEY(reply_id)
        REFERENCES forum_replies(reply_id)

);

CREATE TABLE article_system
(
	article_system_id			INT					PRIMARY KEY			AUTO_INCREMENT,
    article_system_name			VARCHAR(45)			UNIQUE KEY			NOT NULL
);
CREATE TABLE article_supercategory
(
	article_superCat_id				INT					PRIMARY KEY			AUTO_INCREMENT,
    article_system_id				INT					NOT NULL,
    article_superCat_name			VARCHAR(45)			NOT NULL,
    article_superCat_description	VARCHAR(80)			NOT NULL,
    
    CONSTRAINT article_superCategory_article_system_fk
		FOREIGN KEY(article_system_id)
        REFERENCES article_system(article_system_id)
);


CREATE TABLE article_tags #Creating Tags to Group Articles By. Also has a trending column, front end will be something difficult but if 1 will be considered trending. If 0 Not Trending. Trending Date is there to gauge when it was marked as trending.
(
    tag_id					INT				PRIMARY KEY		AUTO_INCREMENT,
    tag_name				VARCHAR(45)		UNIQUE KEY 		NOT NULL,
    trending				TINYINT			DEFAULT 0,
    trending_date			DATETIME		NULL
);


CREATE TABLE articles
(
	article_id				INT				PRIMARY KEY		AUTO_INCREMENT,
    user_id					INT				NOT NULL,
    article_superCat_id		INT				NOT NULL,
    article_title			VARCHAR(45)		NOT NULL,
    article_date			DATETIME		NOT NULL,
    article_author			VARCHAR(45)		NOT NULL,
    article_content			LONGTEXT		NOT NULL,
    article_modTime			DATETIME		NULL,
    article_modName			VARCHAR(45)		NULL,
    upvotes					SMALLINT		DEFAULT 0,
    downvotes				SMALLINT		DEFAULT 0,
    #frequency				INT				DEFAULT 0,
    #confidence				INT				DEFAULT 0,
    #score					INT				DEFAULT 0,
    featured				SMALLINT		DEFAULT 0,
    
    CONSTRAINT article_author_fk
		FOREIGN KEY(user_id)
		REFERENCES users(user_id),
        
	CONSTRAINT article_superCat_id_fk
		FOREIGN KEY(article_superCat_id)
        REFERENCES article_superCategory(article_superCat_id)
);

CREATE TABLE article_tag_link
(
	tag_link_id				INT				PRIMARY KEY		AUTO_INCREMENT,
    tag_id					INT				NOT NULL,
    article_id				INT				NOT NULL,
    
    CONSTRAINT tag_link_tag_id_fk
		FOREIGN KEY(tag_id)
        REFERENCES article_tags(tag_id),
	
    CONSTRAINT tag_link_article_id_fk
		FOREIGN KEY(article_id)
        REFERENCES articles(article_id)
);


    

CREATE TABLE article_comments
(
	comment_id			INT				PRIMARY KEY			AUTO_INCREMENT,
    article_id			INT				NOT NULL,
    user_id				INT				NOT NULL,
    comment_author		VARCHAR(45)		NOT NULL,
    comment_date		DATETIME		NOT NULL,
    comment_content		VARCHAR(200)	NOT NULL,
    comment_modTime		DATETIME		NULL,
    comment_modName		DATETIME		NULL,
    
    CONSTRAINT article_comments_fk
		FOREIGN KEY(article_id)
        REFERENCES articles(article_id),
	CONSTRAINT comments_author_fk
		FOREIGN KEY(user_id)
        REFERENCES users(user_id)
);
CREATE TABLE article_upvote_downvote
(
	article_upvote_downvote_id		INT				PRIMARY KEY			AUTO_INCREMENT,
    article_id						INT				NOT NULL,
    user_id							INT				NOT NULL,
    upvote_downvote_time			DATETIME		NOT NULL,
    upvoted							TINYINT				DEFAULT 0,
    downvoted						TINYINT				DEFAULT 0,
    
    CONSTRAINT article_trending_system_article_id_fk
		FOREIGN KEY(article_id)
        REFERENCES articles(article_id),
	CONSTRAINT article_trending_system_user_id_fk
		FOREIGN KEY(user_id)
        REFERENCES users(user_id)
);

CREATE TABLE article_images #Just starting to theorize how we are going to do this with the MVC framework.
(
	uploads_id			INT					PRIMARY KEY			AUTO_INCREMENT,
    article_id			INT					NULL,
    image_path			VARCHAR(255)		NULL,
    image_size			VARCHAR(40)			NULL,
    
    CONSTRAINT article_images_article_id_fk
		FOREIGN KEY(article_id)
        REFERENCES articles(article_id)
);

CREATE TABLE user_avatars
(
	user_avatars_id		INT					PRIMARY KEY			AUTO_INCREMENT,
    user_id				INT					NULL,
    avatar_path			VARCHAR(255)		NULL,
    image_size			VARCHAR(20)			NULL,
    
    CONSTRAINT user_avatars_user_id_fk
		FOREIGN KEY(user_id)
        REFERENCES users(user_id)
);

DELIMITER //
CREATE FUNCTION getUpvotes(param_thread_id INT)
RETURNS INT
BEGIN
	DECLARE upvotes INT;
	SELECT SUM(upvoted) INTO upvotes FROM forum_upvote_downvote WHERE thread_id = param_thread_id;
    RETURN upvotes;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION getDownvotes(param_thread_id INT)
RETURNS INT
BEGIN
	DECLARE downvotes INT;
	SELECT SUM(downvoted) INTO downvotes FROM forum_upvote_downvote WHERE thread_id = param_thread_id;
    RETURN downvotes;
END //
DELIMITER ;

INSERT INTO article_system(article_system_id, article_system_name) VALUES
(1, 'Kriekon');
INSERT INTO forum(forum_id, forum_name) VALUES
(1, 'Kriekon');

INSERT INTO permissions (permission_name) VALUES ('can_change_avatar'),
('can_create_forum_thread'),
('can_delete_forum_thread'),
('can_modify_forum_thread'),
('can_reply'),
('can_dislike_forum_thread'),
('can_like_forum_thread'),
('can_delete_own_forum_thread'),
('can_edit_own_reply'),
('can_edit_own_thread'),
('can_view_threads'),
('can_view_dashboard'),
('can_approve_articles'),
('can_approve_article_edits'),
('can_approve_article_deletion'),
('can_submit_article'),
('can_submit_article_edit'),
('can_submit_article_deletion'),
('can_delete_article'),
('can_create_article'),
('can_edit_article'),
('can_upload_article_image'),
('can_comment_articles'),
('can_view_articles'),
('can_edit_own_dev_blog'),
('can_delete_own_dev_blog'),
('can_delete_dev_blog'),
('can_edit_dev_blog'),
('can_submit_new_dev_blog'),
('can_comment_on_dev_blog'),
('can_create_tracker_entry'),
('can_delete_tracker_entry'),
('can_update_tracker_entry'),
('can_view_dev_blog'),
('can_add_new_bbcode'),
('can_modify_bbcode'),
('can_view_bbcode'),
('can_delete_bbcode'),
('can_delete_user'),
('can_modify_user'),
('can_modify_admin'),
('is_super_admin'),
('can_manage_forums'),
('can_manage_articles'),
('can_site_maintenance');

INSERT INTO tags (tag_name) VALUES ('Admin'),
('Web Developer'),
('Developer'),
('Moderator'),
('Editor'),
('Writer'),
('Member'),
('Guest');

INSERT INTO tag_permissions (tag_id, permission_id) VALUES (1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12),
(1,13),
(1,14),
(1,15),
(1,19),
(1,20),
(1,21),
(1,22),
(1,23),
(1,24),
(1,25),
(1,26),
(1,27),
(1,28),
(1,29),
(1,30),
(1,31),
(1,32),
(1,33),
(1,34),
(1,35),
(1,36),
(1,37),
(1,38),
(1,39),
(1,40),
(1,41),
(1,42),
(2,1),
(2,2),
(2,4),
(2,5),
(2,6),
(2,7),
(2,8),
(2,9),
(2,10),
(2,11),
(2,12),
(2,23),
(2,24),
(2,25),
(2,26),
(2,29),
(2,30),
(2,31),
(2,32),
(2,33),
(2,34),
(2,35),
(2,36),
(2,37),
(2,38),
(3,1),
(3,2),
(3,4),
(3,5),
(3,6),
(3,7),
(3,8),
(3,9),
(3,10),
(3,11),
(3,12),
(3,23),
(3,24),
(3,25),
(3,26),
(3,29),
(3,30),
(3,31),
(3,32),
(3,33),
(3,34),
(4,1),
(4,2),
(4,3),
(4,4),
(4,5),
(4,6),
(4,7),
(4,8),
(4,9),
(4,10),
(4,11),
(4,12),
(4,23),
(4,24),
(4,30),
(4,34),
(5,1),
(5,2),
(5,4),
(5,5),
(5,6),
(5,7),
(5,8),
(5,9),
(5,10),
(5,11),
(5,12),
(5,13),
(5,14),
(5,15),
(5,19),
(5,20),
(5,21),
(5,22),
(5,23),
(5,24),
(5,30),
(5,34),
(6,1),
(6,2),
(6,4),
(6,5),
(6,6),
(6,7),
(6,8),
(6,9),
(6,10),
(6,11),
(6,12),
(6,16),
(6,17),
(6,18),
(6,22),
(6,23),
(6,24),
(6,30),
(6,34),
(7,1),
(7,2),
(7,4),
(7,5),
(7,6),
(7,7),
(7,8),
(7,9),
(7,10),
(7,11),
(7,23),
(7,24),
(7,30),
(7,24),
(8,11),
(8,24);













    
    





























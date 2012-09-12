CREATE TABLE peer (
	id int4 NOT NULL auto_increment,
	users int4 NOT NULL DEFAULT 0,
	modules int4 NOT NULL DEFAULT 0,
	memo text NOT NULL DEFAULT '',
	title varchar(255) NOT NULL DEFAULT '',
	words int8 NOT NULL DEFAULT 0, 
	time int8 NOT NULL DEFAULT 0, 
	PRIMARY KEY(id), 
	KEY(users),
	KEY(time)
);

CREATE TABLE peer_comments (
	id int4 NOT NULL auto_increment,
	modules int4 NOT NULL DEFAULT 0,
	reviewer int4 NOT NULL DEFAULT 0, 
	author int4 NOT NULL DEFAULT 0,
	comment text NOT NULL DEFAULT '', 
	time int8 NOT NULL DEFAULT 0, 
	PRIMARY KEY(id), 
	KEY(time), 
	KEY(modules), 
	KEY(reviewer),
	KEY(author)
);

CREATE TABLE peer_corr (
	id int4 NOT NULL auto_increment,
	modules int4 NOT NULL DEFAULT 0,
	users int4 NOT NULL DEFAULT 0, 
	corr int4 NOT NULL DEFAULT 0, 
	PRIMARY KEY(id), 
	KEY(users), 
	KEY(modules),
	KEY(corr)
);

CREATE TABLE peer_prefs (
	id int4 NOT NULL auto_increment,
	modules int4 NOT NULL DEFAULT 0,
	post_end int8 NOT NULL DEFAULT 0, 
	review_end int8 NOT NULL DEFAULT 0,
	instructions text NOT NULL DEFAULT '',
	first_instructions text NOT NULL DEFAULT '',
	reports_to_review int4 NOT NULL DEFAULT 0, 
	mailed int4 NOT NULL DEFAULT 0, 
	PRIMARY KEY(id), 
	KEY(modules), 
	KEY(post_end),
	KEY(review_end)
);

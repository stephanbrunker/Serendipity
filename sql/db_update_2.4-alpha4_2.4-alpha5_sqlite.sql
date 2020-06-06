create table {PREFIX}authors2 (
  realname varchar(255) NOT NULL default '',
  username varchar(32) default null,
  password varchar(64) default null,
  authorid {AUTOINCREMENT} {PRIMARY},
  mail_comments int(1) default '1',
  mail_trackbacks int(1) default '1',
  email varchar(128) not null default '',
  userlevel int(4) {UNSIGNED} not null default '0',
  right_publish int(1) default '1',
  hashtype int(1) default '0',
  description text default null,
  image varchar(255) default null,
  mailimage varchar(255) default null,
  xmlimage varchar(255) default null
) {UTF-8};

INSERT INTO {PREFIX}authors2
SELECT realname, username, password, authorid, mail_comments, mail_trackbacks, userlevel, right_publish, hashtype
FROM {PREFIX}authors;

DROP TABLE {PREFIX}authors;

ALTER TABLE {PREFIX}authors2 RENAME TO {PREFIX}authors;

CREATE TABLE {PREFIX}category2 (
  categoryid {AUTOINCREMENT} {PRIMARY},
  category_name varchar(255) default NULL,
  category_icon varchar(255) default NULL,
  category_description text,
  authorid int(11) default NULL,
  category_left int(11) default '0',
  category_right int(11) default '0',
  parentid int(11) DEFAULT '0' NOT NULL,
  sort_order int(11),
  hide_sub int(1),
  mailimage varchar(255) default null,
  xmlimage varchar(255) default null
) {UTF-8};

INSERT INTO {PREFIX}category2
SELECT categoryid, category_name, category_icon, category_description, authorid, category_left, category_right, parentid, sort_order, hide_sub
FROM {PREFIX}category;

DROP TABLE {PREFIX}category;

ALTER TABLE {PREFIX}category2 RENAME TO {PREFIX}category;

CREATE INDEX categorya_idx ON {PREFIX}category (authorid);
CREATE INDEX categoryp_idx ON {PREFIX}category (parentid);
CREATE INDEX categorylr_idx ON {PREFIX}category (category_left, category_right);
CREATE INDEX categoryso_idx ON {PREFIX}category (sort_order);


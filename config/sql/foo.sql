#Gitrbug sql generated on: 2009-11-18 14:54:51 : 1258574091

DROP TABLE "collection_files";
DROP TABLE "peer_tags";
DROP TABLE "peers";
DROP TABLE "process_table_entries";
DROP TABLE "settings";


CREATE TABLE "collection_files" (
	"id" integer primary key autoincrement,
	"path" varchar(2048) NOT NULL,
	"hash" varchar(40) NOT NULL,
	"plugin_id" varchar(36) DEFAULT NULL);
	

CREATE TABLE "peer_tags" (
	"id" integer primary key autoincrement,
	"peer_id" varchar(36) NOT NULL,
	"value" text NOT NULL,
	"tag_name" varchar(255) DEFAULT NULL);
	

CREATE TABLE "peers" (
	"score" text DEFAULT NULL,
	"id" integer primary key autoincrement,
	"name" varchar(255) DEFAULT NULL,
	"ip" text DEFAULT NULL,
	"port" text DEFAULT NULL);
	

CREATE TABLE "process_table_entries" (
	"id" integer primary key autoincrement,
	"action" varchar(255) NOT NULL,
	"argv" blob DEFAULT NULL,
	"priority" text NOT NULL,
	"created" datetime NOT NULL,
	"modified" datetime NOT NULL,
	"status" text DEFAULT '0' NOT NULL);
	

CREATE TABLE "settings" (
	"name" integer primary key autoincrement,
	"value" varchar(2048) DEFAULT NULL);
	


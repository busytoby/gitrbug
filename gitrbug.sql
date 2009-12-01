BEGIN TRANSACTION;
CREATE TABLE "collection_files" (
        "id" char(36) PRIMARY KEY  NOT NULL , 
        "path" varchar(2048) NOT NULL , 
        "hash" varchar(40) NOT NULL , 
        "plugin_id" char(36));
CREATE TABLE "peer_tags" (
        "id" char(36) PRIMARY KEY  NOT NULL ,
        "peer_id" char(36) NOT NULL ,
        "score" smallint unsigned NOT NULL , 
        "tag_name" varchar(255));
CREATE TABLE peers (
        id char(36) PRIMARY KEY NOT NULL, 
        name char(255), 
        ip integer unsigned, 
        port smallint unsigned,
        "score" smallint unsigned NOT NULL);
CREATE TABLE "process_table_entries" (
        "id" char(36) PRIMARY KEY  NOT NULL ,
        "action" varchar(255) NOT NULL ,
        "argv" BLOB,
        "priority" tinyint unsigned NOT NULL ,
        "created" datetime NOT NULL ,
        "modified" datetime NOT NULL ,
        "status" tinyint NOT NULL  DEFAULT 0 );
CREATE TABLE "settings" (
        "name" varchar(2048) PRIMARY KEY  NOT NULL , 
        "value" varchar(2048));

CREATE UNIQUE INDEX "file_hash" ON "collection_files" ("hash" ASC);
CREATE INDEX "file_path" ON "collection_files" ("path" ASC);
CREATE INDEX named_tag ON peer_tags(tag_name ASC);
CREATE INDEX tagged_peer ON peer_tags(peer_id ASC);
COMMIT;

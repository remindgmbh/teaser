CREATE TABLE tx_teaser_domain_model_teaser (
    title varchar(255) DEFAULT '' NOT NULL,
    subtitle varchar(255) DEFAULT '' NOT NULL,
    bodytext mediumtext,
    image int(11) unsigned DEFAULT '0' NOT NULL,
    link varchar(1024) DEFAULT '' NOT NULL,
);
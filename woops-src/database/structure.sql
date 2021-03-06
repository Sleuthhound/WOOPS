################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# Copyright (C) 2009 Jean-David Gadina - www.xs-labs.com                       #
# All rights reserved                                                          #
################################################################################

# $Id$

#
# Table structure for table `CONTRIBUTORS`
#
CREATE TABLE IF NOT EXISTS `{$PREFIX}CONTRIBUTORS` (
    `id_contributors` int(32) unsigned NOT NULL auto_increment,
    `deleted` int(1) unsigned NOT NULL default '0',
    `mtime` int(32) unsigned NOT NULL default '0',
    `ctime` int(32) unsigned NOT NULL default '0',
    `username` varchar(255) NOT NULL,
    `password` varchar(40) NOT NULL,
    `admin` int(1) unsigned NOT NULL default '0',
    `email` varchar(255) NOT NULL,
    `fullname` varchar(255) NOT NULL,
    `lang` varchar(8) NOT NULL,
    `lastlogin` int(32) NOT NULL default '0',
    `lastip` varchar(15) NOT NULL,
    `session` varchar(40) NOT NULL,
    PRIMARY KEY  (`id_contributors`)
);

#
# Table structure for table `CONTRIBUTORS_LOGS`
#
CREATE TABLE IF NOT EXISTS `{$PREFIX}CONTRIBUTORS_LOGS` (
    `id_contributors_logs` int(32) unsigned NOT NULL auto_increment,
    `deleted` int(2) unsigned NOT NULL default '0',
    `ctime` int(32) unsigned NOT NULL default '0',
    `mtime` int(32) unsigned NOT NULL default '0',
    `id_contributors` int(32) NOT NULL default '0',
    `type` int(8) unsigned NOT NULL default '0',
    `message` longtext NOT NULL,
    PRIMARY KEY  (`id_contributors_logs`),
    KEY `id_contributors` (`id_contributors`)
);

#
# Table structure for table `PAGEHEADERS`
#
CREATE TABLE IF NOT EXISTS `{$PREFIX}PAGEHEADERS` (
    `id_pageheaders` int(32) NOT NULL auto_increment,
    `id_pageinfos` int(32) NOT NULL default '0',
    `id_templates` int(32) NOT NULL default '0',
    `deleted` int(1) NOT NULL default '0',
    `ctime` int(32) NOT NULL default '0',
    `mtime` int(32) NOT NULL default '0',
    `lang` varchar(8) NOT NULL,
    `title` varchar(255) NOT NULL,
    `menutitle` varchar(255) NOT NULL,
    `keywords` tinytext NOT NULL,
    `description` tinytext NOT NULL,
    PRIMARY KEY  (`id_pageheaders`),
    UNIQUE KEY `id_pageinfos` (`id_pageinfos`,`lang`),
    KEY `id_templates` (`id_templates`)
);

#
# Table structure for table `PAGEINFOS`
#
CREATE TABLE IF NOT EXISTS `{$PREFIX}PAGEINFOS` (
    `id_pageinfos` int(32) unsigned NOT NULL auto_increment,
    `id_parent` int(32) unsigned NOT NULL default '0',
    `deleted` int(1) unsigned NOT NULL default '0',
    `ctime` int(32) unsigned NOT NULL default '0',
    `mtime` int(32) unsigned NOT NULL default '0',
    `home` int(1) default '0',
    PRIMARY KEY  (`id_pageinfos`),
    KEY `id_parent` (`id_parent`)
);

#
# Table structure for table `TEMPLATES`
#
CREATE TABLE IF NOT EXISTS `{$PREFIX}TEMPLATES` (
    `id_templates` int(32) NOT NULL auto_increment,
    `id_parent` int(32) NOT NULL default '0',
    `deleted` int(1) NOT NULL default '0',
    `ctime` int(32) NOT NULL default '0',
    `mtime` int(32) NOT NULL default '0',
    `title` varchar(255) NOT NULL,
    `file` varchar(255) NOT NULL,
    `engine` varchar(255) NOT NULL,
    `engine_options` longtext NOT NULL,
    PRIMARY KEY  (`id_templates`),
    KEY `id_parent` (`id_parent`)
);

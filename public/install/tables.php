<?php
return [
    'users' => "CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_group_id` int(11) NOT NULL,
                `first_name` varchar(20) NOT NULL,
                `last_name` varchar(20) NOT NULL,
                `email` varchar(40) NOT NULL,
                `password` varchar(255) NOT NULL,
                `image` varchar(255) NOT NULL,
                `status` varchar(8) NOT NULL,
                `ip` varchar(32) NOT NULL,
                `code` varchar(23) NOT NULL,
                `created` int(11) NOT NULL,
                `verification_code` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'users_groups' => "CREATE TABLE IF NOT EXISTS `users_groups` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(40) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'users_groups_privileges' => "CREATE TABLE IF NOT EXISTS `users_groups_privileges` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `users_groups_id` int(11) NOT NULL,
                `page` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'authors' => "CREATE TABLE IF NOT EXISTS `authors` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(40) NOT NULL,
            `description` text NOT NULL,
            `image` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'books' => "CREATE TABLE IF NOT EXISTS `books` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `category_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `author_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `description` text NOT NULL,
            `image` varchar(255) NOT NULL,
            `link` varchar(255) NOT NULL,
            `views` int(11) NOT NULL,
            `downloads` int(11) NOT NULL,
            `page_count` int(11) NOT NULL,
            `created` int(11) NOT NULL,
            `status` varchar(8) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'categories' => "CREATE TABLE IF NOT EXISTS `categories` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `parent_id` int(11) NOT NULL,
            `name` varchar(20) NOT NULL,
            `status` varchar(8) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'comments' => "CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `book_id` int(11) NOT NULL,
            `comment` text NOT NULL,
            `created` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'contacts' => "CREATE TABLE IF NOT EXISTS `contacts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `name` varchar(40) NOT NULL,
            `email` varchar(40) NOT NULL,
            `title` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `reply` text NOT NULL,
            `replied_by` int(11) NOT NULL,
            `replied_at` int(11) NOT NULL,
            `created` int(11) NOT NULL,
            `opened` int(11) NOT NULL,
            `status` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

    'settings' => "CREATE TABLE IF NOT EXISTS `settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(50) NOT NULL,
            `value` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",

];
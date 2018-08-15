<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version3
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct( Database $database )
    {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createPageTable();
        $this->createWebsiteVarnishTable();
    }

    private function createPageTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `varnishes` (
  `varnish_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`varnish_id`),
  CONSTRAINT `varnish_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function createWebsiteVarnishTable()
    {
        $createQuery = <<<SQL
CREATE TABLE IF NOT EXISTS website_varnish (
  website_id int(10) unsigned NOT NULL,
  varnish_id int(10) unsigned NOT NULL,
  INDEX website_id (website_id),
  INDEX varnish_id (varnish_id),
  FOREIGN KEY (`website_id`) REFERENCES `websites`(`website_id`),
  FOREIGN KEY (`varnish_id`) REFERENCES `varnishes`(`varnish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

}


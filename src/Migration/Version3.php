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
        $this->alterPageTable();
    }

    private function alterPageTable()
    {
        $createQuery = <<<SQL
ALTER TABLE `pages`
ADD COLUMN `last_visit` datetime NULL AFTER `website_id` ;
SQL;
        $this->database->exec($createQuery);
    }

}
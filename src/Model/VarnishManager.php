<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class VarnishManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function getWebsites(Varnish $varnish)
    {
        $varnishId = $varnish->getVarnishId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM website_varnish WHERE varnish_id = :varnish');
        $query->bindParam(':varnish', $varnishId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);
    }

    public function getByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function create(User $user, $ip)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnishes (ip, user_id) VALUES (:ip, :user)');
        $statement->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function link($website, $varnish)
    {
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO website_varnish (website_id, varnish_id) VALUES (:website, :varnish)');
        $statement->bindParam(':website', $website, \PDO::PARAM_STR);
        $statement->bindParam(':varnish', $varnish, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function unlink($website, $varnish)
    {
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('DELETE FROM website_varnish WHERE website_id= :website AND varnish_id = :varnish');
        $statement->bindParam(':website', $website, \PDO::PARAM_STR);
        $statement->bindParam(':varnish', $varnish, \PDO::PARAM_INT);
        $statement->execute();
    }

}
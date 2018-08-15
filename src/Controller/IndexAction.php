<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class IndexAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var User
     */
    private $user;

    private $userPages;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager)
    {
        $this->websiteManager = $websiteManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
            $this->userPages = $this->websiteManager->getAllPagesByUserOrderAsc($this->user);
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    protected function getAllPagesCount()
    {
        if($this->user) {
            return count($this->userPages);
        }
    }

    protected function getLeastViewedPage()
    {
        if($this->user) {
            $visitedPages = $this->filterPagesArray($this->userPages);
            $leastPage = reset($visitedPages);
            return $leastPage->hostname . '/' .$leastPage->url;
        }
    }

    protected function getMostViewedPage()
    {
        if($this->user) {
            $visitedPages = $this->filterPagesArray($this->userPages);
            $mostPage = end($visitedPages);
            return $mostPage->hostname . '/' .$mostPage->url;
        }
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }

    private function filterPagesArray($pages)
    {
        $new_array = array_filter($pages, function($obj){
            if (is_null($obj->last_visit)) {
                return false;
            }
            return true;
        });

        return $new_array;
    }

}
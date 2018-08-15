<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        $enable = $_POST['enable'];
        $websiteId = $_POST['website'];
        $varnishId = $_POST['varnish'];

        if (isset($_SESSION['login'])) {
            if (!empty($enable) && !empty($websiteId) &&!empty($varnishId)) {
                if ($enable == "true"){
                    $this->varnishManager->link($websiteId, $varnishId);
                } else if ( $enable == "false" ) {
                    $this->varnishManager->unlink($websiteId, $varnishId);
                }

            }
        }
    }
}
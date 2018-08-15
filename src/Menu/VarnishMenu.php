<?php

namespace Snowdog\DevTest\Menu;

class VarnishMenu extends AbstractMenu
{

    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/';
    }

    public function getHref()
    {
        return '/varnish';
    }

    public function getLabel()
    {
        return 'Varnishes';
    }
}
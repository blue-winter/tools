<?php
namespace admintools\tools\facade;

use admintools\tools\Facade;

class InstallDb extends Facade
{
    protected static function getFacadeClass()
    {
        return 'admintools\tools\tools\InstallDb';
    }
}
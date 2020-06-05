<?php
namespace admintools\tools\facade;

use admintools\tools\Facade;

class Html extends Facade
{
    protected static function getFacadeClass()
    {
        return 'admintools\tools\tools\Html';
    }
}
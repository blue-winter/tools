<?php
namespace admintools\tools\facade;

use admintools\tools\Facade;

class ToolDb extends Facade
{
    protected static function getFacadeClass()
    {
        return 'admintools\tools\tools\ToolDb';
    }
}
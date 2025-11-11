<?php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses('smartcache', [

    'My\\SmartCache\\Manager' => 'lib\manager.php',

]);

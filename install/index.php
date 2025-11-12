<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;


class smartcache extends CModule
{


    public $MODULE_ID = "smartcache";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DECRIPTION;


    public function __construct()
    {
        include(__DIR__."/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATA = $arModuleVersion['VERSION_DATA'];
        $this->MODULE_NAME = "Умное кеширование инфоблоков";
        $this->MODULE_DESCRIPTION = "Модуль автоматического кеширования и сброса кеша при изменении данных";

    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        
        $this->InstallEvents();
    }

    public function DoUninstall()
    {
        $this->UnInstallEvents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function GetModuleRightList()
    {
        return [
            'reference_id' => ['D', 'R', 'W'],
            'reference'    => ['Нет доступа', 'Чтение', 'Полный доступ']
        ];
    }

    public function InstallEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandler(

            "iblock",
            "OnAfterIBlockElementUpdate",
            $this-MODULE_ID,
            "\\My\\SmartCache\\Manager",
            "clearCacheByIblock"
        );

        $eventManager->registerEventHandler(
            "iblock",
            "OnAfterIBlockElementAdd",
            $this->MODULE_ID,
            "\\My\\SmartCache\\Manager",
            "clearCacheByiblock"
        );

        $eventManager->registerEventHandler(
            "iblock",
            "OnAfterIBlockElementDelete",
            $this->MODULE_ID,
            "\\My\\SmartCache\\Manager",
            "clearCacheByIblock"
        );
    }


    public function UnInstallEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->UnRegisterEventHandler("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, "\\My\\SmartCache\\Manager", "clearCacheByiblock");
        $eventManager->UnRegisterEventHandler("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, "\\My\\SmartCache\\Manager", "clearCacheByiblock");
        $eventManager->UnRegisterEventHandler("iblock", "OnAfterIBlockElementDelete", $this->MODULE_ID, "\\My\\SmartCache\\Manager", "clearCacheByiblock");
    }


}
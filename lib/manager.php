<?php

namespace My\SmartCache;

use Bitrix\Main\Data\Cache;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;


class Manager
{
    public static function getIblockElements($iblockId, $filter = [], $select = ["ID", "NAME"])
    {

        // $iblockId = Option

        $cache = Cache::createInstance();
        $cacheTime = Option::get('smartcache', 'CACHETIME', 3600);
        $cacheId = "iblock_{$iblockId}_".md5(serialize($filter).serialize($select));
        $cachePath = "/my.smartcache/iblock_{$iblockId}/";


        if ($cache->initCache($cacheTime, $cacheId, $cachePath)) {


            echo "<p>Данные взяты из кеша</p>";

            return $cache->getVars();

        } elseif ($cache->startDataCache()) {
            echo "<p>Данные берутся из базы и кешируются</p>";

            $taggedCache = Application::getInstance()->getTaggedCache();
            $taggedCache->startTagCache($cachePath);
            $taggedCache->registerTag("iblock_id_" . $iblockId);

            \Bitrix\Main\Loader::includeModule('iblock');

            $result = [];
            $res = \CIBlockElement::GetList([], array_merge(["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"], $filter), false, false, $select);
            while ($item = $res->GetNext()) {
                $result[] = $item;
            }

            $taggedCache->endTagCache();
            $cache->endDataCache($result);
            return $result;

        }

    }


    public static function clearCacheByIblock($fields)
    {
        if(!empty($fields["IBLOCK_ID"])){
            $iblockId = $fields["IBLOCK_ID"];
            Application::getInstance()->getTaggedCache()->clearByTag("iblock_id_" . $iblockId);
        }
    }
}
<?php

use Bitrix\Main\Config\Option;
use My\SmartCache\Manager;

$iblockId = Option::get('smartcache', 'SELECTED_IBLOCK');
$selectionIds = unserialize(Option::get('smartcache', 'SELECTED_SECTIONS', 'a:0:{}'));

$filter = ['IBLOCK' => $iblockId,'ACTIVE'=> 'Y'];
if(!empty($sectionIds))
{

    $filter['SECTION_ID'] = $sectionIds;

}

$data_el = Manager::getIblockElements($iblockId, $filter);

foreach($data_el as $el) {
    echo "<p><b>{$el['NAME']}</b>: {$el['PREVIEW_TEXT']}</p>";
}
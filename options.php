<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;




$module_id = "smartcache";
Loader::includeModule('iblock');

//Получаем список инфоблоков
$iblocks = [];
$res = CIBlock::GetList(['SORT'=>'ASC'], ['ACTIVE'=>'Y']);
while($ib=$res->Fetch())
{
    $iblocks[$ib['ID']] = '['.$ib['ID'].']' .$ib['NAME'];
}




if($REQUEST_METHOD == "POST" && check_bitrix_sessid()) {
    Option::set($module_id, "CACHETIME", $_POST["CACHETIME"]);
    Option::set($module_id, "SELECTED_IBLOCK", $_POST["SELECTED_IBLOCK"]);
    Option::set($module_id, "SELECTED_SECTIONS", serialize($_POST["SELECTED_SECTIONS"]));
}


$cacheTime = Option::get($module_id, "CACHETIME", 50);

//Получаем сохранённые значения
$selectedIblock = Option::get($module_id, "SELECTED_IBLOCK", '');
$selectedSections = unserialize(Option::get($module_id, "SELECTED_SECTIONS", 'a:0:{}'));


//Подгружаем разделы
$sections = [];
if ($selectedIblock){

    $res = CIBlockSection::GetList(
        ['SORT' => 'ASC'],
        ['IBLOCK_ID'=>$selectedIblock, 'ACTIVE' => 'Y'],
        false,
        ['ID', 'NAME']
    );
    while ($sec = $res->Fetch()) {
        $sections[$sec['ID']] = '['.$sec['ID'].'] ' .$sec['NAME'];
    }

}

?>

<form method="post">
    <label>Время кеширования (сек):</label><br>
    <input type="text" name="CACHETIME" value="<?=htmlspecialcharsbx($cacheTime)?>" size="10"> <br><br>

    <h3>Выбор инфоблока</h3>
    <select name="SELECTED_IBLOCK">
        <option value="">--Выберите инфоблок--</option>
        <?php foreach($iblock as $id => $name): ?>
            <option value="<?=$id?>"<?=($selectedIblock == $id ? 'selected': '')?>>

                <?=$name?>

            </option>
    </select>

    <input type="submit" value="Сохранить">
    <?=bitrix_sessid_post()?>
</form>
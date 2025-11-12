<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;



$module_id = "smartcache";

if($REQUEST_METHOD == "POST" && check_bitrix_sessid()) {
    Option::set($module_id, "CACHETIME", $_POST["CACHETIME"]);
}


$cacheTime = Option::get($module_id, "CACHETIME", 50);

?>

<form method="post">
    <label>Время кеширования (сек):</label><br>
    <input type="text" name="CACHETIME" value="<?=htmlspecialcharsbx($cacheTime)?>" size="10"> <br><br>
    <input type="submit" value="Сохранить">
    <?=bitrix_sessid_post()?>
</form>
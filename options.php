<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;


$module_id = "smartcache";

if($REQUEST_METHOD == "POST" && check_bitrix_sessid()) {
    Option::set($module_id, "CACHE_TIME", $_POST["CACHE_TIME"]);
}


$cacheTime = Option::get($module_id, "CACHE)TIME", 60);

?>

<form method="post">
    <label>Время кеширования (сек):</label><br>
    <input type="text" name="CACHE_TIME" value="<?=htmlspecialcharsbx($cacheTime)?>" size="10"> <br><br>
    <input type="submit" value="Сохранить">
    <?=bitrix_sessid_post()?>
</form>
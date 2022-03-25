<?
use \Bitrix\Main\Localization\Loc;
global $APPLICATION;
$MODULE_ID = "ibs.shopnotebook";
//IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/local/modules/{$MODULE_ID}/install/index.php"); ?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
    <input type="hidden" name="id" value="<?=$MODULE_ID?>>">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <p><input type="checkbox" name="deldata" id="deldata" value="Y" checked><label for="deldata"><?=Loc::getMessage('IBS_SHOP_NOTEBOOK_DELETE_DATA_DB_AND_RECREATE')?></label></p>
    <input type="submit" name="inst" value="<?echo Loc::getMessage("MOD_INSTALL")?>">
</form>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    'NAME' => Loc::getMessage('IBS_NOTEBOOK_COMPONENT_CATALOG_NAME'),
    'DESCRIPTION' => Loc::getMessage('IBS_NOTEBOOK_COMPONENT_CATALOG_DESCRIPTION'),
    'PATH' => array(
        'ID' => Loc::getMessage('IBS_NOTEBOOK_COMPONENT_CATALOG')
    ),
    'COMPLEX'=>'Y'
);
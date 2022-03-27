<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;

$arComponentParameters = array(
    'PARAMETERS' => array(
        "NOTEBOOK_CODE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_DETAIL_NOTEBOOK_CODE"),
            "TYPE" => "STRING",
            "DEFAULT" => "10",
        ),
    )
);
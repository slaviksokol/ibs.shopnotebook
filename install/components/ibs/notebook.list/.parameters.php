<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
$arSortsBy = array(
    "ASC"=>GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_ASC"),
    "DESC"=>GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_DESC")
);
$arSortFields = array(
    "PRICE"=>GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_PRICE"),
    "YEAR"=>GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_YEAR"),
);
$arComponentParameters = array(
    'PARAMETERS' => array(
        "ELEMENTS_COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_COUNT"),
            "TYPE" => "STRING",
            "DEFAULT" => "10",
        ),
        "PAGE_NUMBER_GET_NAME" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PAGE_NUMBER_GET_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => "page",
        ),
        "SORT_ORDER" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_ORDER"),
            "TYPE" => "LIST",
            "DEFAULT" => "PRICE",
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_BY" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_ORDER_BY"),
            "TYPE" => "LIST",
            "DEFAULT" => "ASC",
            "VALUES" => $arSortsBy,
        ),
        "DETAIL_URL" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_LIST_PARAM_DETAIL_URL"),
            "TYPE" => "STRING",
            "DEFAULT" => "detail/#NOTEBOOK#/"
        )
    )
);
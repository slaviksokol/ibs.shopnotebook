<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
$arSortsBy = array(
    "ASC"=>GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_ASC"),
    "DESC"=>GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_DESC")
);
$arSortFields = array(
    "PRICE"=>GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_PRICE"),
    "YEAR"=>GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_YEAR"),
);
$arComponentParameters = array(
    "GROUPS" => array(
        "LIST_SETTINGS" => array(
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_SETTINGS"),
        ),
        "DETAIL_SETTINGS" => array(
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_DETAIL_SETTINGS"),
        ),
    ),
    'PARAMETERS' => array(
        "ELEMENTS_LIST_COUNT" => array(
            "PARENT" => "LIST_SETTINGS",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_COUNT"),
            "TYPE" => "STRING",
            "DEFAULT" => "10",
        ),
        "ELEMENTS_LIST_PAGE_NUMBER_GET_NAME" => array(
            "PARENT" => "LIST_SETTINGS",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PAGE_NUMBER_GET_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => "page",
        ),
        "ELEMENTS_LIST_SORT_ORDER" => array(
            "PARENT" => "LIST_SETTINGS",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_ORDER"),
            "TYPE" => "LIST",
            "DEFAULT" => "PRICE",
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "ELEMENTS_LIST_SORT_BY" => array(
            "PARENT" => "LIST_SETTINGS",
            "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_LIST_PARAM_ORDER_BY"),
            "TYPE" => "LIST",
            "DEFAULT" => "ASC",
            "VALUES" => $arSortsBy,
        ),
        "VARIABLE_ALIASES" => Array(
            "BRAND_CODE" => Array("NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_BRAND_CODE")),
            "MODEL_CODE" => Array("NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_MODEL_CODE")),
            "ID_NOTEBOOK" => Array("NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_ID_NOTEBOOK")),
        ),
        "SEF_MODE" => Array(
            "models" => array(
                "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_SEF_PAGE_MODELS"),
                "DEFAULT" => "#BRAND#/",
                "VARIABLES" => array(),
            ),
            "notebooks" => array(
                "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_SEF_PAGE_NOTEBOOKS"),
                "DEFAULT" => "#BRAND#/#MODEL#/",
                "VARIABLES" => array(),
            ),
            "detail" => array(
                "NAME" => GetMessage("IBS_NOTEBOOK_COMPONENT_CATALOG_SEF_PAGE_NOTEBOOKS_DETAIL"),
                "DEFAULT" => "detail/#NOTEBOOK#/",
                "VARIABLES" => array("ID_NOTEBOOK"),
            )
        ),
    )
);
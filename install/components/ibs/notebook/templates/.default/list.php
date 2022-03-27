<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$arVariables = $arResult['VARIABLES'];
?>
<div class="container">
<?
require 'sections.php';
?>
<br>
<br>
<?$APPLICATION->IncludeComponent(
    "ibs:notebook.list",
    "",
    Array(
        "ELEMENTS_COUNT" => $arParams['ELEMENTS_LIST_COUNT'],
        "PAGE_NUMBER_GET_NAME" => $arParams['ELEMENTS_LIST_PAGE_NUMBER_GET_NAME'],
        "VARIABLES" => $arResult['VARIABLES'],
        "URL_TEMPLATES" => $arResult['URL_TEMPLATES'],
        "FOLDER" => $arResult['FOLDER'],
        "SORT_BY" => $arParams['ELEMENTS_LIST_SORT_BY'],
        "SORT_ORDER" => $arParams['ELEMENTS_LIST_SORT_ORDER'],
        "DETAIL_URL" => $arResult['URL_TEMPLATES']['detail']
    ),
    $component
);?>
</div>

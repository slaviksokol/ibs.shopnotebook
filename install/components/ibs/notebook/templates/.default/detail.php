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

?>
<div class="container">
<?

require 'sections.php';

?>
<br>
<br>
<?$APPLICATION->IncludeComponent(
    "ibs:notebook.detail",
    "",
    Array(
        "VARIABLES" => $arResult['VARIABLES'],
        "URL_TEMPLATES" => $arResult['URL_TEMPLATES'],
        "FOLDER" => $arResult['FOLDER'],
        "NOTEBOOK_CODE" => $arResult['VARIABLES']['NOTEBOOK']
    ),
    $component
);?>
</div>

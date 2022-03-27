<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arDefaultUrlTemplates404 = array(
    'detail' => 'detail/#NOTEBOOK#/',
    'models' => '#BRAND#/',
    'notebooks' => '#BRAND#/#MODEL#/'
);
$arDefaultVariableAliases404 = [
    'detail' => ['NOTEBOOK' => 'ID_NOTEBOOK'],
    'models' => ['BRAND' => 'BRAND_CODE'],
    'notebooks' => ['BRAND' => 'BRAND_CODE','MODEL' => 'MODEL_CODE'],
];
$arDefaultVariableAliases    = [];
$arComponentVariables = array('detail', 'models', 'notebooks');
$SEF_FOLDER                  = '';
$arUrlTemplates              = [];


if ($arParams['SEF_MODE'] == 'Y')
{
    $arVariables = array();
    $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
        $arDefaultUrlTemplates404,
        $arParams['SEF_URL_TEMPLATES']
    );
    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
        $arDefaultVariableAliases404,
        $arParams['VARIABLE_ALIASES']
    );
    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams['SEF_FOLDER'],
        $arUrlTemplates,
        $arVariables
    );
    if (strlen($componentPage) <= 0 || $componentPage == 'models' || $componentPage == 'notebooks') {
        $componentPage = 'list';
    }
    CComponentEngine::InitComponentVariables(
        $componentPage,
        $arComponentVariables,
        $arVariableAliases,
        $arVariables);

    $SEF_FOLDER = $arParams['SEF_FOLDER'];

    $arResult = array(
        "FOLDER" => $arParams["SEF_FOLDER"],
        "URL_TEMPLATES" => $arUrlTemplates,
        "VARIABLES" => $arVariables,
        "ALIASES" => $arVariableAliases,
    );
}
else
{
    $arVariables = [];
    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
        $arDefaultVariableAliases,
        $arParams['VARIABLE_ALIASES']
    );
    CComponentEngine::InitComponentVariables(
        false,
        $arComponentVariables,
        $arVariableAliases,
        $arVariables
    );
    $componentPage = '';
    if (intval($arVariables['ID_NOTEBOOK']) > 0) {
        $componentPage = 'detail';
    } else {
        $componentPage = 'list';
    }

    $arResult = array(
        "FOLDER" => "",
        "URL_TEMPLATES" => array(
            "models" => htmlspecialcharsbx($APPLICATION->GetCurPage()."?".$arVariableAliases["SECTION_ID"]."=#BRAND_CODE#"),
            "notebooks" => htmlspecialcharsbx($APPLICATION->GetCurPage()."?".$arVariableAliases["SECTION_ID"]."=#MODEL_CODE#"),
            "detail" => htmlspecialcharsbx($APPLICATION->GetCurPage()."?".$arVariableAliases["ID_NOTEBOOK"]."=#ID_NOTEBOOK#"),
        ),
        "VARIABLES" => $arVariables,
        "ALIASES" => $arVariableAliases
    );
}



$this->IncludeComponentTemplate($componentPage);

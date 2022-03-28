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

use \Bitrix\Main\Application,
    \Ibs\ShopNotebook;

$arResult = array();
if ($this->StartResultCache()) {
    $notebooksresult = ShopNotebook\NotebooksTable::getList([
        'select' => array(
            '*',
            'MODEL_' => 'MODEL',
            'BRAND_' => 'MODEL.BRAND'
        ),
        'filter' => array('CODE' => $arParams['NOTEBOOK_CODE']),
        "cache" => array("ttl" => 10)
    ]);

    $notebook = $notebooksresult->fetchObject();
    if ($notebook) {
        $notebook_code = $notebook->getCode();
        $arResult = array_merge(
            $notebook->collectValues(
                \Bitrix\Main\ORM\Objectify\Values::ALL,
                \Bitrix\Main\ORM\Fields\FieldTypeMask::FLAT
            ), \Ibs\ShopNotebook\helper::getPropRelationNameFromCollection($notebook)
        );
        $props = ShopNotebook\PropsValuesTable::getList([
            'select' => ['*', 'PROP_' => 'PROP'],
            'filter' => ['ID_NOTEBOOK' => $notebook->getId()]
        ]);
        while ($p = $props->fetch()) {
            if (!$arResult['PROPS'][$p['PROP_CODE']]) $arResult['PROPS'][$p['PROP_CODE']] = array('ID' => $p['PROP_ID'], 'NAME' => $p['PROP_NAME'], 'CODE' => $p['PROP_CODE']);
            $arResult['PROPS'][$p['PROP_CODE']]['VALUES'][] = array('ID' => $p['ID'], 'CODE' => $p['CODE'], 'VALUE' => $p['VALUE']);
        }
        if ($arResult['PROPS']) $arResult['PROPS'] = array_values($arResult['PROPS']);

        $item = $arResult;
        $arResult['URL'] = str_replace(array('#BRAND#', '#MODEL#', '#NOTEBOOK#'), array($item['BRAND_CODE'], $item['MODEL_CODE'], $item['CODE']), $arParams['URL_TEMPLATES']['detail'] && $arParams['FOLDER'] ? $arParams['FOLDER'] . $arParams['URL_TEMPLATES']['detail'] : $arParams['DETAIL_URL']);

        unset($notebook, $notebook_code, $props, $item);
    }
}
$this->IncludeComponentTemplate();
?>
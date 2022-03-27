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
CModule::IncludeModule('ibs.shopnotebook');
$request = Application::getInstance()->getContext()->getRequest();

$arResult = array();

$filter = [];
$order = ['PRICE'=>'ASC'];
if($arParams['SORT_ORDER'] && $arParams['SORT_BY']){
    $order = [$arParams['SORT_ORDER'] => $arParams['SORT_BY']];
}
if($request['order']){
    if($request['order'] == 'price_asc') $order = ['PRICE'=>'ASC'];
    if($request['order'] == 'price_desc') $order = ['PRICE'=>'DESC'];
    if($request['order'] == 'year_asc') $order = ['YEAR'=>'ASC'];
    if($request['order'] == 'year_desc') $order = ['YEAR'=>'DESC'];
}
$limit = $request['limit'] ?: ($arParams['ELEMENTS_COUNT'] ?: 10);
$offset = $request[$arParams['PAGE_NUMBER_GET_NAME']] > 1 ? ($limit * ($request[$arParams['PAGE_NUMBER_GET_NAME']] - 1)) : 0;

if($arParams['VARIABLES']['BRAND']){
    $filter = [
        'MODEL.BRAND.CODE'=>$arParams['VARIABLES']['BRAND']
    ];
}
if ($arParams['VARIABLES']['MODEL']){
    $filter = [
        'MODEL.CODE'=>$arParams['VARIABLES']['MODEL']
    ];
}

$notebooksresult = ShopNotebook\NotebooksTable::getList([
    'select' => array(
        '*',
        'MODEL_'=>'MODEL',
        'BRAND_'=>'MODEL.BRAND'
    ),
    'filter' => $filter,
    'order' => $order,
    'limit'=>$limit,
    'offset'=>$offset,
    "cache"=>array("ttl"=>10),
    'count_total' => true,
]);

$arResult['COUNT_TOTAL'] = $notebooksresult->getCount();

while ($notebook = $notebooksresult->fetchObject()){
    $notebook_code = $notebook->getCode();
    $arResult['ITEMS'][$notebook_code] = array_merge(
$notebook->collectValues(
        \Bitrix\Main\ORM\Objectify\Values::ALL,
        \Bitrix\Main\ORM\Fields\FieldTypeMask::FLAT
        ),\Ibs\ShopNotebook\helper::getPropRelationNameFromCollection($notebook)
    );
    $props = ShopNotebook\PropsValuesTable::getList([
        'select'=>['*','PROP_'=>'PROP'],
        'filter'=>['ID_NOTEBOOK'=>$notebook->getId()]
    ]);
    while ($p = $props->fetch()){
        if(!$arResult['ITEMS'][$notebook_code]['PROPS'][$p['PROP_CODE']]) $arResult['ITEMS'][$notebook_code]['PROPS'][$p['PROP_CODE']] = array('ID'=>$p['PROP_ID'],'NAME'=>$p['PROP_NAME'],'CODE'=>$p['PROP_CODE']);
        $arResult['ITEMS'][$notebook_code]['PROPS'][$p['PROP_CODE']]['VALUES'][] = array('ID'=>$p['ID'],'CODE'=>$p['CODE'],'VALUE'=>$p['VALUE']);
    }
    if($arResult['ITEMS'][$notebook_code]['PROPS']) $arResult['ITEMS'][$notebook_code]['PROPS'] = array_values($arResult['ITEMS'][$notebook_code]['PROPS']);

    $item = $arResult['ITEMS'][$notebook_code];
    $arResult['ITEMS'][$notebook_code]['URL'] = str_replace(array('#BRAND#','#MODEL#','#NOTEBOOK#'), array($item['BRAND_CODE'],$item['MODEL_CODE'],$item['CODE']), $arParams['URL_TEMPLATES']['detail'] && $arParams['FOLDER'] ? $arParams['FOLDER'].$arParams['URL_TEMPLATES']['detail'] : $arParams['DETAIL_URL']);

    unset($notebook,$notebook_code,$props,$item);
}

$arResult['URL'] = $APPLICATION->GetCurPage();





$this->IncludeComponentTemplate();
?>
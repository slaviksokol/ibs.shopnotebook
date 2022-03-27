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
use \Ibs\ShopNotebook;
CModule::IncludeModule('ibs.shopnotebook');
$arVariables = $arResult['VARIABLES'];
$arUrlTemplates = $arResult['URL_TEMPLATES'];

$arBrands = [];
$arModels = [];

if($arResult['FOLDER'] && $arResult['URL_TEMPLATES']) {
    $arBM = ShopNotebook\helper::getbrandsandmodels($arResult);
    $arBrands = $arBM['BRANDS'];
    $arModels = $arBM['MODELS'];
}

$title = 'Магазин ноутбуков';
if($arVariables){
    if($arBrands[$arVariables['BRAND']]){
        $title = 'Ноутбуки '.$arBrands[$arVariables['BRAND']]['NAME'];
    }
    if($arModels[$arVariables['MODEL']]){
        $title .= ' '.$arModels[$arVariables['MODEL']]['NAME'];
    }

}
$APPLICATION->SetTitle($title);

if($arBrands){
    ?>
    <div class="accordion" id="accordionBrands">
        <?
    foreach ($arBrands as $scode => $sect1){
        $showBrand = $arVariables['BRAND'] == $scode;
        ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?=$scode?>">
                <button class="accordion-button<?=$showBrand ? '' : ' collapsed'?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$scode?>" aria-expanded="<?=$showBrand ? 'true' : 'false'?>" aria-controls="collapse<?=$scode?>">
                    <a href="<?=$sect1['URL']?>"><?=$sect1['NAME']?></a>
                </button>
            </h2>
            <div id="collapse<?=$scode?>" class="accordion-collapse collapse<?=$showBrand ? ' show' : ''?>" aria-labelledby="heading<?=$scode?>" data-bs-parent="#accordionBrands">
                <div class="accordion-body">
                    <div>
                        <a class="btn btn-default border <?=$showBrand && !$arVariables['MODEL'] ? 'btn-primary' : ''?>" href="<?=$sect1['URL']?>">Все <?=$sect1['NAME']?></a>
                        <br>
                        <br>
                    </div>
                    <div>
                    <?if($sect1['CHILDS']){
                        foreach ($sect1['CHILDS'] as $scode2 => $sect2){
                            $showModel = $arVariables['MODEL'] == $scode2;
                            ?>
                            <a class="btn btn-default border <?=$showModel ? 'btn-primary' : ''?>" href="<?=$sect2['URL']?>"><?=$sect2['NAME']?></a>
                            <?
                        }
                    }?>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
    ?>
    </div><?
}

?>
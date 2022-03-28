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
use \Bitrix\Main\Application,
    \Bitrix\Main\Localization\Loc;
$this->addExternalCss("/bitrix/css/ibs.shopnotebook/bootstrap.min.css");
$this->addExternalJs("/bitrix/js/ibs.shopnotebook/bootstrap.min.js");
$request = Application::getInstance()->getContext()->getRequest();
$arVariables = $arResult['VARIABLES'];

if($arResult['NAME']){
?>
<h1><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_ITEM',['#NAME#'=>$arResult['NAME']])?></h1>
<br>
<br>
<h2><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_PRICE',['#PRICE#'=>number_format($arResult['PRICE'], 0, '', ' ')])?></h2>
<br>
<br>
<div class="container">
    <table class="table">
        <?if($arResult['BRAND']){
            ?>
            <tbody>
            <tr>
                <th><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_BRAND')?></th>
                <td><?=$arResult['BRAND']?></td>
            </tr>
            </tbody>
            <?
        }?>
        <?if($arResult['MODEL']){
            ?>
            <tbody>
            <tr>
                <th><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_MODEL')?></th>
                <td><?=$arResult['MODEL']?></td>
            </tr>
            </tbody>
            <?
        }?>
        <?
        if($arResult['PROPS']){
            foreach ($arResult['PROPS'] as $prop){
                ?><tbody>
                    <tr>
                        <th scope="row"><?=$prop['NAME']?></th>
                        <td>
                            <?foreach ($prop['VALUES'] as $value){
                                echo $value['VALUE'].'<br>';
                            }?>
                        </td>
                    </tr>
                </tbody><?
            }
        }
        ?>
    </table>
</div>
<?}else{
    header("HTTP/1.0 404 Not Found");
}
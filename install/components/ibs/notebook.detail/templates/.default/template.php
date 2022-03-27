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
use \Bitrix\Main\Application;
$this->addExternalCss($templateFolder."/css/bootstrap.min.css");
$this->addExternalJs($templateFolder."/js/bootstrap.min.js");
$request = Application::getInstance()->getContext()->getRequest();
$arVariables = $arResult['VARIABLES'];

if($arResult['NAME']){
?>
<h1><?='Ноутбук '.$arResult['NAME']?></h1>
<br>
<br>
<h2>Цена: <?=number_format($arResult['PRICE'], 0, '', ' ')?></h2>
<br>
<br>
<div class="container">
    <table class="table">
        <?if($arResult['BRAND']){
            ?>
            <tbody>
            <tr>
                <th>Бренд</th>
                <td><?=$arResult['BRAND']?></td>
            </tr>
            </tbody>
            <?
        }?>
        <?if($arResult['MODEL']){
            ?>
            <tbody>
            <tr>
                <th>Модель</th>
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
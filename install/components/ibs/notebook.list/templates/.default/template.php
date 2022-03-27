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
$this->setFrameMode(true);
$this->addExternalCss($templateFolder."/css/bootstrap.min.css");
$this->addExternalJs($templateFolder."/js/bootstrap.min.js");
$request = Application::getInstance()->getContext()->getRequest();

?>
<div class="container notebook-list">
    <div class="row">
        <?
        if(!empty($arResult['ITEMS'])){
            foreach ($arResult['ITEMS'] as $item){
                ?>
                <div class="col-12 notebook-item">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?=$item['URL']?>"><?=$item['NAME']?></a>
                        </div>
                        <div class="col-6">
                            <div>Цена: <b><?=number_format($item['PRICE'], 0, '', ' ');?></b></div>
                            <div>
                                <a href="<?=$item['URL']?>">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?
            }


            if($arResult['COUNT_TOTAL'] > $arParams['ELEMENTS_COUNT']){
                ?>
                <nav>
                    <ul class="pagination">
                        <?
                        $i = 1;//счетчик
                        $page_count = ceil($arResult['COUNT_TOTAL'] / $arParams['ELEMENTS_COUNT']);//количество страниц
                        $curpage = $request['page'];
                        $fPoints = false;
                        $lPoints = false;
                        if($page_count > 1){
                            ?>
                            <?if($curpage == 1 || !$curpage == 1){
                                ?>
                                <li class="page-item prev disabled">
                                    <span class="page-link">Предыдущая</span>
                                </li>
                                <?
                            }else{
                                ?>
                                <li class="page-item prev">
                                    <a class="page-link" href="<?=$APPLICATION->GetCurPageParam($arParams['PAGE_NUMBER_GET_NAME']."=".($curpage-1),array($arParams['PAGE_NUMBER_GET_NAME']))?>">Предыдущая</a>
                                </li>
                                <?
                            }?>
                            <?
                            while ($i <= $page_count){
                                if($i == 1 || $i == $page_count || (($curpage) ? ($i == $curpage || $i == ($curpage - 1) ||
                                        $i == ($curpage - 1) || //кол-во страниц в середине пагинации - текущая плюс 1 и плюс значение ниже
                                        $i == ($curpage + 1) ||
                                        $i == ($curpage + 1)) //кол-во страниц в середине пагинации - текущая плюс 1 и плюс значение выше
                                        : ($i <= 3))):
                                    ?><li class="page-item <?=($curpage) ? ($curpage == $i) ? 'active' : '' : (($i == 1) ? 'active' : '')?>">
                                        <a class="page-link" href="<?=$APPLICATION->GetCurPageParam($arParams['PAGE_NUMBER_GET_NAME']."=".$i,array($arParams['PAGE_NUMBER_GET_NAME']))?>"><?=$i?></a>
                                    </li><?
                                else:
                                    if(!$fPoints && $i < $curpage):
                                        ?><li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li><?
                                        $fPoints = true;
                                    endif;
                                    if(!$lPoints && $i > $curpage):
                                        ?><li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li><?
                                        $lPoints = true;
                                    endif;
                                endif;
                                $i++;
                            }
                            ?>
                            <?if($curpage == $page_count){
                                ?>
                                <li class="page-item next disabled">
                                    <span class="page-link">Следующая</span>
                                </li>
                                <?
                            }else{
                                ?>
                                <li class="page-item next">
                                    <a class="page-link" href="<?=$APPLICATION->GetCurPageParam($arParams['PAGE_NUMBER_GET_NAME']."=".($curpage+1),array($arParams['PAGE_NUMBER_GET_NAME']))?>">Следующая</a>
                                </li>
                                <?
                            }?>
                            <?
                        }
                        ?>
                    </ul>
                </nav>
                <?
            }
        }else{
            ?>
            <p>Ничего не найдено</p>
            <?
        }
        ?>
    </div>
</div>

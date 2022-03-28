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
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/ibs.shopnotebook/bootstrap.min.css");
$this->addExternalJs("/bitrix/js/ibs.shopnotebook/bootstrap.min.js");
$this->addExternalJs("/bitrix/js/ibs.shopnotebook/bootstrap.bundle.min.js");
$request = Application::getInstance()->getContext()->getRequest();

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSort" data-bs-toggle="dropdown" aria-expanded="false">
                    <?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_SORT')?>
                </button>
                <?
                if($request['order']){
                    $orderActive = $request['order'];
                }elseif($arParams['SORT_ORDER'] && $arParams['SORT_BY']){
                    $orderDefault = $orderActive = strtolower($arParams['SORT_ORDER']).'_'.strtolower($arParams['SORT_BY']);
                }
                ?>
                <ul class="dropdown-menu" aria-labelledby="dropdownSort">
                    <li><a class="dropdown-item <?=$orderActive == 'price_asc' ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=price_asc", array("order"))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_SORT_PRICE_ASC')?></a></li>
                    <li><a class="dropdown-item <?=$orderActive == 'price_desc' ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=price_desc", array("order"))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_SORT_PRICE_DESC')?></a></li>
                    <li><a class="dropdown-item <?=$orderActive == 'year_asc' ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=year_asc", array("order"))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_SORT_YEAR_ASC')?></a></li>
                    <li><a class="dropdown-item <?=$orderActive == 'year_desc' ? 'active' : ''?>" href="<?=$APPLICATION->GetCurPageParam("order=year_desc", array("order"))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_SORT_YEAR_DESC')?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<br>
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
                            <div><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_PRICE',['#PRICE#'=>number_format($item['PRICE'], 0, '', ' ')])?></div>
                            <div>
                                <a href="<?=$item['URL']?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_LINK_MORE')?></a>
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
                                    <span class="page-link"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_NAV_LINK_PREV')?></span>
                                </li>
                                <?
                            }else{
                                ?>
                                <li class="page-item prev">
                                    <a class="page-link" href="<?=$APPLICATION->GetCurPageParam($arParams['PAGE_NUMBER_GET_NAME']."=".($curpage-1),array($arParams['PAGE_NUMBER_GET_NAME']))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_NAV_LINK_PREV')?></a>
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
                                    <span class="page-link"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_NAV_LINK_NEXT')?></span>
                                </li>
                                <?
                            }else{
                                ?>
                                <li class="page-item next">
                                    <a class="page-link" href="<?=$APPLICATION->GetCurPageParam($arParams['PAGE_NUMBER_GET_NAME']."=".($curpage+1),array($arParams['PAGE_NUMBER_GET_NAME']))?>"><?=Loc::getMessage('IVS_SHOPNOTEBOOK_COMPONENT_NOTEBOOK_DETAIL_NAV_LINK_NEXT')?></a>
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

<?php
namespace Ibs\ShopNotebook;

class helper
{
    static public function getbrandsandmodels(array $arResult) : array
    {
        $arBrands = [];
        $arModels = [];
        $sectionsres = \Ibs\ShopNotebook\BrandsTable::getList([
            'select' => [
                '*',
                'MODEL_'=>'\Ibs\ShopNotebook\ModelsTable:BRAND',
            ]
        ]);

        while ($section = $sectionsres->fetch()){
            if(!$arBrands[$section['CODE']]) $arBrands[$section['CODE']] = array(
                'ID'=>$section['ID'],
                'CODE'=>$section['CODE'],
                'NAME'=>$section['NAME'],
                'URL'=>str_replace('#BRAND#', $section['CODE'], $arResult['FOLDER'].$arResult['URL_TEMPLATES']['models'])
            );

            $arModels[$section['MODEL_CODE']] = $arBrands[$section['CODE']]['CHILDS'][$section['MODEL_CODE']] = array(
                'ID'=>$section['MODEL_ID'],
                'CODE'=>$section['MODEL_CODE'],
                'NAME'=>$section['MODEL_NAME'],
                'URL'=>str_replace(['#BRAND#','#MODEL#'], [$section['CODE'],$section['MODEL_CODE']], $arResult['FOLDER'].$arResult['URL_TEMPLATES']['notebooks'])
            );
        }

        return array('BRANDS'=>$arBrands,'MODELS'=>$arModels);
    }

    static public function getPropRelationNameFromCollection($element)
    {
        $fields = array();
        $props = $element->collectValues(
            \Bitrix\Main\ORM\Objectify\Values::ALL,
            \Bitrix\Main\ORM\Fields\FieldTypeMask::RELATION
        );
        if ($props) {
            foreach ($props as $code => $prop) {
                if ($prop) {
                    $propOb = $element->get($code);
                    $fields[$code] = $propOb->getName();
                    $fields[$code.'_CODE'] = $propOb->getCode();
                    $fields = array_merge($fields, self::getPropRelationNameFromCollection($propOb));
                }
            }
        }
        return $fields;
    }
}
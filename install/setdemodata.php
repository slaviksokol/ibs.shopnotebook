<?
//$obInstall = new ibs_shopnotebook();
//
//$classList = $obInstall->getClassesTable();

$data = array(
    '\Ibs\ShopNotebook\BrandsTable'=>[
        ['NAME'=>'Samsung','CODE'=>'samsung'],
        ['NAME'=>'MSI','CODE'=>'msi'],
        ['NAME'=>'Apple','CODE'=>'apple']],
    '\Ibs\ShopNotebook\ModelsTable'=>[
        ['NAME'=>'D 100','CODE'=>'d_100','BRAND'=>'samsung'],
        ['NAME'=>'D 200','CODE'=>'d_200','BRAND'=>'samsung'],
        ['NAME'=>'D 300','CODE'=>'d_300','BRAND'=>'samsung'],
        ['NAME'=>'GX 75','CODE'=>'gx_75','BRAND'=>'msi'],
        ['NAME'=>'GX 70','CODE'=>'gx_70','BRAND'=>'msi'],
        ['NAME'=>'Air','CODE'=>'air','BRAND'=>'apple'],
        ['NAME'=>'Pro','CODE'=>'pro','BRAND'=>'apple'],
    ],
    '\Ibs\ShopNotebook\NotebooksTable'=>[
        ['NAME'=>'Samsung D 300','CODE'=>'samsung_d_300','MODEL'=>'d_300','YEAR'=>2020,'PRICE'=>40000],
        ['NAME'=>'Samsung D 200','CODE'=>'samsung_d_200','MODEL'=>'d_200','YEAR'=>2021,'PRICE'=>35000],
        ['NAME'=>'MSI GX 75','CODE'=>'msi_gx_75','MODEL'=>'gx_75','YEAR'=>2021,'PRICE'=>55000],
        ['NAME'=>'Macbook Pro','CODE'=>'macbook_pro','MODEL'=>'pro','YEAR'=>2022,'PRICE'=>90000],
        ['NAME'=>'Macbook Air','CODE'=>'macbook_air','MODEL'=>'air','YEAR'=>2022,'PRICE'=>8000],
    ],
    '\Ibs\ShopNotebook\PropsTable'=>[
        ['NAME'=>'Процессор','CODE'=>'processor'],
        ['NAME'=>'Оперативная память','CODE'=>'ram'],
        ['NAME'=>'Жесткий диск','CODE'=>'hard'],
    ],
    '\Ibs\ShopNotebook\PropsValuesTable'=>[
//        ['VALUE'=>'Core i5','CODE'=>'core_i5','PROP'=>'processor','NOTEBOOK'=>'samsung_d_300'],
        ['VALUE'=>'Core i5','CODE'=>'core_i5','PROP'=>'processor','NOTEBOOK'=>'samsung_d_200'],
        ['VALUE'=>'8 Гб','CODE'=>'8_gb','PROP'=>'ram','NOTEBOOK'=>'samsung_d_200'],
        ['VALUE'=>'80 Гб','CODE'=>'80_gb','PROP'=>'hard','NOTEBOOK'=>'samsung_d_200'],
        ['VALUE'=>'500 Гб','CODE'=>'500_gb','PROP'=>'hard','NOTEBOOK'=>'samsung_d_200'],
        ['VALUE'=>'Core i5','CODE'=>'core_i5','PROP'=>'processor','NOTEBOOK'=>'msi_gx_75'],
        ['VALUE'=>'Core i5','CODE'=>'core_i5','PROP'=>'processor','NOTEBOOK'=>'macbook_air'],
        ['VALUE'=>'Core i7','CODE'=>'core_i7','PROP'=>'processor','NOTEBOOK'=>'macbook_pro'],
    ]
);

foreach ($data as $className => $items){
    foreach ($items as $item){
        $item2 = $item;
        unset($item['BRAND'],$item['MODEL'],$item['PROP'],$item['NOTEBOOK']);
        $result = $className::add($item);
        if ($result->isSuccess()) {
            $cur_item = $className::getByPrimary($result->getId())->fetchObject();
            if($item2['BRAND']){
                $res = \Ibs\ShopNotebook\BrandsTable::getList(['filter'=>['CODE'=>$item2['BRAND']]])->fetchObject();
                $cur_item->set('BRAND',$res);
            }
            if($item2['MODEL']){
                $res = \Ibs\ShopNotebook\ModelsTable::getList(['filter'=>['CODE'=>$item2['MODEL']]])->fetchObject();
                $cur_item->set('MODEL',$res);
            }
            if($item2['PROP']){
                $res = \Ibs\ShopNotebook\PropsTable::getList(['filter'=>['CODE'=>$item2['PROP']]])->fetchObject();
                $cur_item->set('PROP',$res);
            }
            if($item2['NOTEBOOK']){
                $res = \Ibs\ShopNotebook\NotebooksTable::getList(['filter'=>['CODE'=>$item2['NOTEBOOK']]])->fetchObject();
                $cur_item->set('NOTEBOOK',$res);
            }
            $cur_item->save();
        }else{
//            $result->getErrorMessages();
        }

    }
}
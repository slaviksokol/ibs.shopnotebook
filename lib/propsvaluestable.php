<?php
namespace Ibs\ShopNotebook;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\TextField,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Query\Join,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class PropsValuesTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ID_PROP int mandatory
 * <li> ID_NOTEBOOK int mandatory
 * <li> VALUE string(255) mandatory
 * <li> CODE text optional
 * </ul>
 *
 * @package Ibs\ShopNotebook
 **/

class PropsValuesTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'ibs_shop_notebook_props_values';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('NOTEBOOK_PROPS_VALUES_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'ID_PROP',
                [
                    'title' => Loc::getMessage('NOTEBOOK_PROPS_VALUES_ENTITY_ID_PROP_FIELD')
                ]
            ),
            (new Reference(
                'PROP',
                PropsTable::class,
                Join::on('this.ID_PROP', 'ref.ID')
            ))
                ->configureJoinType('inner'),
            new IntegerField(
                'ID_NOTEBOOK',
                [
                    'title' => Loc::getMessage('NOTEBOOK_PROPS_VALUES_ENTITY_ID_NOTEBOOK_FIELD')
                ]
            ),
            (new Reference(
                'NOTEBOOK',
                NotebooksTable::class,
                Join::on('this.ID_NOTEBOOK', 'ref.ID')
            ))
                ->configureJoinType('inner'),
            new StringField(
                'VALUE',
                [
                    'required' => true,
                    'validation' => [__CLASS__, 'validateValue'],
                    'title' => Loc::getMessage('NOTEBOOK_PROPS_VALUES_ENTITY_VALUE_FIELD')
                ]
            ),
            new TextField(
                'CODE',
                [
                    'title' => Loc::getMessage('NOTEBOOK_PROPS_VALUES_ENTITY_CODE_FIELD')
                ]
            ),
        ];
    }

    /**
     * Returns validators for VALUE field.
     *
     * @return array
     */
    public static function validateValue()
    {
        return [
            new LengthValidator(null, 255),
        ];
    }
}
<?php
namespace Ibs\ShopNotebook;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\FloatField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\TextField,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Query\Join,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class NotebooksTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ID_MODEL int mandatory
 * <li> NAME string(255) mandatory
 * <li> CODE text optional
 * <li> YEAR int mandatory
 * <li> PRICE double mandatory
 * </ul>
 *
 * @package Ibs\ShopNotebook
 **/

class NotebooksTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'ibs_shop_notebook_notebooks';
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
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'ID_MODEL',
                [
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_ID_MODEL_FIELD')
                ]
            ),
            (new Reference(
                'MODEL',
                ModelsTable::class,
                Join::on('this.ID_MODEL', 'ref.ID')
            ))
                ->configureJoinType('inner'),
            new StringField(
                'NAME',
                [
                    'required' => true,
                    'validation' => [__CLASS__, 'validateName'],
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_NAME_FIELD')
                ]
            ),
            new TextField(
                'CODE',
                [
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'YEAR',
                [
                    'required' => true,
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_YEAR_FIELD')
                ]
            ),
            new FloatField(
                'PRICE',
                [
                    'required' => true,
                    'title' => Loc::getMessage('NOTEBOOK_NOTEBOOKS_ENTITY_PRICE_FIELD')
                ]
            ),
        ];
    }

    /**
     * Returns validators for NAME field.
     *
     * @return array
     */
    public static function validateName()
    {
        return [
            new LengthValidator(null, 255),
        ];
    }
}
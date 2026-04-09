<?php

namespace Admin\Http\Sections;

use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface,
    Contracts\Form\FormInterface,
    Section,
    Display\Tree\OrderTreeType
};
use AdminDisplay,
    AdminForm,
    AdminFormElement;

/**
 * Class MapCategories
 * @package Admin\Http\Sections
 */
class MapCategories extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Категории меток';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::tree(OrderTreeType::class)
            ->setValue('name')
            ->setNewEntryButtonText('Добавить категорию');
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        /**
         * @var FormInterface
         */
        return AdminForm::form()->setElements([
            AdminFormElement::checkbox('active', 'Активность'),
            AdminFormElement::text('name', 'Название')->required(),
        ]);
    }
}

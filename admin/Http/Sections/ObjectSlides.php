<?php

namespace Admin\Http\Sections;

use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface,
    Contracts\Form\FormInterface,
    Section
};

use AdminDisplay,
    AdminColumn,
    AdminColumnEditable,
    AdminForm,
    AdminFormElement;

/**
 * Class MapFilters
 * @package Admin\Http\Sections
 */
class ObjectSlides extends Section
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
    protected $title = 'Слайды объекта';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumn::text('name', 'Название'),
                AdminColumn::order()
                    ->setLabel('Порядок'),
            ])
            ->setApply(function ($query) {
                /**
                 * @var Builder $query
                 */
                $query->orderBy('order', 'asc');
            })
            ->setNewEntryButtonText('Добавить слайд')
            ->paginate(20);
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
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::textarea('description', 'Описание'),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}

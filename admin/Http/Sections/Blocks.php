<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface,
    Contracts\Form\FormInterface,
    Section
};

/**
 * Class Blocks
 * @package Admin\Http\Sections
 */
class Blocks extends Section
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
    protected $title = 'Корпуса';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumn::text('number', 'Номер'),
                AdminColumn::order()
                    ->setLabel('Порядок'),

            ])
            ->setApply(function ($query) {
                /**
                 * @var Builder $query
                 */
                $query->orderBy('order', 'asc');
            })
            ->setNewEntryButtonText('Добавить корпус')
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
            AdminFormElement::text('number', 'Номер')->required(),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return string
     */
    public function getCreateTitle()
    {
        return 'Добавление корпуса';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование данных корпуса';
    }
}

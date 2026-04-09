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
class Decorations extends Section
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
    protected $title = 'Отделка';

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
            ->setNewEntryButtonText('Добавить отделку')
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
            AdminFormElement::text('code', 'Код')->required(),
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::text('description', 'Описание'),
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
        return 'Добавление отделку';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование отделки';
    }
}

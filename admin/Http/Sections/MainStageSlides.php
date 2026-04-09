<?php

namespace Admin\Http\Sections;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface, Contracts\Form\FormInterface, Section
};

use AdminDisplay,
    AdminColumn,
    AdminColumnEditable,
    AdminForm,
    AdminFormElement;

/**
 * Class MainStageImages
 * @package Admin\Http\Sections\System
 */
class MainStageSlides extends Section
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
    protected $title = 'Главный слайдер';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumnEditable::text('title', 'Заголовок'),
                AdminColumnEditable::text('description', 'Текст'),
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
            AdminFormElement::text('title', 'Заголовок')->required(),
            AdminFormElement::textarea('description', 'Текст')->required(),
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
     * @return bool
     */
    public function isCreatable()
    {
        return true;
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return false;
    }
}

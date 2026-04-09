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
class Schemes extends Section
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
    protected $title = 'Планировки этажей';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('code', 'code')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumnEditable::text('name', 'Название'),
                AdminColumn::image('scheme_img', 'Подложка'),
            ])
            ->setNewEntryButtonText('Добавить планировку')
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
            AdminFormElement::textarea('scheme_svg', 'Схема этажа')->required(),
            AdminFormElement::image('scheme_img', 'Подложка')->required(),
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
        return 'Добавление планировки';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование планировки этажа';
    }
}

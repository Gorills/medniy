<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface, Contracts\Form\FormInterface, Section
};

/**
 * Class ConstructionStages
 * @package Admin\Http\Sections
 */
class ConstructionStages extends Section
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
    protected $title = 'Этапы строительства';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumnEditable::text('name', 'Имя'),
                AdminColumn::image('image', 'Фото'),
            ])
            ->setNewEntryButtonText('Добавить этап')
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
            AdminFormElement::image('image', 'Фото')->required(),
            AdminFormElement::date('created_at', 'Дата')->required(),
            AdminFormElement::text('name', 'Имя'),
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
        return 'Добавление этапа строительства';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Изменение этапа строительства';
    }
}

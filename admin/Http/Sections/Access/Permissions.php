<?php

namespace Admin\Http\Sections\Access;

use Illuminate\Database\Eloquent\Model;

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
 * Class Permissions
 *
 * @property \App\Models\Access\Permission $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Permissions extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;

    /**
     * @var string
     */
    protected $title = 'Права';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('name', 'Код'),
                AdminColumn::text('display_name', 'Имя'),
                AdminColumn::text('description', 'Описание'),
            ])
            ->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::form([
            AdminFormElement::text('name', 'Код')->required()->unique()->setReadonly(1),
            AdminFormElement::text('display_name', 'Название')->required(),
            AdminFormElement::textarea('description', 'Описание')->setHelpText('Краткое описание того, что дает это ограничение'),
        ]);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return false;
    }

    /**
     * Edit page title
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование прав';
    }
}

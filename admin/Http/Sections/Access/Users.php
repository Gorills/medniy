<?php

namespace Admin\Http\Sections\Access;

use AdminColumn,
    AdminDisplay,
    AdminForm,
    AdminFormElement;

use App\Models\Access\{
    Role,
    User
};

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface,
    Contracts\Form\FormInterface,
    Section
};

/**
 * Class Users
 *
 * @property \App\Models\Access\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Users extends Section
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
    protected $title = 'Пользователи';

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
            ->setNewEntryButtonText('Новый пользователь')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('name', 'Имя'),
                AdminColumn::text('email', 'Email'),
                AdminColumn::lists('roles.display_name', 'Роли'),
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
        return AdminForm::form()->setElements([
            AdminFormElement::text('name', 'Name')->required(),
            AdminFormElement::text('email', 'Email')->required(),
            AdminFormElement::multiselect('roles', 'Группы', Role::class)->setDisplay('display_name'),
            AdminFormElement::password('password', 'Пароль')->required(),
            AdminFormElement::password('password_confirmation', 'Подтверждение пароля')
                ->required()
                ->addValidationRule('same:password')
                ->setValueSkipped(true),
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
     * Create page title
     * @return string
     */
    public function getCreateTitle()
    {
        return 'Создание нового пользователя';

        parent::getCreateTitle();
    }

    /**
     * Edit page title
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование пользователя';
    }
}

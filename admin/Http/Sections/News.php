<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.19
 * Time: 18:35
 */

namespace Admin\Http\Sections;

use App\Models\MapCategory;
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
 * Class MapSubcategories
 * @package Admin\Http\Sections
 */
class News extends Section
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
    protected $title = 'Новости';

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
            ])
            ->setNewEntryButtonText('Добавить новость')
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
            AdminFormElement::date('active_from', 'Активно с')->required(),
//            AdminFormElement::date('active_to', 'Активно по'),
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::ckeditor('preview_text', 'Краское описание')->required(),
//            AdminFormElement::image('preview_picture', 'Картинка'),
            AdminFormElement::ckeditor('detail_text', 'Текст новости')->required(),
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
        return 'Добавление новости';
    }


}

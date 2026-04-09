<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\GalleryPhoto;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface, Contracts\Form\FormInterface, Section
};
use App\Models\{
    Block
};

/**
 * Class GalleryPhotos
 * @package Admin\Http\Sections
 * @property GalleryPhoto $model
 */
class GalleryPhotos extends Section
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
    protected $title = 'Галерея';

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
                AdminColumnEditable::select('block_id', 'Корпус', Block::class)->setDisplay('number'),
                AdminColumn::image('image', 'Картинка')
            ])
            ->setNewEntryButtonText('Добавить фото')
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
            AdminFormElement::text('name', 'Имя'),
            AdminFormElement::select('block_id', 'Категория')
                ->setModelForOptions(Block::class)
                ->setDisplay('number')
                ->required(),
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
        return 'Добавление фото';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Изменение фото';
    }
}

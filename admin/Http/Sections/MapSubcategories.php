<?php

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
class MapSubcategories extends Section
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
    protected $title = 'Подкатегории меток';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::checkbox('active', 'Активность'),
                AdminColumnEditable::select('map_category_id', 'Категория', MapCategory::class)->setDisplay('name'),
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
            ->setNewEntryButtonText('Добавить подкатегорию')
            ->paginate(20);
    }

    /**
     * @param $id
     * @return \SleepingOwl\Admin\Form\FormDefault
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
     */
    public function onEdit($id)
    {
        /**
         * @var FormInterface
         */
        return AdminForm::form()->setElements([
            AdminFormElement::checkbox('active', 'Активность'),
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::select('map_category_id', 'Категория')
                ->setModelForOptions(MapCategory::class)
                ->setDisplay('name')
                ->required(),
        ]);
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormDefault
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}

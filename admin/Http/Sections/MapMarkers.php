<?php

namespace Admin\Http\Sections;

use App\Models\MapCategory;
use App\Models\MapMarker;
use App\Models\MapSubcategory;
use Illuminate\Database\Eloquent\Builder;
use SleepingOwl\Admin\{
    Contracts\Display\DisplayInterface,
    Contracts\Form\FormInterface,
    Display\Column\Editable\Select,
    Form\Element\DependentSelect,
    Section
};

use AdminDisplay,
    AdminColumn,
    AdminColumnEditable,
    AdminForm,
    AdminFormElement;

/**
 * Class MapMarkers
 * @package Admin\Http\Sections
 */
class MapMarkers extends Section
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
    protected $title = 'Метки на карте';

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
                AdminColumn::text('mapCategory.name', 'Категория'),
                AdminColumn::text('mapSubcategory.name', 'Подкатегория'),
            ])
            ->setNewEntryButtonText('Добавить метку')
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
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::select('map_category_id', 'Категория', MapCategory::class)->setDisplay('name')->required()->nullable(),
            AdminFormElement::dependentselect('map_subcategory_id', 'Подкатегория')
                ->setModelForOptions(MapSubcategory::class)
                ->setDisplay('name')
                ->setDataDepends('map_category_id')
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    /** @var DependentSelect $element */
                    /** @var Builder $query */
                    return $query->where('map_category_id', $element->getDependValue('map_category_id'));
                }),
            AdminFormElement::text('address', 'Адрес')->required(),
            AdminFormElement::number('distance', 'Расстояние')->setStep(1)->required(),
            AdminFormElement::number('time', 'Время')->setStep(1)->required(),
            AdminFormElement::image('image', 'Картинка')->required(),
            AdminFormElement::select('transport', 'Транспорт', MapMarker::getTransports())->required(),
            AdminFormElement::number('lat', 'Широта')->setStep(0.0000001)->required(),
            AdminFormElement::number('lon', 'Долгота')->setStep(0.0000001)->required(),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}

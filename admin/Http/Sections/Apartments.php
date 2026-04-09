<?php

namespace Admin\Http\Sections;

use Admin\Widgets\ApartmentsImportForm;
use App\Models\Block;
use App\Models\Decoration;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\{
    Contracts\Form\FormInterface,
    Section,
    Contracts\Display\DisplayInterface,
    Contracts\Display\Extension\FilterInterface
};

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminTab;
use AdminFormElement;
use AdminColumnFilter;

/**
 * Class Apartments
 * @package Admin\Http\Sections
 */
class Apartments extends Section
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
    protected $title = 'Квартиры';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $tabs = AdminDisplay::tabbed();

        {
            $display = AdminDisplay::datatablesAsync()
                ->setColumns([
                    AdminColumn::text('id', '#')->setWidth('30px'),
                    AdminColumnEditable::checkbox('active', 'Активность'),
                    AdminColumnEditable::text('number', 'Номер'),
                    AdminColumnEditable::text('code', 'Код'),
                    AdminColumn::text('block.number', 'Корпус', Block::class),
                    AdminColumn::text('floor.number', 'Этаж', Floor::class),


                ]);

            $display->setColumnFilters([
                null,
                null,
                null,
                null,
                AdminColumnFilter::select()
                    ->setModelForOptions(new Block())
                    ->setDisplay('number')
                    ->setPlaceholder('Корпус')
                    ->setOperator(FilterInterface::EQUAL)
                    ->setColumnName('block_id'),

            ]);
            $display->getColumnFilters()->setPlacement('table.header');

            $display->paginate(20);
            $display->setNewEntryButtonText('Добавить квртиру');
            $tabs->appendTab(
                $display,
                'Список квартир'
            );
        }

        return $tabs;
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
        return AdminForm::form()
            ->setElements([
                AdminFormElement::checkbox('active', 'Активность'),
                AdminFormElement::text('number', 'Номер')->required(),
                AdminFormElement::text('code', 'Код')->required(),

                AdminFormElement::select('block_id', 'Корпус')
                    ->setModelForOptions(Block::class)
                    ->setDisplay('number')
                    ->required(),

                AdminFormElement::dependentselect('floor_id', 'Этаж')
                    ->setModelForOptions(Floor::class)
                    ->setDisplay('number')
                    ->setDataDepends('block_id')
                    ->setLoadOptionsQueryPreparer(function ($element, $query) {
                        /** @var DependentSelect $element */
                        /** @var Builder $query */
                        return $query->where('block_id', $element->getDependValue('block_id'));
                    })
                    ->required(),

                AdminFormElement::text('rooms', 'Количество комнат')->required(),
                AdminFormElement::text('total_area', 'Общая площадь')->required(),
                AdminFormElement::text('bathroom_area', 'Площадь ванной')->required(),
                AdminFormElement::text('cost', 'Цена м2')->required(),
                AdminFormElement::text('price', 'Стоимость')->required(),
                AdminFormElement::select('decoration_id', 'Отделка')
                    ->setModelForOptions(Decoration::class)
                    ->setDisplay('name')
                    ->required(),
                AdminFormElement::text('kitchen', 'Кухня')->required(),
                AdminFormElement::images('images', 'Картинки'),
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
        return 'Добавление квртиры';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование данных квартиры';
    }
}

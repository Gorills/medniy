<?php

namespace Admin\Http\Sections;

use App\Models\Block;
use App\Models\Scheme;
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
 * Class Blocks
 * @package Admin\Http\Sections
 */
class Floors extends Section
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
    protected $title = 'Этажи';

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
                    AdminColumnEditable::select('block_id', 'Корпус', Block::class)->setDisplay('number'),


                ]);

            $display->setColumnFilters([
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
            $display->setNewEntryButtonText('Добавить этаж');
            $tabs->appendTab(
                $display,
                'Список этажей'
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
        return AdminForm::form()->setElements([
            AdminFormElement::checkbox('active', 'Активность'),
            AdminFormElement::text('number', 'Номер')->required(),
            AdminFormElement::select('block_id', 'Корпус')
                ->setModelForOptions(Block::class)
                ->setDisplay('number')
                ->required(),
            AdminFormElement::select('scheme_id', 'Схема')
                ->setModelForOptions(Scheme::class)
                ->setDisplay('name')
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
        return 'Добавление этажа';
    }

    /**
     * @return string
     */
    public function getEditTitle(Model $model)
    {
        return 'Редактирование данных этажа';
    }
}

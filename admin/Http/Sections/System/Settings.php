<?php

namespace Admin\Http\Sections\System;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;

use AdminDisplay;
use AdminColumn;
use AdminColumnEditable;
use AdminTab;
use AdminForm;
use AdminFormElement;

/**
 * Class Settings
 * @package Admin\Sections
 */
class Settings extends Section implements Initializable
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
    protected $title = 'Настройки';

    /**
     * @var string
     */
    protected $alias = 'settings';

    /**
     * Initialize class.
     */
    public function initialize()
    {
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::datatablesAsync()
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumnEditable::text('name', 'Name'),
                AdminColumn::text('code', 'Code'),
                AdminColumnEditable::text('value', 'Value'),
                AdminColumnEditable::text('description', 'Description'),
            ])
            ->paginate(10);
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
            AdminFormElement::text('name', 'Name'),
            AdminFormElement::text('code', 'Code')->setReadonly(1),
            AdminFormElement::text('value', 'Value'),
            AdminFormElement::text('description', 'Description'),
        ]);
    }
}

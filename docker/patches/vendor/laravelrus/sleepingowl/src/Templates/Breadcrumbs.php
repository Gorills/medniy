<?php

namespace SleepingOwl\Admin\Templates;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use DaveJamesMiller\Breadcrumbs\Exceptions\UnnamedRouteException;
use Illuminate\Support\HtmlString;
use SleepingOwl\Admin\Contracts\Template\BreadcrumbsInterface as BreadcrumbsContract;

/**
 * Адаптация под davejamesmiller/laravel-breadcrumbs 5.x (BreadcrumbsManager + viewFactory).
 * Оригинал Sleeping Owl ожидал удалённый API (Manager / currentRoute / $this->view).
 */
class Breadcrumbs extends BreadcrumbsManager implements BreadcrumbsContract
{
    /**
     * @var string|null
     */
    protected $viewName;

    /**
     * @param string $viewName
     *
     * @return void
     */
    public function setView($viewName)
    {
        $this->viewName = $viewName;
    }

    /**
     * @param string|null $name
     *
     * @return HtmlString
     */
    public function render(?string $name = null, ...$params): HtmlString
    {
        if ($name === null) {
            $breadcrumbs = $this->generate();
        } else {
            $breadcrumbs = $this->generate($name, ...$params);
        }

        return new HtmlString($this->renderBreadcrumbBlade($breadcrumbs));
    }

    /**
     * @param string|null $name
     *
     * @return string
     */
    public function renderIfExists($name = null)
    {
        if (is_null($name)) {
            try {
                [$name, $params] = $this->getCurrentRoute();
            } catch (UnnamedRouteException $e) {
                return '';
            }
            if (!$this->exists($name)) {
                return '';
            }

            return (string) $this->render($name, ...$params);
        }

        if (!$this->exists($name)) {
            return '';
        }

        $args = func_get_args();

        return (string) $this->render(...$args);
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function renderArray($name, $params = [])
    {
        $breadcrumbs = $this->generate($name, ...$params);

        return $this->renderBreadcrumbBlade($breadcrumbs);
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function renderIfExistsArray($name, $params = [])
    {
        if (!$this->exists($name)) {
            return '';
        }

        return $this->renderArray($name, $params);
    }

    /**
     * @param \Illuminate\Support\Collection|array $breadcrumbs
     *
     * @return string
     */
    protected function renderBreadcrumbBlade($breadcrumbs)
    {
        if (!$this->viewName) {
            throw new \RuntimeException('Breadcrumb view not set (SleepingOwl Template::renderBreadcrumbs).');
        }

        return $this->viewFactory->make($this->viewName, ['breadcrumbs' => $breadcrumbs])->render();
    }
}

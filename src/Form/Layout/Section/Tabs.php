<?php

declare(strict_types=1);

namespace Atk4\Ui\Form\Layout\Section;

use Atk4\Ui\Form\Layout as FormLayout;
use Atk4\Ui\Tab;

/**
 * Represents form controls in tabs.
 */
class Tabs extends \Atk4\Ui\Tabs
{
    public $formLayout = FormLayout::class;
    public $form;

    /**
     * Adds tab in tabs widget.
     *
     * @param string|Tab $name     Name of tab or Tab object
     * @param \Closure   $callback Callback action or URL (or array with url + parameters)
     * @param array      $settings tab settings
     *
     * @return FormLayout
     */
    public function addTab($name, \Closure $callback = null, $settings = [])
    {
        $tab = parent::addTab($name, $callback, $settings);

        return FormLayout::addToWithCl($tab, [$this->formLayout, 'form' => $this->form]);
    }
}

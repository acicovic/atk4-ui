<?php

declare(strict_types=1);

namespace atk4\ui;

class GridLayout extends View
{
    /** @var int Number of rows */
    protected $rows = 1;

    /** @var int Number of columns */
    protected $columns = 2;

    /** @var array Array of columns css wide classes */
    protected $words = [
        '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve',
        'thirteen', 'fourteen', 'fifteen', 'sixteen',
    ];

    /**
     * @var HtmlTemplate
     */
    protected $t_wrap;

    /**
     * @var HtmlTemplate
     */
    protected $t_row;

    /**
     * @var HtmlTemplate
     */
    protected $t_col;

    /**
     * @var HtmlTemplate
     */
    public $template;

    /** @var string Semantic UI CSS class */
    public $ui = 'grid';

    /** @var string Template file */
    public $defaultTemplate = 'grid-layout.html';

    /** @var string CSS class for columns view */
    public $column_class = '';

    /**
     * Initialization.
     */
    protected function init(): void
    {
        parent::init();

        $this->template->set('column_class', $this->column_class);

        // extract template parts
        $this->t_wrap = clone $this->template;
        $this->t_row = $this->template->cloneRegion('row');
        $this->t_col = $this->template->cloneRegion('column');

        // clean them
        $this->t_row->del('column');
        $this->t_wrap->del('rows');

        // Will need to manipulate template a little
        $this->buildTemplate();
    }

    /**
     * Build and set view template.
     */
    protected function buildTemplate()
    {
        $this->t_wrap->del('rows');
        $this->t_wrap->dangerouslyAppendHtml('rows', '{rows}');

        for ($row = 1; $row <= $this->rows; ++$row) {
            $this->t_row->del('column');

            for ($col = 1; $col <= $this->columns; ++$col) {
                $this->t_col->set('Content', '{$r' . $row . 'c' . $col . '}');

                $this->t_row->dangerouslyAppendHtml('column', $this->t_col->renderToHtml());
            }

            $this->t_wrap->dangerouslyAppendHtml('rows', $this->t_row->renderToHtml());
        }
        $this->t_wrap->dangerouslyAppendHtml('rows', '{/rows}');
        $tmp = new HtmlTemplate($this->t_wrap->renderToHtml());

        // TODO replace later, the only use of direct template property access
        $t = $this;
        \Closure::bind(function () use ($t, $tmp) {
            $t->template->template['rows#0'] = $tmp->template['rows#0'];
            $t->template->rebuildTagsIndex();
        }, null, HtmlTemplate::class)();

        $this->addClass($this->words[$this->columns] . ' column');
    }
}

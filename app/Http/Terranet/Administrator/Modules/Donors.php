<?php

namespace App\Http\Terranet\Administrator\Modules;

use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Resource;
use Terranet\Administrator\Traits\Module\AllowFormats;
use Terranet\Administrator\Traits\Module\HasFilters;
use Terranet\Administrator\Traits\Module\HasForm;
use Terranet\Administrator\Traits\Module\HasSortable;
use Terranet\Administrator\Traits\Module\ValidatesForm;

/**
 * Administrator Resource Donor
 *
 * @package Terranet\Administrator
 */
class Donors extends Resource implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = \App\Models\Donor::class;
    public function title()
    {
        return trans("administrator::module.resources.donors");
    }

    public function group()
    {
        return trans('administrator::module.groups.donors');
    }

    public function linkAttributes()
    {
        return ['icon' => 'fa fa-handshake-o'];
    }
}
<?php

namespace App\Http\Terranet\Administrator\Modules;

use App\User;
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
 * Administrator Users Module
 *
 * @package Terranet\Administrator
 */
class Campaigns extends Resource implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = \App\Models\Campaign::class;

    public function title()
    {
        return trans("administrator::module.resources.campaigns");
    }

    public function group()
    {
        return trans('administrator::module.groups.campaigns');
    }

    public function linkAttributes()
    {
        return ['icon' => 'fa fa-dot-circle-o'];
    }
}

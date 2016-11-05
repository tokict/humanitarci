<?php

namespace Terranet\Administrator\Contracts\Services;

interface Actions
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param string $method
     * @param $eloquent
     *
     * @return bool
     */
    public function authorize($method, $eloquent = null);
}

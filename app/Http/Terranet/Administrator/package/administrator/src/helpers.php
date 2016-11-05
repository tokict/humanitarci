<?php

namespace {
    if (!function_exists('db_connection')) {
        /**
         * Check if we are on desired connection or get the current connection name
         *
         * @param string $name
         * @return mixed string|boolean
         */
        function db_connection($name = null)
        {
            if (null === $name) {
                return DB::connection()->getName();
            }

            return (strtolower($name) == strtolower(DB::connection()->getName()));
        }
    }

    if (!function_exists('array_build')) {

        /**
         * Build a new array using a callback (Rriginal method was deprecetad since version 5.2).
         *
         * @param array $array
         * @param callable $callback
         * @return array
         */
        function array_build($array, callable $callback)
        {
            $results = [];

            foreach ($array as $key => $value) {
                list($innerKey, $innerValue) = call_user_func($callback, $key, $value);

                $results[$innerKey] = $innerValue;
            }

            return $results;
        }
    }

    if (!function_exists('guarded_auth')) {
        /**
         * Since version 5.2 Laravel did change the auth model.
         * Check if we on the new version.
         *
         * @return bool
         */
        function guarded_auth()
        {
            return version_compare(app()->version(), '5.2') >= 0;
        }
    }
}

namespace admin\helpers {

    use Coduo\PHPHumanizer\StringHumanizer;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Route;
    use Terranet\Administrator\Contracts\Form\HiddenElement;
    use Terranet\Administrator\Contracts\Module\Exportable;

    if (!function_exists('qsRoute')) {
        /**
         * Generate route with query string.
         *
         * @param       $route
         * @param array $params
         * @return string
         */
        function qsRoute($route = null, array $params = [])
        {
            $requestParams = Request::all();

            if (!$route) {
                $current = Route::current();
                $requestParams += $current->parameters();
                $route = $current->getName();
            }

            $params = array_merge($requestParams, $params);

            return route($route, $params);
        }
    }

    if (!function_exists('html_attributes')) {
        function html_attributes(array $attributes = [])
        {
            $out = [];
            foreach ($attributes as $key => $value) {
                // transform
                if (is_bool($value)) {
                    $out[] = "{$key}=\"{$key}\"";
                } else {
                    if (is_numeric($key)) {
                        $out[] = "{$value}=\"{$value}\"";
                    } else {
                        $value = htmlspecialchars($value);
                        $out[] = "{$key}=\"{$value}\"";
                    }
                }
            }

            return implode(' ', $out);
        }
    };

    if (!function_exists('auto_p')) {
        function auto_p($value, $lineBreaks = true)
        {
            if (trim($value) === '') {
                return '';
            }

            $value = $value . "\n"; // just to make things a little easier, pad the end
            $value = preg_replace('|<br />\s*<br />|', "\n\n", $value);

            // Space things out a little
            $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
            $value = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $value);
            $value = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $value);
            $value = str_replace(["\r\n", "\r"], "\n", $value); // cross-platform newlines

            if (strpos($value, '<object') !== false) {
                $value = preg_replace('|\s*<param([^>]*)>\s*|', '<param$1>', $value); // no pee inside object/embed
                $value = preg_replace('|\s*</embed>\s*|', '</embed>', $value);
            }

            $value = preg_replace("/\n\n+/", "\n\n", $value); // take care of duplicates

            // make paragraphs, including one at the end
            $values = preg_split('/\n\s*\n/', $value, -1, PREG_SPLIT_NO_EMPTY);
            $value = '';

            foreach ($values as $tinkle) {
                $value .= '<p>' . trim($tinkle, "\n") . "</p>\n";
            }

            // under certain strange conditions it could create a P of entirely whitespace
            $value = preg_replace('|<p>\s*</p>|', '', $value);
            $value = preg_replace('!<p>([^<]+)</(div|address|form)>!', '<p>$1</p></$2>', $value);
            $value = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $value); // don't pee all over a tag
            $value = preg_replace('|<p>(<li.+?)</p>|', '$1', $value); // problem with nested lists
            $value = preg_replace('|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $value);
            $value = str_replace('</blockquote></p>', '</p></blockquote>', $value);
            $value = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $value);
            $value = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $value);

            if ($lineBreaks) {
                $value = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '\admin\helpers\autop_newline_preservation_helper', $value);
                $value = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $value); // optionally make line breaks
                $value = str_replace('<WPPreserveNewline />', "\n", $value);
            }

            $value = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $value);
            $value = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $value);

            if (strpos($value, '<pre') !== false) {
                $value = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', '\admin\helpers\clean_pre', $value);
            }
            $value = preg_replace("|\n</p>$|", '</p>', $value);

            return $value;
        }

        /**
         * Accepts matches array from preg_replace_callback in wpautop() or a string.
         * Ensures that the contents of a <<pre>>...<</pre>> HTML block are not
         * converted into paragraphs or line-breaks.
         *
         * @param array|string $matches The array or string
         * @return string The pre block without paragraph/line-break conversion.
         */
        function clean_pre($matches)
        {
            if (is_array($matches)) {
                $text = $matches[1] . $matches[2] . '</pre>';
            } else {
                $text = $matches;
            }

            $text = str_replace(['<br />', '<br/>', '<br>'], ['', '', ''], $text);
            $text = str_replace('<p>', "\n", $text);
            $text = str_replace('</p>', '', $text);

            return $text;
        }

        /**
         * Newline preservation help function for wpautop.
         *
         * @since  3.1.0
         * @param array $matches preg_replace_callback matches array
         * @returns string
         */
        function autop_newline_preservation_helper($matches)
        {
            return str_replace("\n", '<PreserveNewline />', $matches[0]);
        }
    }

    if (!function_exists('hidden_element')) {
        function hidden_element($element)
        {
            return $element instanceof HiddenElement;
        }
    }

    if (!function_exists('exportable')) {
        function exportable($module)
        {
            return $module instanceof Exportable;
        }
    }

    if (!function_exists('eloquent_attributes')) {
        function eloquent_attributes($model)
        {
            $fillable = $model->getFillable();
            if (!empty($key = $model->getKeyName())) {
                array_unshift($fillable, $key);
            }

            $fillable = array_merge($fillable, $model->getDates());

            return array_only($model->toArray(), $fillable);
        }
    }

    if (!function_exists('eloquent_attribute')) {
        function eloquent_attribute($object, $key)
        {
            $presentMethod = 'present' . studly_case($key);

            if (method_exists($object, $presentMethod)) {
                return call_user_func([$object, $presentMethod]);
            }

            return $object->getAttribute($key);
        }
    }

    if (!function_exists('str_humanize')) {
        function str_humanize($key)
        {
            return StringHumanizer::humanize($key);
        }
    }
}

namespace admin\column {

    function element($title = '', $standalone = false, $output = null)
    {
        return compact('title', 'standalone', 'output');
    }

    function group($label = '', array $elements = [])
    {
        $group = [];

        foreach ($elements as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                $group[$value] = element($value);
            } else {
                $group[$key] = call_user_func_array('\\admin\\column\\element', $value);
            }
        }

        return [
            'label' => $label,
            'elements' => $group,
        ];
    }
}

namespace admin\output {

    use Closure;

    function label_case($key, $upper = false)
    {
        $key = str_replace('_', ' ', preg_replace('~_id$~si', '', $key));

        return $upper ? mb_strtoupper($key) : title_case($key);
    }

    function boolean($value)
    {
        return $value ? '<i class="fa fa-fw fa-check"></i>' : '';
    }

    function email($value)
    {
        return '<a href="mailto:' . $value . '">' . $value . '</a>';
    }

    function rank($name = 'rank', $value = 1, $key)
    {
        return '<input type="number" style="width: 50px;" value="' . $value . '" name="' . $name . '[' . $key . ']" />';
    }

    /**
     * @param       $image
     * @param array $attributes
     * @return string
     */
    function image($image, array $attributes = [])
    {
        $attributes = \admin\helpers\html_attributes($attributes);

        return $image ? '<img src="' . $image . '" ' . $attributes . ' />' : '';
    }

    /**
     * Output image from Stapler attachment object
     *
     * @param null $attachment
     * @param null $style
     * @param array $attributes
     * @return null|string
     */
    function staplerImage($attachment = null, $style = null, $attributes = [])
    {
        if ($attachment && $attachment->originalFilename()) {
            if (count($styles = $attachment->getConfig()->styles)) {
                if (count($styles) > 2) {
                    $styles = array_filter($styles, function ($style) {
                        return $style->name !== 'original';
                    });
                }
                $firstStyle = $style ?: head($styles)->name;
                $origStyle = last($styles)->name;

                return
                    '<a class="fancybox" href="' . url($attachment->url($origStyle)) . '">' .
                    \admin\output\image($attachment->url($firstStyle), $attributes) .
                    '</a>';
            }

            return link_to($attachment->url(), basename($attachment->url()));
        }

        return null;
    }

    function _prepare_collection($items, Closure $callback = null)
    {
        if (is_object($items) && method_exists($items, 'toArray')) {
            $items = $items->toArray();
        }

        if (empty($items)) {
            return '';
        }

        if ($callback) {
            array_walk($items, $callback);
        }

        return $items;
    }

    /**
     * @param array $items
     * @param Closure|null $callback
     * @param array $attributes
     * @return string
     */
    function ul($items = [], Closure $callback = null, array $attributes = [])
    {
        $items = _prepare_collection($items, $callback);

        return '<ul ' . \admin\helpers\html_attributes($attributes) . '>' . '<li>' . implode('</li><li>', $items) . '</li>' . '</ul>';
    }

    /**
     * @param array $items
     * @param Closure|null $callback
     * @param array $attributes
     * @return string
     */
    function ol($items = [], Closure $callback = null, array $attributes = [])
    {
        $items = _prepare_collection($items, $callback);

        return '<ol ' . \admin\helpers\html_attributes($attributes) . '>' . '<li>' . implode('</li><li>', $items) . '</li>' . '</ol>';
    }

    function label($label = '', $class = 'bg-green')
    {
        return '<span class="label ' . $class . '">' . $label . '</span>';
    }

    function badge($label = '', $class = 'bg-green')
    {
        return '<span class="badge ' . $class . '">' . $label . '</span>';
    }
}

namespace admin\filter {

    use Closure;

    function text($label = '', Closure $query = null)
    {
        return [
            'type' => 'text',
            'label' => $label,
            'query' => $query,
        ];
    }

    /**
     * Generate DateRange filter config.
     *
     * @param string $label
     * @param mixed array|callable $options
     * @param callable|Closure $query
     * @return array
     */
    function select($label = '', $options = [], Closure $query = null)
    {
        if (!(is_array($options) || is_callable($options))) {
            trigger_error('Currently only Array or Closure can be provided as $options list', E_USER_ERROR);
        }

        return [
            'type' => 'select',
            'label' => $label,
            'options' => $options,
            'query' => $query,
        ];
    }

    /**
     * Generate DateRange filter config.
     *
     * @param string $label
     * @param callable|Closure $query
     * @return array
     */
    function daterange($label = '', Closure $query = null)
    {
        return [
            'label' => $label,
            'type' => 'daterange',
            'query' => $query,
        ];
    }

    /**
     * Generate Date filter config.
     *
     * @param string $label
     * @param callable|Closure $query
     * @return array
     */
    function date($label = '', Closure $query = null)
    {
        return [
            'label' => $label,
            'type' => 'date',
            'query' => $query,
        ];
    }
}

namespace admin\form {

    function _input($type = 'text', $label = '', array $attributes = [])
    {
        $attributes = [
                'type' => $type,
                'label' => $label,
            ] + $attributes;

        return $attributes;
    }

    function key($label = '')
    {
        return _input('key', $label, []);
    }

    function text($label = '', array $attributes = [])
    {
        return _input('text', $label, $attributes);
    }

    function textarea($label = '', array $attributes = [])
    {
        return _input('textarea', $label, $attributes);
    }

    function tinymce($label = '', array $attributes = [])
    {
        return _input('tinymce', $label, $attributes);
    }

    function ckeditor($label = '', array $attributes = [])
    {
        return _input('ckeditor', $label, $attributes);
    }

    function tel($label = '', array $attributes = [])
    {
        return _input('tel', $label, $attributes);
    }

    function email($label = '', array $attributes = [])
    {
        return _input('email', $label, $attributes);
    }

    function number($label = '', array $attributes = [])
    {
        return _input('number', $label, $attributes);
    }

    /**
     * Generate Select input.
     *
     * @param string $label
     * @param array|callable|string $options - string options should have relation format: table.field
     * @param bool $multiple
     * @param array $attributes
     * @return array
     */
    function select($label = '', $options = [], $multiple = false, array $attributes = [])
    {
        $default = [
            'type' => 'select',
            'label' => $label,
            'options' => $options,
        ];

        if ($multiple) {
            $default['multiple'] = 'multiple';
        }

        return $default + $attributes;
    }

    /**
     * Build boolean [checkbox] input.
     *
     * @param string $label
     * @param array $attributes
     * @return array
     */
    function boolean($label = '', array $attributes = [])
    {
        return _input('boolean', $label, $attributes);
    }

    /**
     * Build date field.
     *
     * @param string $label
     * @param array $attributes
     * @return array
     */
    function date($label = '', array $attributes = [])
    {
        return _input('date', $label, $attributes);
    }

    /**
     * Build file input.
     *
     * @param string $label
     * @param array $attributes
     * @return array
     */
    function file($label = '', array $attributes = [])
    {
        return _input('file', $label, $attributes);
    }

    /**
     * Build image input.
     *
     * @param string $label
     * @param array $attributes
     * @return array
     */
    function image($label = '', array $attributes = [])
    {
        return file($label, $attributes);
    }

    /**
     * Set field description [optional].
     *
     * @param string $description
     * @return array
     */
    function description($description = '')
    {
        return ['description' => $description];
    }

    /**
     * Make field translatable.
     *
     * @return array
     */
    function translation()
    {
        return ['translatable' => true];
    }

    /**
     * Set relation to field.
     *
     * @Text   uses relation to fetch value from related table,
     * @example: users && user_detail.phone [user_detail.user_id => users.id]
     * @param $relation
     * @return array
     */
    function relation($relation)
    {
        if (!is_string($relation)) {
            trigger_error('Relation should be string of format table.field');
        }

        return ['relation' => $relation];
    }
}

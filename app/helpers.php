<?php

if (
    !function_exists('isActive')
) {

    function isActive($path)
    {
        return request()->is($path) ? 'active' : '';
    }
}

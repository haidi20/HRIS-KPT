<?php

function isActive($path)
{
    return request()->is($path) ? 'active' : '';
}

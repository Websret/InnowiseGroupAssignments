<?php

namespace Application\Models;

interface RequestValidation
{
    public function isEmptyArray(array $array): array;
}
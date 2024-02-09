<?php

namespace app\api\modules\v1\components\offers;

interface FieldsInterface
{
    public function protectedFields(): array;
    public function aliases(): array;
    public function processors(string $key): callable;
}

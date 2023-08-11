<?php

declare(strict_types=1);

namespace App\Utils\Query\Sorts;

class SortsHelper
{
    public static function getAttributesWithOrder(array $sorts): array
    {
        $attributesWithOrder = [];

        foreach ($sorts as $attribute) {
            foreach (['asc', 'desc'] as $order) {
                $attributesWithOrder[] = $attribute . '|' . $order;
            }
        }

        return $attributesWithOrder;
    }
}
<?php

namespace App\DataTables;

use Illuminate\Support\Collection;

class Pair extends Collection
{
    public static function options($collection): array
    {
        return (new static($collection))->toArray();
    }

    public function toArray()
    {
        $options = [];
        $this->each(function ($key, $value) use (&$options) {
            $options[] = [
                'label' => $value,
                'value' => $key,
                'total' => 0,
                'count' => 0,
            ];
        });

        return $options;
    }
}

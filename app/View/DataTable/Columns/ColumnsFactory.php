<?php

declare(strict_types=1);

namespace App\View\DataTable\Columns;

use Illuminate\Http\Request;

class ColumnsFactory
{
    public function __construct(
        private Request $request,
        public ColumnsHelper $columnsHelper,
        public ColumnsService $columnsService
    ) {
    }

    public function makeColumns(string $namespace): Columns
    {
        $value = [];

        $alias = $this->columnsHelper->getAlias($namespace);

        if ($this->columnsHelper->doesUserHaveColumns($alias)) {
            $value = json_decode(
                $this->request->cookie($alias),
                flags: JSON_OBJECT_AS_ARRAY
            );
        }

        return new Columns($value);
    }
}

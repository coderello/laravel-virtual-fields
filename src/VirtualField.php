<?php

namespace Coderello\VirtualFields;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use LogicException;

abstract class VirtualField
{
    abstract public function getVirtualValue();

    final public function getVirtualExpression(): Expression
    {
        $virtualValue = $this->getVirtualValue();

        if ($virtualValue instanceof Expression) {
            return DB::raw('('.$virtualValue->getValue().')');
        }

        if ($virtualValue instanceof EloquentBuilder || $virtualValue instanceof QueryBuilder) {
            if ($virtualValue->getBindings()) {
                throw new LogicException(
                    sprintf(
                        '[%s] should not contain prepared statements.',
                        get_class($this)
                    )
                );
            }

            return DB::raw('('.$virtualValue->toSql().')');
        }

        throw new LogicException('This virtual value type is not supported.');
    }

    public function getCast(): ?string
    {
        return null;
    }
}

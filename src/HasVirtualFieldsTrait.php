<?php

namespace Coderello\VirtualFields;

use LogicException;
use Illuminate\Database\Eloquent\Builder;

trait HasVirtualFieldsTrait
{
    public function initializeHasVirtualFieldsTrait()
    {
        foreach ($this->getProcessedVirtualFields() as $virtualFieldName => $virtualField) {
            if ($cast = $virtualField->getCast()) {
                $this->casts[$virtualFieldName] = $cast;
            }
        }
    }

    public function newModelQuery()
    {
        $query = parent::newModelQuery();

        $this->attachVirtualFieldsToQuery($query);

        return $query;
    }

    public function attachVirtualFieldsToQuery(Builder $query): void
    {
        $query->select();

        foreach ($this->getProcessedVirtualFields() as $virtualFieldName => $virtualField) {
            $query->selectSub(
                $virtualField->getVirtualExpression()->getValue(),
                $virtualFieldName
            );
        }
    }

    /**
     * @return array|VirtualField[]
     */
    public function getProcessedVirtualFields(): array
    {
        if (! method_exists($this, 'virtualFields')) {
            return [];
        }

        $virtualFields = $this->virtualFields();

        foreach ($virtualFields as $virtualFieldName => $virtualField) {
            if (! is_object($virtualField)) {
                throw new LogicException(
                    sprintf(
                        '[%s::virtualFields()] method should return an array of [%s] objects.',
                        get_class($this),
                        VirtualField::class
                    )
                );
            }

            if (! $virtualField instanceof VirtualField) {
                throw new LogicException(
                    sprintf(
                        '[%s] should extend [%s].',
                        get_class($virtualField),
                        VirtualField::class
                    )
                );
            }
        }

        return $virtualFields;
    }
}

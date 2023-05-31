<?php

namespace App\Services\Generals\Abstracts;

use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Generals\Constants\QueryFilter;
use App\Services\Generals\Abstracts\AbstractRecord;

abstract class AbstractCollectionRecord extends AbstractRecord
{
    /**
     * @param Request filters
     * @return Response
     * @throws ErrorException
     */
    abstract public function handler(?Request $filters = null);

    /**
     * @param array|Request filters
     * @throws ErrorException
     */
    public function execute($filters = null)
    {
        try {
            if ($filters && is_array($filters)) {
                $filters = new Request($filters);
            }
            return $this->handler($this->_deserializeFilterOptions($filters));
        } catch (ErrorException $exception) {
            throw new ErrorException('Unable to show the record due to unexpected error');
        }
    }

    /**
     * @param Builder $query
     * @param Request filters
     * @return Countable|Array
     * @throws ErrorException
     */
    public function collectionRecord(Builder $query, ?Request $filters = null)
    {
        $query = $this->_deserializeFilters($query, $filters);

        if ($filters->has('all')) {
            // dd($query->toSql(), $query->getBindings());
            return $query->get();
        } else if ($filters->has('first')) {
            return $query->first();
        } else if ($filters->has('sum')) {
            return $query->sum($filters->sum);
        } else {
            // dd($query->toSql());
            if ($filters->has('count') || $filters->has('exists')) {
                if ($filters->has('count')) {
                    return $query->count();
                } else {
                    return $query->exists();
                }
            } else {
                if ($filters->has('paginate')) {
                    if ($filters->paginate == 'all') {
                        return $query->paginate($query->count());
                    } else {
                        return $query->paginate($filters->paginate);
                    }
                } else {
                    return $query->paginate(QueryFilter::DEFAULT_PAGINATION);
                }
            }
        }
    }
}

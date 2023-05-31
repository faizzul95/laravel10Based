<?php

namespace App\Services\Generals\Abstracts;

use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Generals\Abstracts\AbstractRecord;

abstract class AbstractShowRecord extends AbstractRecord
{
    /**
     * @param Request filters
     * @return Model
     * @throws ErrorException
     */
    abstract public function handler(?Request $filters = null);

    /**
     * @param array|Request filters
     * @return Model
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
     * @param Request request
     * @return Model
     * @throws ErrorException
     */
    public function showRecord(Builder $query, ?Request $filters = null)
    {
        $query = $this->_deserializeFilters($query, $filters);
        
        return $query->first();
    }
}

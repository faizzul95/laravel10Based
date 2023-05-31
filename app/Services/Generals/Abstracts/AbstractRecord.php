<?php

namespace App\Services\Generals\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Generals\Constants\QueryFilter;

abstract class AbstractRecord
{
    protected $blacklistColumn = [];

    /**
     * @param Builder $query
     * @param Request filters
     * @return Builder
     */
    protected function _deserializeFilters(Builder $query, ?Request $filters = null)
    {
        if ($filters) {
            if ($filters->has('exclude_ids')) {
                $query->whereNotIn('id', $filters->exclude_ids);
            }

            if ($filters->has('with')) {
                $query->with($filters->with);
            }

            if ($filters->has('groupBy')) {
                if (is_array($filters->groupBy)) {
                    foreach ($filters->groupBy as $column) {
                        $query->groupBy($column);
                    }
                } else {
                    $query->groupBy($filters->groupBy);
                }
            }

            if ($filters->has('orderBy')) {
                foreach ($filters->orderBy as $column => $order_type) {
                    $query->orderBy($column, $order_type);
                }
            }

            if ($filters->has('conditions')) {
                if (!empty($filters->conditions)) {
                    foreach ($filters->conditions as $column => $data) {
                        $condition = strtoupper($this->_extractCondition($data));
                        $value = $this->_extractValue($data);

                        if ($this->_isNotBlacklistColumn($column)) {
                            if (in_array($condition, QueryFilter::IN_CONDITIONS)) {
                                $query->{QueryFilter::CONDITION_FUNCTIONS[$condition]}($column, $value);
                            } else {
                                $query->where($column, $condition, $value);
                            }
                        }
                    }
                }
            }
        }

        return $query;
    }

    /**
     * @param Request filters
     * @return Request
     */
    protected function _deserializeFilterOptions(?Request $filters = null)
    {
        if ($filters->has('options')) {
            foreach ($filters->options as $key => $value) {
                $filters->merge([$key => $value]);
            }
        }

        return $filters;
    }

    protected function _searchInArray($searchQuery, $arrayToFilter, $arrayToSearch, $filter_by_key_or_value = null, $multidimensional_index = null)
    {
        $searchItems = is_array($arrayToFilter) ? $arrayToFilter[1] : [$arrayToFilter];

        return $this->_filterArrayBySearchQuery($this->_filterArray($arrayToSearch, $searchItems, $filter_by_key_or_value), $searchQuery, $multidimensional_index);
    }

    private function _filterArray($arrayToSearch, $searchItems, $filter_by_key_or_value)
    {
        return array_filter($arrayToSearch, function ($array) use ($searchItems) {
            return in_array($array, $searchItems);
        }, $filter_by_key_or_value == 'key' ? ARRAY_FILTER_USE_KEY : null);
    }

    private function _filterArrayBySearchQuery($filteredArray, $searchQuery, $multidimensional_index)
    {
        return array_filter($filteredArray, function ($item) use ($searchQuery, $multidimensional_index) {
            if (stripos($multidimensional_index ? $item[$multidimensional_index] : $item, $searchQuery) !== false) {
                return true;
            }
            return false;
        });
    }

    private function _extractCondition($data)
    {
        return is_array($data) ? (isset($data[0]) ? $data[0] : '=') : '=';
    }

    private function _extractValue($data)
    {
        return is_array($data) ? (isset($data[1]) ? $data[1] : []) : $data;
    }

    private function _isNotBlacklistColumn($column)
    {
        return !in_array($column, $this->blacklistColumn);
    }
}

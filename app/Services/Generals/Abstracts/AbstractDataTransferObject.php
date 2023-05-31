<?php

namespace App\Services\Generals\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractDataTransferObject
{
    public $requestDatas;

    /**
     * @return Model
     */
    abstract protected function model(): Model;

    public function __construct($request)
    {
        $this->requestDatas = is_array($request) ? new Request($request) : $request;

        foreach ($this as $key => $value) {
            if (isset($this->requestDatas->{$key})) {
                $this->{$key} = $this->requestDatas->{$key};
            }
        }

        $this->_setColumnValueFromSession();
    }

    /**
     * @return Array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            if ($value === NULL) {
                if($this->requestDatas->exists($key)){
                    $array[$key] = $value;
                }
            }else{
                $array[$key] = $value;
            }
        }

        return $array;
    }


    /**
     * @return Model
     */
    public function toModel(): Model
    {
        $model = $this->model();
        return $model->fill($this->toArray());
    }


    protected function _setColumnValueFromSession(){
        if(property_exists($this, 'user_id')){
            $this->user_id = $this->user_id ? $this->user_id : ($this->requestDatas->user() ? $this->requestDatas->user()->id : null);
        }

        if(property_exists($this, 'school_user_id')){
            $this->school_user_id = $this->school_user_id ? $this->school_user_id : ($this->requestDatas->user() ? $this->requestDatas->user()->currentSchoolUserId() : null);
        }

        if(property_exists($this, 'school_id')){
            $this->school_id = $this->school_id ? $this->school_id : ($this->requestDatas->user() ? $this->requestDatas->user()->currentSchoolId() : null);
        }
    }
}

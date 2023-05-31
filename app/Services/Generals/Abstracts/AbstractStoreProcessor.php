<?php

namespace App\Services\Generals\Abstracts;

use Illuminate\Database\Eloquent\Model;
use App\Services\Generals\Abstracts\AbstractDataTransferObject;

abstract class AbstractStoreProcessor
{
    public $id;

    public $model;

    /**
     * @return Model
     */
    abstract protected function model() : Model;

    /**
     * @return Model
     */
    public function execute(AbstractDataTransferObject $abstractDataTransferObject): Model
    {
        return $this->_setModel($abstractDataTransferObject->id)
                ->_updateOrCreate($abstractDataTransferObject)
                ->_setModel($this->id)
                ->_getModel();
    }

    /**
     * @param int $id
     * @return AbstractStoreProcessor
     */
    private function _setModel(int $id = null)
    {
        if($id){
            $this->model = $this->model()->find($id);
        }else{
            $this->model = null;
        }

        return $this;
    }

    /**
     * @return Model
     */
    private function _getModel(): Model{
        return $this->model;
    }

    /**
     * @return AbstractStoreProcessor
     */
    private function _setId()
    {
        $this->id = $this->model->id;
        
        return $this;
    }

    /**
     * @param AbstractDataTransferObject $abstractDataTransferObject
     * @return AbstractStoreProcessor
     */
    private function _updateOrCreate(AbstractDataTransferObject $abstractDataTransferObject)
    {
        if($this->model){
            $this->model->update($abstractDataTransferObject->toArray());
        } else {
            $this->model = $this->model()->create($abstractDataTransferObject->toArray());
        }

        $this->_setId();
        
        return $this;
    }
}
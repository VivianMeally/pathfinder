<?php
/**
 * Created by PhpStorm.
 * User: exodu
 * Date: 14.10.2017
 * Time: 15:56
 */

namespace Model\Universe;


use DB\SQL\Schema;

class TypeModel extends BasicUniverseModel {

    protected $table = 'type';

    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
            'default' => ''
        ],
        'description' => [
            'type' => Schema::DT_TEXT
        ],
        'published' => [
            'type' => Schema::DT_BOOL,
            'nullable' => false,
            'default' => 1,
            'index' => true
        ],
        'radius' => [
            'type' => Schema::DT_FLOAT,
            'nullable' => false,
            'default' => 0
        ],
        'volume' => [
            'type' => Schema::DT_FLOAT,
            'nullable' => false,
            'default' => 0
        ],
        'capacity' => [
            'type' => Schema::DT_FLOAT,
            'nullable' => false,
            'default' => 0
        ],
        'mass' => [
            'type' => Schema::DT_FLOAT,
            'nullable' => false,
            'default' => 0
        ],
        'groupId' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => 0,
            'index' => true
        ],
        'marketGroupId' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => 0,
            'index' => true
        ],
        'packagedVolume' => [
            'type' => Schema::DT_FLOAT,
            'nullable' => false,
            'default' => 0
        ],
        'portionSize' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => 0
        ],
        'graphicId' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => 0,
            'index' => true
        ],
        'structures' => [
            'has-many' => ['Model\Universe\StructureModel', 'typeId']
        ]
    ];

    /**
     * get shipData from object
     * -> more fields can be added in here if needed
     * @return \stdClass
     */
    public function getShipData(): \stdClass {
        $shipData = (object) [];
        if(!$this->dry()){
            $shipData->typeId = $this->_id;
            $shipData->typeName = $this->name;
            $shipData->mass = $this->mass;
        }
        return $shipData;
    }

    /**
     * load data from API into $this and save $this
     * @param int $id
     * @param string $accessToken
     * @param array $additionalOptions
     */
    protected function loadData(int $id, string $accessToken = '', array $additionalOptions = []){
        $data = self::getF3()->ccpClient->getUniverseTypesData($id, $additionalOptions);
        if(!empty($data)){
            $this->copyfrom($data);
            $this->save();
        }
    }
}
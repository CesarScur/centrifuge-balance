<?php
/**
 * Created by PhpStorm.
 * User: Cesar
 * Date: 18/09/2016
 * Time: 01:30
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Falcon;

class Centrifuge implements \Iterator, \Serializable
{

    private $falcon_collection_index = 1;
    private $falcon_collection = array();
    private $position_order = array(
        19,
        25,
        24,
        30,
        26,
        20,
        28,
        22,
        21,
        27,
        23,
        29,
        10,
        1,
        16,
        7,
        4,
        13,
        8,
        17,
        14,
        5,
        2,
        11,
        18,
        9,
        12,
        3,
        15,
        6
    );

    public function set(Falcon $falcon)
    {
        $number = $falcon->getNumber();
        $this->falcon_collection[$number] = $falcon;
        $this->balance();
        return $this;
    }

    public function balance()
    {
        $weightArray = $this->getWeightArray();
        arsort($weightArray);

        $position = reset($this->position_order);
        foreach ($weightArray as $number => $weight) {
            $this->falcon_collection[$number]->setPosition($position);
            $position = next($this->position_order);
        }

        return $this;
    }

    function rewind() {
        reset($this->position_order);
        $this->falcon_collection_index = current($this->position_order);
    }

    function current() {
        foreach($this->falcon_collection as $falcon) {
            if($falcon->getPosition() == $this->falcon_collection_index)
                $number = $falcon->getNumber();
        }
        return $this->falcon_collection[$number];
    }

    function key() {
        return $this->falcon_collection_index;
    }

    function next() {
        next($this->position_order);
        $this->falcon_collection_index =  current($this->position_order);
    }

    function valid() {
        foreach($this->falcon_collection as $falcon) {
            if($falcon->getPosition() == $this->falcon_collection_index)
                $number = $falcon->getNumber();
        }
        return isset($number);
    }


    public function serialize()
    {
        return serialize($this->falcon_collection);
    }

    public function unserialize($serialized)
    {
        $this->falcon_collection_index = 1;
        $this->falcon_collection = unserialize($serialized);
    }

    public function getWeightArray()
    {
        $array = array();
        foreach ($this->falcon_collection as $falcon) {
            $weight = $falcon->getWeight();
            $number = $falcon->getNumber();
            $array[$number] = $weight;
        }
        return $array;
    }
}
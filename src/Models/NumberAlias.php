<?php
/*
 * FlowrouteNumbersAndMessagingLib
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace FlowrouteNumbersAndMessagingLib\Models;

use JsonSerializable;

/**
 * @todo Write general description for this model
 */
class NumberAlias implements JsonSerializable
{
    /**
     * @todo Write general description for this property
     * @var \FlowrouteNumbersAndMessagingLib\Models\Data27|null $data public property
     */
    public $data;

    /**
     * @todo Write general description for this property
     * @var array|null $included public property
     */
    public $type;

    /**
     * @todo Write general description for this property
     * @var array|null $included public property
     */
    public $alias;

    /**
     * Constructor to set initial or default values of member properties
     * @param Data27 $data     Initialization value for $this->data
     * @param array  $included Initialization value for $this->included
     */
    public function __construct()
    {
    }


    /**
     * Encode this object to JSON
     */
    public function jsonSerialize()
    {
        $json = array();
        $json['type'] = 'number';
        $json['alias'] = $this->alias;

        return $json;
    }
}

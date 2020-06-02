<?php

namespace common\dto;

use common\services\Gender\GenderServiceInterface;
use common\dto\OrderItem;

class Order 
{
    public $name;
    public $phone;
    public $street;
    public $house;
    public $date;
    public $site_id;

    public $gender;

    private $items = [];

    private $genderResolver;

    public function __construct($data, GenderServiceInterface $genderResolver)
    {
        $this->name = mb_convert_case(trim($data['name']), MB_CASE_TITLE, "UTF-8");
        $this->phone = $data['phone'];
        $this->street = trim($data['street']);
        $this->house = trim($data['house']);
        $this->date = $data['date'];
        $this->site_id = $data['id'];

        $this->genderResolver = $genderResolver;

        $this->gender = $this->genderResolver->get($this->name);
    }

    public function getFullAddress(): string
    {
        return 'г. Киров, ' . $this->street . ' ' . $this->house;
    }

    public function addItem(OrderItem $item) 
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
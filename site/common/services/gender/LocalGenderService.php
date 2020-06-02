<?php

namespace common\services\Gender;

use Gender\Gender;
use common\services\gender\GenderServiceInterface;

class LocalGenderService implements GenderServiceInterface
{

    private $country;
    private $resolver;

    private $cache = [];

    public function __construct(string $country)
    {
        $this->country = $country === 'Russia' ? 39 : 3;
        $this->resolver = new Gender();
    }


    public function get(string $name) 
    {

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $new_name = transliterator_transliterate('Russian-Latin/BGN', $name);
        $res = $this->resolver->get($new_name, $this->country);

        $result = $this->defineAnswer($res);

        $this->cache[$name] = $result;

        return $result;
    }

    private function defineAnswer(int $gender_res) 
    {
        switch($gender_res) {
            case Gender::IS_FEMALE:
                return self::FEMALE;            
            case Gender::IS_MOSTLY_FEMALE:
                return self::FEMALE;
            case Gender::IS_MALE:
                return self::MALE;
            case Gender::IS_MOSTLY_MALE:
                return self::MALE;
            case Gender::IS_UNISEX_NAME:
                return self::UNKNOWN;
            case Gender::IS_A_COUPLE:
                return self::UNKNOWN;
            case Gender::NAME_NOT_FOUND:
                return self::UNKNOWN;
            case Gender::ERROR_IN_NAME:
                return self::UNKNOWN;
            default:
                throw new \Error('Gender result do not recognized');
        
        }
    }
}
<?php

namespace Prokl\BitrixIblockElementValidatorBundle\Services\Sanitizer;

use Prokl\BitrixIblockElementValidatorBundle\Services\Contracts\SanitizerInterface;
use Waavi\Sanitizer\Sanitizer;

/**
 * Class SanitizerMaker
 * @package Prokl\BitrixIblockElementValidatorBundle\Services\Sanitizer
 *
 * @since 07.09.2020
 */
class SanitizerMaker implements SanitizerInterface
{
    /**
     * Создать экземпляр Sanitizer.
     *
     * @param array $arData Данные.
     * @param array $rules  Схема санации.
     *
     * @return Sanitizer
     */
    public function make(array $arData, array $rules): Sanitizer
    {
        return new Sanitizer($arData, $rules);
    }
}

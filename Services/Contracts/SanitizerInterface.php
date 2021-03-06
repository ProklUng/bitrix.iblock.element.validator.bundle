<?php

namespace Prokl\BitrixIblockElementValidatorBundle\Services\Contracts;

use Waavi\Sanitizer\Sanitizer;

/**
 * Interface SanitizerInterface
 * @package Prokl\BitrixIblockElementValidatorBundle\Services\Contracts
 *
 * @since 08.09.2020
 */
interface SanitizerInterface
{
    /**
     * Создать экземпляр Sanitizer.
     *
     * @param array $arData Данные.
     * @param array $rules  Схема санации.
     *
     * @return Sanitizer
     */
    public function make(array $arData, array $rules): Sanitizer;
}

<?php

namespace Prokl\BitrixIblockElementValidatorBundle;

use Prokl\BitrixIblockElementValidatorBundle\DependencyInjection\BitrixIblockElementValidatorBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BitrixIblockElementValidatorBundle
 * @package Prokl\BitrixIblockElementValidatorBundle
 *
 * @since 07.02.2021
 */
final class BitrixIblockElementValidatorBundle extends Bundle
{
   /**
   * @inheritDoc
   */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new BitrixIblockElementValidatorBundleExtension();
        }

        return $this->extension;
    }
}

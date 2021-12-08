<?php declare(strict_types=1);

namespace IiifPreview\Service\ViewHelper;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use IiifPreview\View\Helper\IiifPreview;

/**
 * Service factory for the IiifPreview view helper.
 */
class IiifPreviewFactory implements FactoryInterface
{
    /**
     * Create and return the IiifPreview view helper
     *
     * @return IiifPreview
     */
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new IiifPreview();
    }
}

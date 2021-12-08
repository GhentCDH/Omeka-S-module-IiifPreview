<?php declare(strict_types=1);

namespace IiifPreview\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Omeka\Api\Representation\AbstractResourceEntityRepresentation;
use Omeka\Site\Theme\Theme;

class IiifPreview extends AbstractHelper
{
    protected $viewers = [
        'mirador' => 'mirador',
        'universalviewer' => 'universalViewer'
    ];

    /**
     * Construct the helper.
     */
    public function __construct()
    {
    }

    /**
     * Render the IiifViewer for the provided resource.
     *
     * Proxies to {@link render()}.
     *
     * @param AbstractResourceEntityRepresentation $resource
     * @param array $options
     * @return string Html string corresponding to the viewer.
     */
    public function __invoke(AbstractResourceEntityRepresentation $resource, array $options = []): string
    {
        if (empty($resource)) {
            return '';
        }

        $view = $this->getView();

        // check if IiifServer is active
        $iiifServerIsActive = $view->getHelperPluginManager()->has('iiifUrl');
        if (!$iiifServerIsActive) {
            return '';
        }

        // check resource type
        $resourceName = $resource->resourceName();
        switch ($resourceName) {
            case 'items':
                // Currently, an item without files is unprocessable.
                if (count($resource->media()) == 0) {
                    return '';
                }
                break;
            case 'item_sets':
                if ($resource->itemCount() == 0) {
                    return '';
                }
                break;
            default:
                return '';
                break;
        }

        return $this->render($resource, $options);
    }

    /**
     * Render a iiif viewer a resource
     *
     * @param string $urlManifest
     * @param array $options
     * @param string $resourceName
     * @return string Html code.
     */
    protected function render($resource, array $options = []): string
    {
        $view = $this->view;
        $viewer = $view->setting("iiifpreview_viewer", false);
        $viewerPlugin = $viewer ? $this->viewers[$viewer] ?? false : false;

        return $view->partial('common/helper/iiif-preview', [
            'resource' => $resource,
            'config' => [
                'viewerPlugin' => $viewerPlugin
            ]
        ]);
    }
}

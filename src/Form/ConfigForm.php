<?php declare(strict_types=1);

namespace IiifPreview\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Omeka\Settings\Settings;

class ConfigForm extends Form implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * @var Settings
     */

    public function init()
    {
        $this->setAttribute('id', 'config-form');
        $this->add([
            'name' => 'iiifpreview_viewer',
            'type' => Element\Select::class,
            'options' => [
                'label' => "IIIF Viewer", // @translate
                'value_options' => [
                    'mirador' => 'Mirador',
                    'universalviewer' => 'UniversalViewer',
                    'diva' => 'Diva',
                ]
            ],
            'attributes' => [
                'id' => 'iiifpreview_viewer',
                'required' => false,
            ],
        ]);
    }


    protected function translate($args): string
    {
        $translator = $this->getTranslator();
        return $translator->translate($args);
    }

}
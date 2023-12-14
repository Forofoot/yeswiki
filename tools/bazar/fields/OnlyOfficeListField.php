<?php

namespace YesWiki\Bazar\Field;

use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;

/**
 * @Field({"onlyoffice"})
 */
class OnlyOfficeListField extends EnumField
{
    public function __construct(array $values, ContainerInterface $services)
    {
        parent::__construct($values, $services);

        $this->loadOptionsFromList();
    }

    protected function renderInput($entry)
    {
        $options = [
            'document' => 'Document Type',
            'presentation' => 'Presentation Type',
            'spreadsheet' => 'Spreadsheet Type'
        ];

        return $this->render('@bazar/inputs/onlyoffice.twig', [
            'value' => $this->getValue($entry),
            'options' => $options
        ]);
    }

    protected function renderStatic($entry)
    {
        $value = $this->getValue($entry);

        if( !$value ) return "";
        return $this->render('@bazar/fields/onlyoffice.twig', [
            'urlFinal' => $this->getWiki()->config['onlyoffice_url'] . '?' . $entry['urlFinal']
        ]);
    }

    // Format input values before save
    public function formatValuesBeforeSave($entry)
    {
        //return ['url' => $urlFinal];
        if( $entry['urlFinal'] ) return [];
    
        $client = new Client();
        $value = $this->getValue($entry);
        $ext = '';

        switch ($value) {
            case "document":
                $ext = "?fileExt=docx";
                break;
            case "spreadsheet":
                $ext = "?fileExt=xlsx";
                break;
            case "presentation":
                $ext = "?fileExt=pptx";
                break;
        }

        
        $response = $client->request('GET', $this->getWiki()->config['onlyoffice_url'].$ext, [
            'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$finalUrl) {
                $finalUrl = $stats->getEffectiveUri();
            },
        ]);

        $urlString = (string) $finalUrl;
        $parsedUrl = parse_url($urlString);
        $query = $parsedUrl['query'];
        return ['urlFinal' => $query];
    }
}

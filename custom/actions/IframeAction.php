<?php

use YesWiki\Core\YesWikiAction;
use YesWiki\Core\Service\PageManager;

class IframeAction extends YesWikiAction
{
    public function formatArguments($arg)
    {
        return [
            'document' => $arg['document'] ?? "",
            'height' => $arg['height'] ?? '2000px'
        ];
    }

    public function run()
    {
        $height = $this->arguments['height'];
        $ext = "";
        $client = new GuzzleHttp\Client();

        $finalUrl = '';
        $query = '';

        $pageManager = $this->getService(PageManager::class);

        switch ($this->arguments['document']) {
            case "document":
                $ext = "?fileExt=docx";
                break;
            case "spreadsheet":
                $ext = "?fileExt=xlsx";
                break;
            case "presentation":
                $ext = "?fileExt=pptx";
                break;
            case "form":
                $ext = "?fileExt=docxf";
                break;
        }

        if(empty($this->arguments['url'])){
            $response = $client->request('GET', $this->wiki->config['onlyoffice_url'].$ext, [
                'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$finalUrl) {
                    $finalUrl = $stats->getEffectiveUri();
                },
            ]);

            $urlString = (string) $finalUrl;
            $parsedUrl = parse_url($urlString);
            $query = $parsedUrl['query'];
            $currentPage = $pageManager->getOne($this->wiki->GetPageTag());
            $currentPage['body'] = preg_replace('/(onlyoffice="true")/', '$1 url="'. $this->wiki->config['onlyoffice_url'] . '?' . $query . '"', $currentPage['body']);
            $currentPage = $pageManager->save($this->wiki->GetPageTag(), $currentPage['body'] );
            $this->wiki->Redirect($this->wiki->href(''));
        }

        if (!empty($this->arguments['url'])) {
            return "<iframe src='" . $this->arguments['url'] . "' width='100%' height='" . $height . "px' frameborder='0' allowfullscreen></iframe>";
        }
    }
}

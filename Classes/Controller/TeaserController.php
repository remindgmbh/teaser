<?php

declare(strict_types=1);

namespace Remind\Teaser\Controller;

use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use Remind\Teaser\Domain\Repository\TeaserRepository;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TeaserController extends ActionController
{
    public function __construct(
        private readonly TeaserRepository $teaserRepository,
        private readonly FlexFormService $flexFormService,
    ) {
    }

    public function selectionListAction(): ResponseInterface
    {
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject */
        $contentObject = $this->request->getAttribute('currentContentObject');

        $flexFormContent = $this->flexFormService->convertFlexFormContentToArray(
            $contentObject->data['pi_flexform'] ?? ''
        );

        $recordUids = explode(',', $flexFormContent['records'] ?? '');

        $records = array_map(function ($recordUid) {
            $record = $this->teaserRepository->findByUid((int) $recordUid);
            return $record instanceof JsonSerializable
                ? json_decode(json_encode($record) ?: '', true)
                : null;
        }, $recordUids);

        $json = json_encode(array_filter($records));
        return $this->jsonResponse($json !== false ? $json : null);
    }
}

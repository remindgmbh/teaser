<?php

declare(strict_types=1);

namespace Remind\Teaser\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Headless\Service\FilesService;
use Remind\Teaser\Domain\Model\Teaser;
use Remind\Teaser\Domain\Repository\TeaserRepository;
use TYPO3\CMS\Core\LinkHandling\TypoLinkCodecService;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class TeaserController extends ActionController
{
    protected TypoLinkCodecService $typoLinkCodecService;

    protected ContentObjectRenderer $contentObjectRenderer;

    public function __construct(
        private readonly TeaserRepository $teaserRepository,
        private readonly FlexFormService $flexFormService,
        private readonly FilesService $filesService,
    ) {
        $this->typoLinkCodecService = GeneralUtility::makeInstance(TypoLinkCodecService::class);
        $this->contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
    }

    public function selectionListAction(): ResponseInterface
    {
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject */
        $contentObject = $this->request->getAttribute('currentContentObject');

        $flexFormContent = $this->flexFormService->convertFlexFormContentToArray(
            $contentObject->data['pi_flexform'] ?? ''
        );

        $recordUids = explode(',', $flexFormContent['records'] ?? '');

        $records = array_map(function ($recordUid) use ($contentObject) {
            $record = $this->teaserRepository->findByUid((int) $recordUid);
            $categories = $record?->getCategories()?->toArray();

            $record = $record instanceof Teaser
                ? [
                    'uid' => $record->getUid(),
                    'pid' => $record->getPid(),
                    'title' => $record->getTitle(),
                    'bodytext' => $record->getBodytext(),
                    'link' => $record->getLink(),
                    ...(
                        $record->getImage() ? [
                            'image' => $this->filesService->processImage($record->getImage()->getOriginalResource()),
                        ]
                        : []
                    ),
                ]
                : null;


            if ($record) {
                if ($categories) {
                    $record['categories'] = $this->serializeCategories($categories);
                }
                $record['link'] = is_string($record['link']) ? $this->processTypolinkUrl($record['link']) : '';

                if ($record['bodytext']) {
                    $record['bodytext'] = is_string($record['bodytext'])
                        ? $contentObject->parseFunc($record['bodytext'], null, '< lib.parseFunc_links')
                        : '';
                }
            }

            return $record;
        }, $recordUids);

        $json = json_encode(array_filter($records));
        return $this->jsonResponse($json !== false ? $json : null);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category[] $categories
     * @return array<array<string, mixed>>
     */
    protected function serializeCategories(array $categories): array
    {
        return array_map(function ($category) {
            return [
                'description' => $category->getDescription(),
                'parent' => $category->getParent() ? $category->getParent()->getUid() : null,
                'pid' => $category->getPid(),
                'title' => $category->getTitle(),
                'uid' => $category->getUid(),
            ];
        }, $categories);
    }

    /**
     * @return array<string, string>
     */
    protected function processTypolinkUrl(string $link): array
    {
        $typoLinkConfiguration = $this->typoLinkCodecService->decode($link);
        $typoLinkConfiguration['href'] =
            $this->contentObjectRenderer->createUrl(['parameter' => $typoLinkConfiguration['url']]);

        return $typoLinkConfiguration;
    }
}

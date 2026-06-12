<?php

declare(strict_types=1);

namespace Remind\Teaser\Tests\Unit\Controller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionProperty;
use Remind\Headless\Service\FilesService;
use Remind\Teaser\Controller\TeaserController;
use Remind\Teaser\Domain\Model\Teaser;
use Remind\Teaser\Domain\Repository\TeaserRepository;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Http\StreamFactory;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(TeaserController::class)]
class TeaserControllerTest extends UnitTestCase
{
    private FlexFormService&MockObject $flexFormService;

    private FilesService&MockObject $filesService;

    private TeaserRepository&MockObject $teaserRepository;

    private TeaserController&MockObject $teaserController;

    public function setUp(): void
    {
        parent::setUp();

        $this->filesService = $this->createMock(FilesService::class);
        $this->flexFormService = $this->createMock(FlexFormService::class);
        $this->teaserRepository = $this->createMock(TeaserRepository::class);

        $this->teaserController = $this->getMockBuilder(TeaserController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['processTypolinkUrl'])
            ->getMock();

        $reflection = new ReflectionProperty(TeaserController::class, 'teaserRepository');
        $reflection->setValue($this->teaserController, $this->teaserRepository);

        $reflection = new ReflectionProperty(TeaserController::class, 'flexFormService');
        $reflection->setValue($this->teaserController, $this->flexFormService);

        $reflection = new ReflectionProperty(TeaserController::class, 'filesService');
        $reflection->setValue($this->teaserController, $this->filesService);

        $this->teaserController->injectResponseFactory(new ResponseFactory());
        $this->teaserController->injectStreamFactory(new StreamFactory());
    }

    #[Test]
    public function teaserRecordIsMappedToArray(): void
    {
        $teaser = $this->createTeaserMock(1, 'Record #1 Title');

        $this->teaserRepository
            ->method('findByUid')
            ->with(1)
            ->willReturn($teaser);

        $this->flexFormService
            ->method('convertFlexFormContentToArray')
            ->willReturn(['records' => '1']);

        $this->teaserController
            ->method('processTypolinkUrl')
            ->with('t3://page?uid=100')
            ->willReturn(['url' => 't3://page?uid=100']);

        $contentObject = $this->createMock(ContentObjectRenderer::class);
        $contentObject->data = ['pi_flexform' => ''];
        $contentObject
            ->method('parseFunc')
            ->with('Bodytext', null, '< lib.parseFunc_links')
            ->willReturn('Bodytext');

        $request = $this->createMock(Request::class);
        $request->method('getAttribute')
            ->with('currentContentObject')
            ->willReturn($contentObject);

        $reflection = new ReflectionProperty(ActionController::class, 'request');
        $reflection->setValue($this->teaserController, $request);

        $response = $this->teaserController->selectionListAction();

        $data = json_decode((string) $response->getBody(), true);

        self::assertIsArray($data);
        self::assertCount(1, $data);
        self::assertSame(1, $data[0]['uid']);
        self::assertSame('Record #1 Title', $data[0]['title']);
        self::assertSame('Bodytext', $data[0]['bodytext']);
        self::assertSame('Subtitle', $data[0]['subtitle']);
        self::assertSame(['url' => 't3://page?uid=100'], $data[0]['link']);
    }

    protected function createTeaserMock(int $uid, string $title): Teaser
    {
        $teaser = $this->createMock(Teaser::class);
        $teaser->method('getUid')->willReturn($uid);
        $teaser->method('getPid')->willReturn(10);
        $teaser->method('getTitle')->willReturn($title);
        $teaser->method('getBodytext')->willReturn('Bodytext');
        $teaser->method('getLink')->willReturn('t3://page?uid=100');
        $teaser->method('getSubtitle')->willReturn('Subtitle');
        $teaser->method('getImage')->willReturn(null);
        $teaser->method('getCategories')->willReturn(null);

        return $teaser;
    }
}

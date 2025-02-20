<?php

declare(strict_types=1);

namespace Remind\Teaser\Domain\Model;

use Remind\Extbase\Domain\Model\AbstractJsonSerializableEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Teaser extends AbstractJsonSerializableEntity
{
    protected string $title = '';

    protected string $subtitle = '';

    protected string $bodytext = '';

    protected string $link = '';

    protected ?FileReference $image = null;

    /**  @var ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> */
    protected ?ObjectStorage $categories = null;

    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }

    /**
     * @return ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>|null
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function setCategories(ObjectStorage $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getBodytext(): string
    {
        return $this->bodytext;
    }

    public function setBodytext(string $bodytext): self
    {
        $this->bodytext = $bodytext;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(?FileReference $image): self
    {
        $this->image = $image;

        return $this;
    }
}

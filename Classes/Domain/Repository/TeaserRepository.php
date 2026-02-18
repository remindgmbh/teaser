<?php

declare(strict_types=1);

namespace Remind\Teaser\Domain\Repository;

use Remind\Extbase\Domain\Repository\FilterableRepository;

/**
 * @template-extends FilterableRepository<\Remind\Teaser\Domain\Model\Teaser>
 */
class TeaserRepository extends FilterableRepository
{
}

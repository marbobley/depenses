<?php

namespace App\Twig\Components;

use App\Repository\DepenseRepository;
use DateTimeImmutable;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(name: 'depense_search')]
final class DepenseSearchComponent
{
    use DefaultActionTrait;

    /**
     * Properties marked as LiveProp are stateful properties.
     * This means that each time the component is re-rendered, it will remember the original value of the property
     * and set it to the component object.
     *
     * By default, LiveProp are readonly. Making them writable allow users to change their value.
     *
     * See https://symfony.com/bundles/ux-live-component/current/index.html#liveprops-stateful-component-properties
     */
    #[LiveProp(writable: true)]
    public string $startDate ;

    #[LiveProp(writable: true)]
    public string $endDate ;

    public function __construct(
        private readonly DepenseRepository $depenseRepository,
    ) {
    }

    /**
     * @return array<Depenses>
     */
    public function getDepenses(): array
    {
        return $this->depenseRepository->findByRangeYear($this->startDate, $this->endDate);
    }
}

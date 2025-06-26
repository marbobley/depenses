<?php

namespace App\Twig\Components;

use App\Service\Business\ServiceDepense;
use App\Service\Business\ServiceDepenseFamily;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(name: 'depense_progressbar_page')]
final class DepenseProgressbarPageComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $startDate;

    #[LiveProp(writable: false)]
    public string $type;

    public function __construct(
        private readonly ServiceDepense $serviceDepense,
        private readonly ServiceDepenseFamily $serviceDepenseFamily,
        private Security $security,
    ) {
    }

    public function GetTotal(): float
    {
        $currentMonth = date('n', strtotime($this->startDate));
        $currentYear = date('Y', strtotime($this->startDate));
        $user = $this->security->getUser();

        if ('user' === $this->type) {
            return $this->serviceDepense->GetTotalMonth($user, $currentMonth, $currentYear);
        } else {
            return $this->serviceDepenseFamily->GetDepenseMonth($currentMonth, $currentYear);
        }
    }

    /**
     * @return array<Depenses>
     */
    public function GetDepenses(): array
    {
        $currentMonth = date('n', strtotime($this->startDate));
        $currentYear = date('Y', strtotime($this->startDate));
        $user = $this->security->getUser();

        if ('user' === $this->type) {
            return $this->serviceDepense->GetSumDepenseByCategory($user, $currentMonth, $currentYear);
        } else {
            return $this->serviceDepense->GetFamilySumDepenseByCategory($user, $currentMonth, $currentYear);
        }
    }
}

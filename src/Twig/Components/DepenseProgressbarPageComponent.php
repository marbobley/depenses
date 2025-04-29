<?php

namespace App\Twig\Components;

use App\Repository\DepenseRepository;
use App\Service\Business\ServiceDepense;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function __construct(
        private readonly ServiceDepense $serviceDepense,
        private Security $security,
    ) {
    }

    public function GetTotal() : float{

        $currentMonth = date('n', strtotime($this->startDate));
        $currentYear = date('Y', strtotime($this->startDate));
        $user = $this->security->getUser();
        //depensesByCategory = $depenseService->GetSumDepenseByCategory($this->getUser(),$currentMonth,$currentYear);

        $total = $this->serviceDepense->GetTotalMonth($user,$currentMonth,$currentYear);
        return $total;
    }

    /**
     * @return array<Depenses>
     */
    public function GetDepenses() : array
    {
        $currentMonth = date('n', strtotime($this->startDate));
        $currentYear = date('Y', strtotime($this->startDate));
        $user = $this->security->getUser();
        return $this->serviceDepense->GetSumDepenseByCategory($user,$currentMonth,$currentYear);
    }
}

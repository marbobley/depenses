<?php

namespace App\Service;

use App\Entity\User;

class DepenseService
{
    public function __construct()
    {

    }

    public function GetDepense(?User $user) : float
    {
        // not connected
        if($user === null)
            return 0;

        $depense = $user->getSumAmountMonth();

        return $depense;
    }

    public function GetMonthDepenseGroupByCategory(?User $user)
    {
        // not connected
        if($user === null)
            return [];

        $depenses = $user->getDepenses();     


        return $depenses;
    }
}
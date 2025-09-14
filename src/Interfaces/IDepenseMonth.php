<?php

namespace App\Interfaces;

use App\Entity\User;

interface IDepenseMonth{
    /**
     * to sum on month
     */
    public function GetDepenseMonth(User $user, string $month, string $year) : float;
}
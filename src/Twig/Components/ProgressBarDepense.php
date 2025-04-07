<?php

namespace App\Twig\Components;

use App\Service\DepenseService;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProgressBarDepense
{
    public int $percentage = 25;
}

<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'ProgressBarDepense')]
final class ProgressBarDepense
{
    public int $percentage = 25;
}

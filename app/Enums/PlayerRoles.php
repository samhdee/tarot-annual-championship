<?php

namespace App\Enums;

// use Henzeb\Enumhancer\Concerns\Enhancers;

enum PlayerRoles: string
{
    // use Enhancers;

    case taker = 'Preneur.euse';
    case taker_partner = 'Partenaire';
    case defender = 'Défenseur.euse';
}

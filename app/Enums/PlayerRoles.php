<?php

namespace App\Enums;

enum PlayerRoles: string
{
    case taker = 'Preneur';
    case taker_partner = 'Partenaire';
    case defender = 'Défenseur';
}

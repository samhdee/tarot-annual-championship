@props([
    /** @var \App\Enums\BGABids */
    'role'
])

@switch ($role)
    @case ('taker')
        Preneur.se
        @break

    @case ('taker_partner')
        Partenaire
        @break

    @case ('defender')
    @default
        Défense
@endswitch

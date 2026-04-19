@props([
    'bga_bid_id',
])

@switch ($bga_bid_id)
    @case (3)
        Garde sans
        @break
    @case (4)
        Garde contre
        @break
    @case (2)
    @default
        Garde
@endswitch

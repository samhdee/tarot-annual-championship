@props([
    /** @var int */
    'king_colour'
])

@switch ($king_colour)
    @case (141)
        ❤️
        @break
    @case (142)
        ♣️
        @break
    @case (143)
        ♦️
        @break
    @case (144)
        ♠️
        @break
@endswitch

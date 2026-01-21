# TODO

- Récupérer les correspondances BGA ID cartes \<=> cartes
- Mettre en place des vérifications de l’intégrité des données (genre total plis == 15, çui-là qu’a pris = çui-là qu’a enchéri)

# Scripts

## IDE Helper

- generate autocompletion for Facades : `php artisan ide-helper:generate`
- add phpdocs for your models :`php artisan ide-helper:models`
  - reset existing phpdocs and write to the models directly: `-RW`
  - generate small version: `--write-eloquent-helper` to 
  - create a separate file: `--nowrite`
  - only add a `@mixin` to your models `--write-mixin`
- `php artisan ide-helper:meta`

## Autres

- récupérer les résultats d’une manche : `php artisan parse:web-results`

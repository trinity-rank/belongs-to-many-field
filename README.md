# Belongs To Many Field For Laravel Nova 4

Belongs To Many Field to represent many to many relationship in field.

- Laravel Nova 4
- Vue 3
- Dark mode support

## Installation
You can require this package using composer:

```composer require trinityrank/belongs-to-many-field```

## Usage
In the nova resource you need to pass:

- Method make ('label', 'many to many relationship function name', 'Nova Resource Relationship')

```php

use TrinityRank\BelongsToManyField\BelongsToManyField;

public function fields(Request $request){
    return [
        BelongsToManyField::make('Job Tags','tags','App\Nova\Jobs\Tag'),
    ];
}
```
![Image of character counter](docs/screenshot.png)


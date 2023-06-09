## Benchmarks list

- [Str::startsWith](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/FirstCharacter/readme.md)
- [Str::endsWith](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/LastCharacter/readme.md)
- [Str::contains](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/StringContains/readme.md)
- [Str::contains (case-insensitive)](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/StringContainsCaseInsensitive/readme.md)
- [Str::lower](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/StringLower/readme.md)
- [Str::after](https://github.com/mujiciok/laravel-benchmarks/tree/master/app/Benchmarks/StringAfter/readme.md)


## Running benchmarks locally

After cloning the repository, navigate to the project directory and run the following commands:

- Copy the `.env.example` file to `.env`:
```shell
cp .env.example .env
```

- Generate the Laravel app key:
```shell
php artisan key:generate
```

- Install the project dependencies using Composer:
```shell
   composer install
```

- Start the Sail environment:
```shell
./vendor/bin/sail up -d
``` 

- Run validation tests for each benchmarked method:
```shell
sail test --filter=testValidation
```

- Run any benchmarking test from the list provided in readme (_it will take some time, as I test up to 1000000 iterations_):
```shell
sail test --filter=LastCharacter
```

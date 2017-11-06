quetie
=========
A bundle which allows easy queing of symfony commands.
It's intention is to be *cute*, as in use a small footprint and be small chunks of easy to understand code. K.I.S.S


#### Dependencies

##### localstack https://github.com/localstack/localstack <3

#### Installation
+ Clone this repo
+ Composer install
+ `php bin/console server:start`
+ `localstack start --docker`

#### Usage
+ Send an api request to `http://127.0.0.1:8000/reports/generate`
    + with `{'emailAddress': test@test.com'}`
+ Run the queue `php bin/console charj:queue:run`
+ Success!

#### Todo

+ Add Logger task, for example so I can log an exception and not interrupt api responses.
+ Email task, twig templating and variables + emogrifier for CSS
+ Benchmarking, how fast is it?
+ Rethink naming of classes. Can it be clearer?

# Yii2 comments module


## About


## Installation



## Usage

**Notes:**
> 1) You can implement your own methods `getAvatar` and `getUsername` in the `userIdentityClass`. Just create this methods in your User model. For example:

```php

public function getAvatar()
{
    // your custom code
}

public function getUsername()
{
    // your custom code
}

```

### Widget with minimum options



## Testing

Run tests in extention folder.

```bash
$ ./vendor/bin/phpunit
```

Note! 
For running all tests needed upload all dependencies by composer. If tested single extention, then run command from root directory where located extention:
```
composer update
```

When all dependencies downloaded run all tests in terminal from root folder:
```
./vendor/bin/phpunit tests
```
Or for only unit:
```
./vendor/bin/phpunit --testsuite Unit
```

If extention tested in app, then set correct path to phpunit and run some commands.

## Credits

- [Sergio Coderius](https://github.com/coderius)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# Azure AD Delta Sync Symfony Bundle

Symfony bundle for Azure AD Delta Sync.

## Installation

To install run

```shell
composer require itk-dev/azure-ad-delta-sync-bundle
```

```shell
yarn install
```

## Usage

Before being able to use the bundle, you must have
your own `User` entity, `UserRepository`  and database setup.

You will need to configure variables for
Microsoft groups, and the above mentioned `User` entity:

### Variable configuration

In `/config/packages` you need the following `itkdev_azure_ad_delta_sync.yaml` file:

```yaml
itkdev_azure_ad_delta_sync:
  azure_ad_delta_sync_options:
    tenant_id: 'some_tenant_id'
    client_id: 'some_client_id'
    client_secret: 'some_client_secret'
    group_id: 'some_group_id'
  user_options:
    system_user_class: 'App\Entity\User'
    system_user_property: 'some_user_property'
    azure_ad_user_property: 'some_azure_ad_user_property'
```

Here `azure_ad_user_property` should be a property on the
Azure AD user that is equivalent to the `system_user_property`
and that is unique for the system user.

### Listening to DeleteUserEvent

The bundle dispatches a `DeleteUserEvent` containing
a list of user properties (`system_user_property`) for potential removal. The using system should
implement logic to ensure these users are not deleted unintentionally.

Therefore, the using system will need to implement an EventListener
or EventSubscriber that listens to the `DeleteUserEvent`.

#### Example EventSubscriber

```php
<?php

namespace App\EventSubscriber;

use ItkDev\AdgangsstyringBundle\Event\DeleteUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeleteUserEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            DeleteUserEvent::class => 'deleteUsers',
        ];
    }

    public function deleteUsers(DeleteUserEvent $event)
    {
        // User deletion logic here
    }
}
```

### Starting the flow

To start the flow the using system execute the follow CLI command:

```shell
php bin/console delta-sync:run
```

It is up to using system to decide how and when to run
this command.

## Development Setup

### Unit Testing

We use PHPUnit for unit testing. To run the tests:

```shell
./vendor/bin/phpunit tests
```

The test suite uses [Mocks](https://phpunit.de/manual/6.5/en/test-doubles.html)
for generation of test doubles.

### Check Coding Standard

* PHP files (PHP_CodeSniffer)

    ```shell
    composer check-coding-standards
    ```

* Markdown files (markdownlint standard rules)

    ```shell
    yarn install
    yarn check-coding-standards
    ```

### Apply Coding Standards

* PHP files (PHP_CodeSniffer)

    ```shell
    composer apply-coding-standards
    ```

* Markdown files (markdownlint standard rules)

    ```shell
    yarn install
    yarn apply-coding-standards
    ```

## Versioning

We use [SemVer](http://semver.org/) for versioning.
For the versions available, see the
[tags on this repository](https://github.com/itk-dev/adgangsstyring-bundle/tags).

## License

This project is licensed under the MIT License - see the
[LICENSE.md](LICENSE.md) file for details

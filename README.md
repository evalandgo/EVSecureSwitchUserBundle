# EVSecureSwitchUserBundle

## Features

## Installation and configuration

### Installation

In composer.json file, add :
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:evalandgo/EVSecureSwitchUserBundle.git"
        }
    ],
    "require": {
        "ev/ev-secureswitchuser-bundle": "dev-master"
    }
}
```
For download this bundle, a permission is requiered on this repository and the Composer needs to use a **SSH** connexion on GitHub
More informations : [`Generating SSH Keys`](https://help.github.com/articles/generating-ssh-keys)

In app/AppKernel.php file, add :
```php
public function registerBundles()
{
    return array(
        // ...
        new EV\SecureSwitchUserBundle\EVSecureSwitchUserBundle(),
        // ...
    );
}
```

### Configuration example

In security.yml
```yaml
ev_secure_switch_user: 
    allowed_to_switch:
        # Les utilisateurs ayant les rôles suivants pourront switch s'ils sont la relationship de l'utilisateur cible
        roles: 
            ROLE_SUPER_ADMIN:
                relationship: adminParent

security:
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    firewalls:
    main:
        # ...
        switch_user: true
```

## Usage example

### In a controller
```php
// Acme\MainBundle\Controller\UserController.php

$controlSwitchUser = $this->container->get('ev_secure_switch_user.handler.control');
if ( $controlSwitchUser->isAllowedToSwitch($loggedUser, $targetUser) ) {
    //do stuff
}
```

### In a service
```xml
<service id="my_bundle.service.myservice" class="my_bundle.service.myservice.class">
    <argument type="service" id="ev_secure_switch_user.handler.control" />
</service>
```

## WARNING
The SwitchUserListener is based on the parameter ```_switch_user```. **Don't change the name of this parameter**.
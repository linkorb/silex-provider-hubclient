# linkorb/silex-provider-hubclient

Provides two services from [perinatologie/hub-client-php][]:-

-  `ApiClientFactory` as a service named `hub_client.factory` which can create
   instances of the HubV3Client and HubV4Client
- `HubV3Client` as a service named `hub_client.service`


## Install

Install using composer:-

    $ composer require linkorb/silex-provider-hubclient

Then configure and register the provider:-

    // app/app.php
    use LinkORB\HubClient\Provider\HubClientProvider;
    ...
    $app->register(
        new HubClientProvider,
        ['hub_client.url' => getenv('HUB_CLIENT_URL'),
        // if you want to use the factory to create a HubV4Client then add the
        // url of the UserBase Json Web Token authentication endpoint
        'hub_client.userbase_url' = getenv('HUB_CLIENT_USERBASE_URL'),
        // add these parameters if you want to directly create the HubV3Client
        // with a fixed set of credentials
        'hub_client.username' = getenv('HUB_CLIENT_USERNAME'),
        'hub_client.password' = getenv('HUB_CLIENT_PASSWORD')]
    );

[perinatologie/hub-client-php]: <https://github.com/perinatologie/hub-client-php>
  "perinatologie/hub-client-php at GitHub"

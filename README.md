# linkorb/silex-provider-hubclient

Provides `Hub\Client\V3\HubV3Client` from [perinatologie/hub-client-php][] as a
service named `hub_client.service`.


## Install

Install using composer:-

    $ composer require linkorb/silex-provider-hubclient

Then configure and register the provider:-

    // app/app.php
    use LinkORB\HubClient\Provider\HubClientProvider;
    ...
    $app->register(
        new HubClientProvider,
        ['hub_client.config' => ['username' => 'my-user',
                                 'password' => 'my-passwd',
                                 'url' => 'http://hub.example.com'
                                 'request_headers => ['User-Agent' => 'MyApp/1.0', ...]]]
    );

Configuration for all but the `request_headers` parameter may be alternatively
achieved through the use of environment variables:-

    export HUB_CLIENT_USERNAME=my-user
    export HUB_CLIENT_PASSWORD=my-passwd
    export HUB_CLIENT_URL=http://hub.example.com

[perinatologie/hub-client-php]: <https://github.com/perinatologie/hub-client-php>
  "perinatologie/hub-client-php at GitHub"

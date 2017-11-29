<?php

namespace LinkORB\HubClient\Provider;

use Hub\Client\Factory\ApiClientFactory;
use Hub\Client\V3\HubV3Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Provides 'hub_client.factory' which creates v3 and v4 Hub API clients' and
 * provides HubV3Client as 'hub_client.service'.
 *
 *
 * The 'hub_client.factory' service requires the following container parameters:-
 *
 * 'hub_client.url' - Base url of the Hub
 *
 * and needs the following parameters only when the factory will be required to
 * build the v4 Hub API client:-
 *
 * 'hub_client.userbase_url' - Url of the UserBase Json Web Token authentication
 *     endpoint.
 *
 *
 * The 'hub_client.service' service requires the following container parameters:-
 *
 * 'hub_client.url' - Base url of the Hub.
 *
 * 'hub_client.username' - Username with which to authenticate with the Hub.
 *
 * 'hub_client.password' - Password with which to authenticate with the Hub.
 *
 *
 * Both service take optional container parameters:-
 *
 * 'hub_client.request_headers' - An array of HTTP request headers
 *
 * 'hub_client.tls_cert_verification' - A boolean or a string: false turns off
 *     TLS certificate verification; true uses the system certificate bundle for
 *     verification; a string path to a certificate bundle to be used instead.
 */
class HubClientProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['hub_client.request_headers'] = [];
        $app['hub_client.tls_cert_verification'] = true;

        $app['hub_client.factory'] = function ($app) {
            if (!isset($app['hub_client.url'])) {
                throw new RuntimeException(
                    'You must provide $app["hub_client.url"] in order to use HubClientProvider.'
                );
            }

            $fac = new ApiClientFactory(
                $app['hub_client.url'],
                $app['hub_client.tls_cert_verification'],
                $app['hub_client.request_headers']
            );

            if (isset($app['hub_client.userbase_url'])) {
                $fac->setUserbaseJwtAuthenticatorUrl($app['hub_client.userbase_url']);
            }

            return $fac;
        };

        $app['hub_client.service'] = function ($app) {
            if (!isset($app['hub_client.url'])) {
                throw new RuntimeException(
                    'You must provide $app["hub_client.url"] in order to use HubClientProvider.'
                );
            }
            if (!isset($app['hub_client.username'])) {
                throw new RuntimeException(
                    'You must provide $app["hub_client.username"] in order to use HubClientProvider.'
                );
            }
            if (!isset($app['hub_client.password'])) {
                throw new RuntimeException(
                    'You must provide $app["hub_client.password"] in order to use HubClientProvider.'
                );
            }

            return new HubV3Client(
                $app['hub_client.username'],
                $app['hub_client.password'],
                $app['hub_client.url'],
                $app['hub_client.request_headers'],
                $app['hub_client.tls_cert_verification']
            );
        };
    }
}

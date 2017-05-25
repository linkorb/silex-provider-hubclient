<?php

namespace LinkORB\HubClient\Provider;

use Hub\Client\V3\HubV3Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Provides 'hub_client.service'.
 *
 * The service may be configured through environment variables or an array
 * of parameters in the container, keyed as 'hub_service.config'.   These
 * can be freely mixed; values from environment variables take precedence
 * over parameter values.
 *
 * Env:
 *   HUB_CLIENT_USERNAME: authentication username; default: ''.
 *   HUB_CLIENT_PASSWORD: authentication password; default: ''.
 *   HUB_CLIENT_URL: Url of the Hub; default: 'localhost'.
 *
 * Parameters:
 *   username, password, url: as environment.
 *   request_headers: an array of HTTP Request header names and thier values
 *                    which the client use in its requests to the Hub.
 *
 */
class HubClientProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['hub_client.service'] = function ($app) {
            $username = $password = '';
            $url = 'localhost';
            $headers = [];

            if (isset($app['hub_client.config'])) {
                if (isset($app['hub_client.config']['username'])) {
                    $username = $app['hub_client.config']['username'];
                }
                if (isset($app['hub_client.config']['password'])) {
                    $password = $app['hub_client.config']['password'];
                }
                if (isset($app['hub_client.config']['url'])) {
                    $url = $app['hub_client.config']['url'];
                }
                if (isset($app['hub_client.config']['request_headers'])
                    && is_array($app['hub_client.config']['request_headers'])
                ) {
                    $headers = $app['hub_client.config']['request_headers'];
                }
            }

            if (getenv('HUB_CLIENT_USERNAME')) {
                $username = getenv('HUB_CLIENT_USERNAME');
            }
            if (getenv('HUB_CLIENT_PASSWORD')) {
                $password = getenv('HUB_CLIENT_PASSWORD');
            }
            if (getenv('HUB_CLIENT_URL')) {
                $url = getenv('HUB_CLIENT_URL');
            }

            return new HubV3Client($username, $password, $url, $headers);
        };
    }
}

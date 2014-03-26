<?php

namespace Application\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DMS\Service\Meetup\MeetupKeyAuthClient;

class MeetupClientPlugin extends AbstractPlugin
{

    /**
     * @var MeetupKeyAuthClient
     */
    protected $client;
    
    protected $access_key;
    
    protected $access_secret;
    
    /**
     * The invoke method for when the controller calls the plugin
     *
     * @throws \RuntimeException
     * @return \DMS\Service\Meetup\MeetupKeyAuthClient
     */
    public function __invoke()
    {
        if (isset($this->client)) {
            return $this->client;
        }

        $config = $this->getController()->getServiceLocator()->get('Config');
        $consumerKey = $config['application']['meetup.com']['oauth1a']['consumer_key'];
        $consumerSecret = $config['application']['meetup.com']['oauth1a']['consumer_secret'];

        if (empty($consumerKey) || empty($consumerSecret)) {
            throw new \RuntimeException('Missing Meetup.com Oauth 1.0a Consumer Key and/or Secret');
        }

        $this->client = MeetupKeyAuthClient::factory(
            array(
                'consumer_key' => $consumerKey,
                'consumer_secret' => $consumerSecret,
            )
        );

        return $this->client;
    }

}

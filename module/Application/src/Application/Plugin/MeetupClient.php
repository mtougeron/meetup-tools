<?php

namespace Application\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DMS\Service\Meetup\MeetupKeyAuthClient;

class MeetupClient extends AbstractPlugin
{

    /**
     * @var MeetupKeyAuthClient
     */
    protected $client;

    public function setClient(MeetupKeyAuthClient $client)
    {
        $this->client = $client;

        return $this;
    }

    public function __invoke(MeetupKeyAuthClient $client = null)
    {
        if ($client !== null) {
            $this->setClient($client);
        } elseif ($this->client == null) {
            $config = $this->getController()->getServiceLocator()->get('Config');
            $client = MeetupKeyAuthClient::factory(
                array(
                    'key' => $config['application']['meetup.com']['api-key']
                )
            );
            $this->setClient($client);
        }

        return $this->client;
    }

}

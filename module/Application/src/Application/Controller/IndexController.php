<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $client = $this->MeetupClient();

        $event = array(
            'description' => 'test event description',
            'name' => 'test event name',
            'group_id' => 120903,
            'group_urlname' => 'sf-php',
            'email_reminders' => 'false',
            'publish_status' => 'draft',
            'rsvp_limit' => 140,
            'waitlisting' => 'auto',
            'time' => strtotime('May 25th, 2015') * 1000, // convert to ms
        );
        try {
//             $response = $client->createEvent($event);
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            echo "<pre>";
            echo 'Uh oh! ' . $e->getMessage();
            echo 'HTTP request URL: ' . $e->getRequest()->getUrl() . "\n";
            echo 'HTTP request: ' . $e->getRequest() . "\n";
            echo 'HTTP response status: ' . $e->getResponse()->getStatusCode() . "\n";
            echo 'HTTP response: ' . $e->getResponse() . "\n";
            die;
        }
//         $response = $client->getRSVPs(array('event_id' => '169678302'));
//         $response = $client->getGroups(array('group_urlname' => 'sf-php'));
        $response = $allEvents = $client->getEvents(array('group_urlname' => 'sf-php'));
//         $allEvents = $client->getEvent(array('id' => '171336722'));

        $view = new ViewModel();
        $view->setVariable('allEvents', $allEvents);

        $view->setVariable('apiResponse', $response);

        return $view;
    }
}

<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Oauth1aController extends AbstractActionController
{
    public function authorizeResponseAction()
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
//                         $response = $client->createEvent($event);
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
        $scheduledEvents = $client->getEvents(array('group_urlname' => 'sf-php', 'status' => 'upcoming'));
        $draftEvents = $client->getEvents(array('group_urlname' => 'sf-php', 'status' => 'draft'));
        $pastEvents = $client->getEvents(array('group_urlname' => 'sf-php', 'status' => 'past'));
        //         $allEvents = $client->getEvent(array('id' => '171336722'));
        
        $view = new ViewModel();
        $view->setVariable('scheduledEvents', $scheduledEvents);
        $view->setVariable('draftEvents', $draftEvents);
        $view->setVariable('pastEvents', $pastEvents);
        
//         $view->setVariable('apiResponse', $response);
        
        return $view;
        
        
        $eventList = $client->getEvents(array('group_urlname' => 'sf-php'));

        $view = new ViewModel();
        $view->setVariable('eventList', $eventList);

        return $view;
    }
}

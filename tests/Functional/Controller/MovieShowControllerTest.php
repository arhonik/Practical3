<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieShowControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testBookingUseCase(): void
    {
        $this->client->request('GET', '/movie-shows');
        $this->assertPageTitleContains('Киносеансы');

        $this->client->clickLink('Забронировать');
        $this->assertPageTitleContains('Киносеанс');

        $pageBooking = $this->client->getCrawler();
        $form = $pageBooking->selectButton('Забронировать')->form();
        $formValues = $form->getValues();
        $form['booking[name]'] = 'Alex';
        $form['booking[phone]'] = '+79021869474';
        $form['booking[movieShowId]'] = $formValues['booking[movieShowId]'];
        $form['booking[_token]'] = $formValues['booking[_token]'];
        $this->client->submit($form);
        $this->assertResponseRedirects();

        $this->client->followRedirect();
        $this->assertSelectorExists('div:contains("Your request has been accepted. The data is being processed.")');
    }
}
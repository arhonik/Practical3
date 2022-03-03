<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieShowControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testMovieShow(): void
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
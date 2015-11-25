<?php
/**
 * Handles functionnal tests for the SecurityController
 *
 * Created by PhpStorm.
 * User: zack
 * Date: 17.11.15
 * Time: 20:27
 */

namespace OpenCastle\SecurityBundle\Tests\Controller;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DropSchemaDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SecurityControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {

        $application = new Application();
        $application->add(new DropSchemaDoctrineCommand());

        $command = $application->find('doctrine:schema:drop');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            '--env'         => 'test',
            '--force' => true,
        ));

    }

    /**
     * Tests everything about the registration process:
     * Wrong infos
     * Response types
     * Correct registration
     */
    public function testInscription()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/security/inscription');

        $this->assertEquals(1, $crawler->filter('[id="modal_inscription"]')->count());

        $usernameInput = $crawler->filter('[id="opencastle_security_player_inscription_username"]')->first();

        $form = $usernameInput->parents()->filter('form')->form();

        $form['opencastle_security_player_inscription[username]'] = 'not_taken';
        $form['opencastle_security_player_inscription[plain_password][first]'] = 'password';
        $form['opencastle_security_player_inscription[plain_password][second]'] = 'password_';

        $crawler = $client->submit($form);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $client->getResponse());

        $response_decoded = json_decode($client->getResponse()->getContent());

        $this->assertEquals('ko', $response_decoded->status);

        $form_errors = json_decode($response_decoded->errors);

        $this->assertCount(1, $form_errors->children->plain_password->children->first->errors);

        // resubmit the form with valid values

        $crawler = $client->request('GET', '/security/inscription');

        $usernameInput = $crawler->filter('[id="opencastle_security_player_inscription_username"]')->first();

        $form = $usernameInput->parents()->filter('form')->form();

        $form['opencastle_security_player_inscription[username]'] = 'not_taken';
        $form['opencastle_security_player_inscription[plain_password][first]'] = 'password';
        $form['opencastle_security_player_inscription[plain_password][second]'] = 'password';

        $crawler = $client->submit($form);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $client->getResponse());

        $response_decoded = json_decode($client->getResponse()->getContent());

        $this->assertEquals('ok', $response_decoded->status);

    }
}
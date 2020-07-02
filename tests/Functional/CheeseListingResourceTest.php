<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;

class CheeseListingResourceTest extends ApiTestCase
{
    //Automatically reload the database
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $user = new User();
        $user->setEmail('test@test.com');
        $user->setUsername('test');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$AdhhEcV/ehyGSvEgoBIPsA$4mDGX0FrdVez5Pwev+lEuOYFVBa7l3gW4mbC7704oQk');

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => $user->getEmail(),
                'password' => 'foo'
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
<?php

namespace App\Test\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnnonceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AnnonceRepository $repository;
    private string $path = '/annonce/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Annonce::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'annonce[titre]' => 'Testing',
            'annonce[description]' => 'Testing',
            'annonce[profil]' => 'Testing',
            'annonce[competence]' => 'Testing',
            'annonce[salaire]' => 'Testing',
            'annonce[ville]' => 'Testing',
            'annonce[departement]' => 'Testing',
            'annonce[contrat]' => 'Testing',
            'annonce[domaine]' => 'Testing',
            'annonce[sousdomaine]' => 'Testing',
            'annonce[societe]' => 'Testing',
        ]);

        self::assertResponseRedirects('/annonce/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfil('My Title');
        $fixture->setCompetence('My Title');
        $fixture->setSalaire('My Title');
        $fixture->setVille('My Title');
        $fixture->setDepartement('My Title');
        $fixture->setContrat('My Title');
        $fixture->setDomaine('My Title');
        $fixture->setSousdomaine('My Title');
        $fixture->setSociete('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfil('My Title');
        $fixture->setCompetence('My Title');
        $fixture->setSalaire('My Title');
        $fixture->setVille('My Title');
        $fixture->setDepartement('My Title');
        $fixture->setContrat('My Title');
        $fixture->setDomaine('My Title');
        $fixture->setSousdomaine('My Title');
        $fixture->setSociete('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annonce[titre]' => 'Something New',
            'annonce[description]' => 'Something New',
            'annonce[profil]' => 'Something New',
            'annonce[competence]' => 'Something New',
            'annonce[salaire]' => 'Something New',
            'annonce[ville]' => 'Something New',
            'annonce[departement]' => 'Something New',
            'annonce[contrat]' => 'Something New',
            'annonce[domaine]' => 'Something New',
            'annonce[sousdomaine]' => 'Something New',
            'annonce[societe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annonce/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getProfil());
        self::assertSame('Something New', $fixture[0]->getCompetence());
        self::assertSame('Something New', $fixture[0]->getSalaire());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getDepartement());
        self::assertSame('Something New', $fixture[0]->getContrat());
        self::assertSame('Something New', $fixture[0]->getDomaine());
        self::assertSame('Something New', $fixture[0]->getSousdomaine());
        self::assertSame('Something New', $fixture[0]->getSociete());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProfil('My Title');
        $fixture->setCompetence('My Title');
        $fixture->setSalaire('My Title');
        $fixture->setVille('My Title');
        $fixture->setDepartement('My Title');
        $fixture->setContrat('My Title');
        $fixture->setDomaine('My Title');
        $fixture->setSousdomaine('My Title');
        $fixture->setSociete('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/annonce/');
    }
}

<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/card', name: 'api_card_')]
#[OA\Tag(name: 'Card', description: 'Routes for all about cards')]
class ApiCardController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    ) {
    }
    #[Route('/all', name: 'List all cards', methods: ['GET'])]
    #[OA\Put(description: 'Return all cards in the database')]
    #[OA\Response(response: 200, description: 'List all cards')]
    public function cardAll(): Response
    {
        $this->logger->info('List all cards');
        $cards = $this->entityManager->getRepository(Card::class)->findAll();
        return $this->json($cards);
    }

    #[Route('/search/{name}', name: 'Search card', methods: ['GET'])]
    #[OA\Parameter(name: 'name', description: 'Name of the card', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Put(description: 'Search a card by name')]
    #[OA\Response(response: 200, description: 'Show card')]
    #[OA\Response(response: 404, description: 'Card not found')]
    public function cardSearch(string $name): Response
    {
        $this->logger->info('Search card ' . $name);
        $cards = $this->entityManager->getRepository(Card::class)->searchByName($name);
        if (!$cards) {
            return $this->json(['error' => 'Card not found'], 404);
        }
        return $this->json($cards);
    }

    #[Route('/setCode', name: 'List all setCode', methods: ['GET'])]
    #[OA\Put(description: 'Return all setCode in the database')]
    #[OA\Response(response: 200, description: 'List all setCode')]
    #[OA\Response(response: 404, description: 'setCode not found')]
    public function cardSetCode(): Response
    {
        $this->logger->info('List all setCode');
        $setCodes = $this->entityManager->getRepository(Card::class)->getAllSetCode();
        return $this->json($setCodes);
    }

    #[Route('/{uuid}', name: 'Show card', methods: ['GET'])]
    #[OA\Parameter(name: 'uuid', description: 'UUID of the card', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Put(description: 'Get a card by UUID')]
    #[OA\Response(response: 200, description: 'Show card')]
    #[OA\Response(response: 404, description: 'Card not found')]
    public function cardShow(string $uuid): Response
    {
        $this->logger->info('Show card ' . $uuid);
        $card = $this->entityManager->getRepository(Card::class)->findOneBy(['uuid' => $uuid]);
        if (!$card) {
            return $this->json(['error' => 'Card not found'], 404);
        }
        return $this->json($card);
    }

    #[Route('/search/{name}', name: 'Search card', methods: ['GET'])]
    #[OA\Parameter(name: 'name', description: 'Name of the card', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Put(description: 'Search a card by name')]
    #[OA\Response(response: 200, description: 'Show card')]
    #[OA\Response(response: 404, description: 'Card not found')]
    public function cardSearch(string $name): Response
    {
        $this->logger->info('Search card ' . $name);
        $cards = $this->entityManager->getRepository(Card::class)->searchByName($name);
        if (!$cards) {
            return $this->json(['error' => 'Card not found'], 404);
        }
        return $this->json($cards);
    }
}

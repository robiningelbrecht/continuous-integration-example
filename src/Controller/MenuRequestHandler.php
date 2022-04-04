<?php

namespace App\Controller;

use App\Domain\Pizza\MemoryBasedPizzaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MenuRequestHandler
{
    public function __construct(
        private MemoryBasedPizzaRepository $pizzaRepository,
    ) {
    }

    /**
     * @Route("/menu", methods={"GET"})
     */
    public function handle(): Response
    {
        return new JsonResponse($this->pizzaRepository->findAll());
    }
}

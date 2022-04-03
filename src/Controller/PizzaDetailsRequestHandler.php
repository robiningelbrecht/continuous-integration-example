<?php

namespace App\Controller;

use App\Domain\Pizza\MemoryBasedPizzaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PizzaDetailsRequestHandler
{
    public function __construct(
        private MemoryBasedPizzaRepository $pizzaRepository,
    ) {
    }

    /**
     * @Route("/pizza/{name}", methods={"GET"})
     */
    public function handle(string $name): Response
    {
        return new JsonResponse($this->pizzaRepository->find($name));
    }
}

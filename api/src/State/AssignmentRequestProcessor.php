<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\AssignmentRequest;
use DateInterval;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class AssignmentRequestProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security
    ) {}

    /**
     * @param AssignmentRequest $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $today = new \DateTimeImmutable();
        $client = $this->security->getUser();
        $data->setClient($client);
        $data->setDate($today);
        $data->setDeadeline($today->add(new \DateInterval("P{$client->getMaxWaitDays()}D")));

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
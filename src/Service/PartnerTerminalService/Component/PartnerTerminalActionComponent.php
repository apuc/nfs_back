<?php

declare(strict_types=1);

namespace App\Service\PartnerTerminalService\Component;

use App\DTO\Request\PartnerTerminalCreateDTO;
use App\DTO\Request\PartnerTerminalEditDTO;
use App\Entity\PartnerTerminal;
use App\Repository\PartnerTerminalRepository;
use App\Repository\ProductPackageRepository;
use App\Service\PartnerService\PartnerService;
use App\Service\PartnerTerminalService\Builder\PartnerTerminalDTOBuilder;
use App\Service\PartnerTerminalService\PartnerTerminalDTO;
use App\Service\ProductService\Builder\ProductDTOBuilder;
use App\Service\TerminalService\TerminalService;
use Psr\Log\LoggerInterface;

class PartnerTerminalActionComponent
{
    public function __construct(
        private PartnerTerminalRepository $repository,
        private PartnerService $partnerService,
        private TerminalService $terminalService,
        private ProductPackageRepository $packageRepository,
        private LoggerInterface $partnerLogger,
    ) {
    }

    public function createNew(PartnerTerminalCreateDTO $requestDTO): PartnerTerminalDTO
    {
        $partnerTerminal = (new PartnerTerminal())
            ->setPartner($this->partnerService->findEntityById($requestDTO->getPartnerId()))
            ->setTerminal($this->terminalService->findEntityById($requestDTO->getTerminalId()))
            ->setProductPackage($this->packageRepository->findOneBy(['id' => $requestDTO->getPackageId()]))
            ->setTransferredAt($requestDTO->getTransferredAt())
            ->setReturnedAt($requestDTO->getReturnedAt())
            ->setCost($requestDTO->getCost());

        $this->repository->save($partnerTerminal);

        return PartnerTerminalDTOBuilder::build($partnerTerminal);
    }

    public function view(int $identifier): ?PartnerTerminalDTO
    {
        return PartnerTerminalDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAll() as $product) {
            $result[] = PartnerTerminalDTOBuilder::build($product);
        }

        return $result;
    }

    public function edit(PartnerTerminalEditDTO $requestDTO): PartnerTerminalDTO
    {
        $product = $this->repository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $product) {
            $partner = $product->getPartner();
            if (null !== $requestDTO->getPartnerId()) {
                $partner = $this->partnerService->findEntityById($requestDTO->getPartnerId());
            }

            $package = $product->getProductPackage()->getId();
            if (null !== $requestDTO->getPackageId()) {
                $package = $this->packageRepository->findOneBy(['id' => $requestDTO->getPackageId()]);
            }

            $terminal = $product->getTerminal();
            if (null !== $requestDTO->getTerminalId()) {
                $terminal = $this->terminalService->findEntityById($requestDTO->getTerminalId());
            }

            $product
                ->setPartner($partner)
                ->setProductPackage($package)
                ->setTerminal($terminal)
                ->setTransferredAt($requestDTO->getTransferredAt())
                ->setReturnedAt($requestDTO->getReturnedAt())
                ->setCost($requestDTO->getCost());

            $this->repository->save($product);
        }

        return PartnerTerminalDTOBuilder::build($product);
    }
}

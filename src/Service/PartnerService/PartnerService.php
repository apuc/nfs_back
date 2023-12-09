<?php

declare(strict_types=1);

namespace App\Service\PartnerService;

use App\DTO\Request\PartnerCreateDTO;
use App\DTO\Request\PartnerEditDTO;
use App\Entity\Partner;
use App\Repository\PartnerRepository;
use App\Service\GeoService\GeoService;
use App\Service\PartnerService\Builder\PartnerDTOBuilder;
use App\Service\PartnerService\Constants\PartnerConstants;
use App\Service\PartnerService\DTO\PartnerDTO;

class PartnerService
{
    public function __construct(
        private PartnerRepository $repository,
        private GeoService $geoService,
    ) {
    }

    /**
     * @return PartnerDTO[]
     */
    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAllNotRemoved() as $partner) {
            $result[] = PartnerDTOBuilder::build($partner);
        }

        return $result;
    }

    public function view(int $identifier): PartnerDTO
    {
        return PartnerDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function createNew(PartnerCreateDTO $requestDTO): PartnerDTO
    {
        $partner = $this->repository->findPartnerByHash($requestDTO->getHash());

        if (null === $partner) {
            $partner = (new Partner())
                ->setTitle($requestDTO->getTitle())
                ->setOccupation($requestDTO->getOccupation())
                ->setDetails([
                    PartnerConstants::DETAILS_KEY_INN => $requestDTO->getInn(),
                    PartnerConstants::DETAILS_KEY_KPP => $requestDTO->getKpp(),
                    PartnerConstants::DETAILS_KEY_OGRN => $requestDTO->getOgrn(),
                    PartnerConstants::DETAILS_KEY_ADDRESS => $requestDTO->getAddress(),
                    PartnerConstants::DETAILS_KEY_BANK => $requestDTO->getBank(),
                    PartnerConstants::DETAILS_KEY_BIK => $requestDTO->getBik(),
                    PartnerConstants::DETAILS_KEY_ACCOUNT_NUMBER => $requestDTO->getAccountNumber(),
                    PartnerConstants::DETAILS_KEY_CORR_ACCOUNT_NUMBER => $requestDTO->getCorrAccountNumber(),
                ])
                ->setContacts([
                    PartnerConstants::CONTACTS_KEY_PHONE_NUMBER => $requestDTO->getPhoneNumber(),
                    PartnerConstants::CONTACTS_KEY_EMAIL => $requestDTO->getEmail(),
                ])
                ->setStatus(PartnerConstants::STATUS_NEW)
                ->setCity($this->geoService->findEntityByTitle($requestDTO->getCity()))
                ->setHash($requestDTO->getHash());

            $this->repository->save($partner);
        }

        return PartnerDTOBuilder::build($partner);
    }

    public function edit(PartnerEditDTO $requestDTO): PartnerDTO
    {
        $partner = $this->repository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $partner) {
            $partnerDTO = PartnerDTOBuilder::build($partner);

            $city = $partner->getCity();
            if (null !== $requestDTO->getCity()) {
                $city = $this->geoService->findEntityByTitle($requestDTO->getCity());
            }

            $partner
                ->setTitle($requestDTO->getTitle())
                ->setOccupation($requestDTO->getOccupation())
                ->setDetails([
                    PartnerConstants::DETAILS_KEY_INN => $requestDTO->getInn(
                    ) ?? $partnerDTO->getDetails()->getInn(),
                    PartnerConstants::DETAILS_KEY_KPP => $requestDTO->getKpp(
                    ) ?? $partnerDTO->getDetails()->getKpp(),
                    PartnerConstants::DETAILS_KEY_OGRN => $requestDTO->getOgrn(
                    ) ?? $partnerDTO->getDetails()->getOgrn(),
                    PartnerConstants::DETAILS_KEY_ADDRESS => $requestDTO->getAddress(
                    ) ?? $partnerDTO->getDetails()->getAddress(),
                    PartnerConstants::DETAILS_KEY_BANK => $requestDTO->getBank(
                    ) ?? $partnerDTO->getDetails()->getBank(),
                    PartnerConstants::DETAILS_KEY_BIK => $requestDTO->getBik(
                    ) ?? $partnerDTO->getDetails()->getBik(),
                    PartnerConstants::DETAILS_KEY_ACCOUNT_NUMBER => $requestDTO->getAccountNumber(
                    ) ?? $partnerDTO->getDetails()->getAccountNumber(),
                    PartnerConstants::DETAILS_KEY_CORR_ACCOUNT_NUMBER => $requestDTO->getCorrAccountNumber(
                    ) ?? $partnerDTO->getDetails()->getCorrAccountNumber(),
                ])
                ->setContacts([
                    PartnerConstants::CONTACTS_KEY_PHONE_NUMBER => $requestDTO->getPhoneNumber(
                    ) ?? $partnerDTO->getContacts()->getPhoneNumber(),
                    PartnerConstants::CONTACTS_KEY_EMAIL => $requestDTO->getEmail() ?? $partnerDTO->getContacts(
                    )->getEmail(),
                ])
                ->setStatus($requestDTO->getStatus() ?? $partnerDTO->getStatus())
                ->setCity($city);

            $this->repository->save($partner);
        }

        return PartnerDTOBuilder::build($partner);
    }

    public function deleteItem(int $identifier): ?PartnerDTO
    {
        $partner = $this->repository->findOneBy(['id' => $identifier]);
        if (null !== $partner) {
            $partner->setStatus(PartnerConstants::STATUS_REMOVED);

            $this->repository->save($partner);
        }

        return PartnerDTOBuilder::build($partner);
    }
}

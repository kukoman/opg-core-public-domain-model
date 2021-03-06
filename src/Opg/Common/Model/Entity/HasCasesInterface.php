<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItem;

/**
 * Interface HasCasesInterface
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasCasesInterface
{
    /**
     * Constants required for filtering
     */
    const CASE_TYPE_POA = 'Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\PowerOfAttorney';
    const CASE_TYPE_DEP = 'Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship';

    /**
     * @return ArrayCollection
     */
    public function getCases();

    /**
     * @param ArrayCollection $caseCollection
     *
     * @return HasCasesInterface
     */
    public function setCases(ArrayCollection $caseCollection);

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function addCase(CaseItem $caseItem);

    /**
     * @param ArrayCollection $caseCollection
     * @return HasCasesInterface
     */
    public function addCases(ArrayCollection $caseCollection);

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function removeCase(CaseItem $caseItem);

    /**
     * @return bool
     */
    public function hasAttachedCase();

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys();

    /**
     * @return ArrayCollection
     */
    public function getDeputyShips();
}

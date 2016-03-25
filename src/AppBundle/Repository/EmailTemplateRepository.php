<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class EmailTemplateRepository
 * @package AppBundle\Repository
 */
class EmailTemplateRepository extends EntityRepository
{
    /**
     * Takma isime göre email şablonundaki konu ve içeriği döndürür
     *
     * @param $emailTemplateSlug
     * @return mixed|null
     */
    public function getEmailTemplateBySlug($emailTemplateSlug)
    {
        $qb = $this->createQueryBuilder('et')
            ->select('et.subject, et.content')
            ->where('et.slug = :slug')
            ->setParameters(array(
                'slug' => $emailTemplateSlug
            ))
        ;
        try {
            $emailTemplate = $qb->getQuery()->getSingleResult(Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            $emailTemplate = null;
        }
        return $emailTemplate;
    }
}
<?php declare(strict_types = 1);

namespace App\Services;

use App\Entity\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Nette\SmartObject;
use Nette\Utils\Strings;

abstract class BaseService
{

    use SmartObject;

    public string $class;

    public function __construct(protected EntityManager $em)
    {
    }

    public function qb(): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('p')->from($this->class, 'p');

        return $qb;
    }

    public function getRepository(): ObjectRepository|EntityRepository|string
    {
        return $this->em->getRepository($this->class);
    }

    public function getEntityManager(): EntityManager
    {
        return $this->em;
    }

    public function persist(object $object): void
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    public function changeValue(string $key, mixed $value, int $id): void
    {
        $record = $this->getRepository()->find($id);
        $setter = 'set' . Strings::firstUpper($key);
        $record->$setter($value);
        $this->em->flush($record);
    }

    public function delete(int $id): void
    {
        $record = $this->getRepository()->find($id);

        if ($record) {
            $this->em->remove($record);
            $this->em->flush($record);
        }
    }

}

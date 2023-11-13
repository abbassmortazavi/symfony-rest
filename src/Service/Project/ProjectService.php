<?php

namespace App\Service\Project;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Request\CreateProjectRequest;
use Doctrine\Persistence\ManagerRegistry;

class ProjectService implements ProjectInterface
{

    public function __construct(protected ManagerRegistry $doctrine, protected Project $project , protected ProjectRepository $projectRepository)
    {

    }

    /**
     * @return array
     */
    public function index(): array
    {
        dd($this->projectRepository->newQuery());
        $products = $this->doctrine->getRepository(Project::class)->findAll();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription()
            ];
        }
        return $data;
    }

    /**
     * @param CreateProjectRequest $dto
     * @return array
     */
    public function create(CreateProjectRequest $dto): array
    {
        $entityManager = $this->doctrine->getManager();

        $this->project->setName($dto->name);
        $this->project->setDescription($dto->description);


        $entityManager->persist($this->project);

        $entityManager->flush();
        return [
            'id' => $this->project->getId(),
            'name' => $this->project->getName(),
            'description' => $this->project->getDescription(),
        ];
    }

    /**
     * @param int $id
     * @return string|array
     */
    public function show(int $id): string|array
    {
        $product = $this->doctrine->getRepository(Project::class)->find($id);

        if ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
            ];
        }
        return 'Product Not Found';
    }

    public function update(int $id, $attributes): mixed
    {
        $entityManager = $this->doctrine->getManager();

        $product = $this->doctrine->getRepository(Project::class)->find($id);

        if ($product) {
            $product->setName($attributes['name']);
            $product->setDescription($attributes['description']);

            $entityManager->flush();
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
            ];
        }
        return 'Product Not Found';
    }

    public function delete(int $id): mixed
    {
        $entityManager = $this->doctrine->getManager();
        $product = $this->doctrine->getRepository(Project::class)->find($id);
        if ($product) {
            $entityManager->remove($product);
            $entityManager->flush();
        }
        return 'Product Not Found';
    }
}
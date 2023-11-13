<?php

namespace App\Service\Project;

use App\Request\CreateProjectRequest;

interface ProjectInterface
{
    /**
     * @return mixed
     */
    public function index(): mixed;

    /**
     * @param CreateProjectRequest $dto
     * @return mixed
     */
    public function create(CreateProjectRequest $dto): mixed;

    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed;

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes): mixed;

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed;
}
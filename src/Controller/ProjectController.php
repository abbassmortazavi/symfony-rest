<?php

namespace App\Controller;

use App\Events\MyFirstEvent;
use App\HandelValidation;
use App\Listeners\MyFirstListener;
use App\Request\CreateProjectRequest;
use App\Service\Project\ProjectService;
use App\Subsribers\DemoSubscriber;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ProjectController extends AbstractController
{
    use HandelValidation;

    public function __construct(protected ProjectService $projectService)
    {

    }

    #[Route('/projects', name: 'project_index', methods: ['get'])]
    public function index(): JsonResponse
    {
        try {
            $data = $this->projectService->index();
            return $this->json([
                'message' => 'Welcome to your new controller!',
                'data' => $data,
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    #[Route('/projects', name: 'project_create', methods: 'POST')]
    public function create(CreateProjectRequest $request): JsonResponse
    {
        try {
            $data = $this->projectService->create($request);
            return $this->json([
                'message' => 'Welcome to your new controller!',
                'data' => $data,
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    #[Route('/projects/{id}', name: 'project_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try {
            return $this->json([
                'message' => 'Welcome to your new controller!',
                'data' => $this->projectService->show($id),
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    #[Route('/projects/{id}', name: 'project_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data['name'] = $request->request->get('name');
            $data['description'] = $request->request->get('description');

            return $this->json([
                'message' => 'Welcome to your new controller!',
                'data' => $this->projectService->update($id, $data),
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    #[Route('/projects/{id}', name: 'project_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            return $this->json([
                'message' => 'Welcome to your new controller!',
                'data' => $this->projectService->delete($id),
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function testEvent()
    {
        //dispatch event
        //$dispatch = new EventDispatcher();
        /*$listener = new MyFirstListener();
        $dispatch->addListener('demo.event', array($listener, 'onDemoEvent'));
        $dispatch->dispatch(new MyFirstEvent(), MyFirstEvent::NAME);*/


        //add subscriber
        /* $subscriber = new DemoSubscriber();
         $dispatch->addSubscriber($subscriber);
         $dispatch->dispatch(new MyFirstEvent(), MyFirstEvent::NAME);*/
    }

}

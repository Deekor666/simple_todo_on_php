<?php

namespace App\controllers;


use App\App;
use App\models\Task;
use App\Pagination;
use App\View;

class TaskController
{
    private View $view;
    private Task $task;
    private Pagination $pagination;

    public function __construct(View $view, Task $task, Pagination $pagination)
    {
        $this->task = $task;
        $this->view = $view;
        $this->pagination = $pagination;
    }

    public function index($params = [])
    {
        $sort = $_GET['sort'] ?? 'username';
        $order = $_GET['order'] ?? 'ASC';
        $page = $_GET['page'] ?? 1;
        $limit = 3;

        $totalTasks = $this->task->getTotalTasks();
        $this->pagination->setup($totalTasks, $page, $limit, App::getBaseUrl());
        $tasks = $this->task->getAllTasks($this->pagination->getCurrentPage(), $limit, $sort, $order);

        $this->view->render('tasks/index', [
            'tasks' => $tasks,
            'pagination' => $this->pagination,
            'sort' => $sort,
            'order' => $order,
        ]);
    }

    public function create($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $text = $_POST['text'];

            $errors = $this->validateTask($username, $text);

            if (empty($errors)) {
                $this->task->createTask($text, $username);
                header("Location: /");
                exit();
            }
        }

        $this->view->render('tasks/create', [
            'errors' => $errors ?? [],
            'username' => $username ?? '',
            'text' => $text ?? ''
        ]);
    }

    private function validateTask($username, $text): array
    {
        $errors = [];

        if (empty($username)) {
            $errors[] = 'Некорректный Username';
        }

        if (empty($text)) {
            $errors[] = 'Текст задачи не может быть пустым';
        }

        return $errors;
    }

    public function edit($params = [])
    {
        $id = $params['id'] ?? '';

        if (empty($id)) {
            header("Location: /");
            exit();
        }

        $taskById = $this->task->getTaskById($id);

        $this->view->render('tasks/edit', [
            'errors' => $errors ?? [],
            'task' => $taskById,
        ]);
    }

    public function update($params = [])
    {
        $id = $params['id'] ?? '';

        if (empty($id)) {
            header("Location: /");
            exit();
        }

        $text = $_POST['text'] ?? '';
        $status = isset($_POST['status']) ? 1 : 0;
        $username = $_POST['username'] ?? 'empty';
        $this->task->updateTask($id, $text, $username, $status);

        header("Location: /");
        exit();
    }
}
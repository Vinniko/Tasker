<?php


namespace App\Http\Controllers;


use App\Http\Models\Task;
use App\Http\Models\User;
use App\Services\Redirector;
use Josantonius\Session\Session;

class TaskController extends Controller
{
    const TASKS_PER_PAGE = 3;
    private $task_created_message = 'Запись успешно создана';
    private $task_updated_message = 'Запись успешно обновлена';
    private $unauthorized_message = 'Вы не вошли в сисему!';

    public function index()
    {
        $tasks = Task::with('user');
        $page = $this->request->query->has('page') ? $this->request->query->get('page') : null;
        $sort = $this->request->query->has('sort') ? $this->request->query->get('sort') : null;
        $direction = $this->request->query->has('direction') ? $this->request->query->get('direction') : null;

        if ($direction && $sort) {
            $tasks->orderBy(User::select($sort)->whereColumn('tasks.user_id', 'users.id'), $direction);
        }

        if ($page) {
            $tasks = $tasks->paginate(self::TASKS_PER_PAGE, ['*'], 'page',
                intval($page));
        } else {
            $tasks = $tasks->paginate(self::TASKS_PER_PAGE);
        }

        return $this->twig->render('pages/home.html.twig', [
            'tasks' => $tasks,
            'next_page_url' => sprintf('/home%s&%s&%s', ltrim($tasks->nextPageUrl(), '/'),
                $sort ? "sort=$sort" : '', $direction ? "direction=$direction" : ''),
            'previous_page_url' => sprintf('/home%s&%s&%s', ltrim($tasks->previousPageUrl(), '/'),
                $sort ? "sort=$sort" : '', $direction ? "direction=$direction" : ''),
            'is_last' => $tasks->hasMorePages(),
            'is_first' => $tasks->onFirstPage(),
            'name_sort_link' => sprintf('/home?page=%s&sort=username&%s',
                $tasks->currentPage(), $direction == 'asc' ? 'direction=desc' : 'direction=asc'),
            'email_sort_link' => sprintf('/home?page=%s&sort=email&%s',
                $tasks->currentPage(), $direction == 'asc' ? 'direction=desc' : 'direction=asc'),
            'status_sort_link' => sprintf('/home?page=%s&sort=status&%s',
                $tasks->currentPage(), $direction == 'asc' ? 'direction=desc' : 'direction=asc'),
            'is_authorized' => Session::get('status'),
        ]);
    }

    public function create(string $message = null)
    {
        $users = User::select('username')->get();
        $message = $this->request->query->has('message') ? $this->request->query->get('message') : null;

        return $this->twig->render('pages/task.create.html.twig', [
            'users' => $users,
            'is_authorized' => Session::get('status'),
            'message' => $message,
        ]);
    }

    public function store()
    {
        $parameters = $this->request->request;
        Task::create([
            'user_id' => User::where('username', $parameters->get('username'))->first()->id,
            'text' => htmlspecialchars($parameters->get('text')),
            'status' => $parameters->get('is_complete') == 'on',
        ]);

        Redirector::redirect("/task/create?message=$this->task_created_message");
    }


    public function update(string $message = null)
    {
        if (!Session::get('status')) {
            Redirector::redirect('/login');
        }

        $task_id = $this->request->query->has('id')
            ? $this->request->query->get('id')
            : Redirector::redirect('/home');
        $task = Task::with('user')->find($task_id);
        $users = User::select('username')->get();
        $message = $this->request->query->has('message') ? $this->request->query->get('message') : null;

        return $this->twig->render('pages/task.update.html.twig', [
            'users' => $users,
            'is_authorized' => Session::get('status'),
            'message' => $message,
            'task' => $task,
            'q' => "q"
        ]);
    }

    public function edit()
    {
        if (!Session::get('status')) {
            Redirector::redirect("/login?error=$this->unauthorized_message");
        }

        $parameters = $this->request->request;
        $task = Task::find($parameters->get('id'));

        $task->user_id = User::where('username', $parameters->get('username'))->first()->id;
        $task->status = $parameters->get('is_complete') == 'on';


        if ($task->text != htmlspecialchars($parameters->get('text'))) {
            $task->text = htmlspecialchars($parameters->get('text'));
            $task->is_admined = 1;
        }

        $task->save();

        Redirector::redirect("/task/update?id=$task->id&message=$this->task_updated_message");
    }
}
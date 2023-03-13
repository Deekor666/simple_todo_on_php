<div class="container"></div>
<div class="container flex-column d-flex justify-content-center align-items-center">
    <div class="col-md-5">
        <form method="get" action="/">
            <label for="sort">Сортировка по:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="username" <?php if ($sort == 'username') echo 'selected'; ?>>Имя пользователя
                </option>
                <option value="status" <?php if ($sort == 'status') echo 'selected'; ?>>Статус</option>
            </select>
        </form>
    </div>
</div>

<div class="container flex-column justify-content-center align-items-center">
    <div class="row mt-4">
        <?php foreach ($tasks as $task): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $task['username'] ?></h5>
                        <p class="card-text"><?= $task['text'] ?></p>
                        <p class="card-text"><small class=" <?= $task['status'] ? 'text-success' : 'text-muted' ?>">Статус: <?= $task['status'] ? 'Выполнено' : 'Не выполнено' ?></small>
                        </p>
                        <?php if (!empty($userIsAdmin)): ?>
                            <a class="btn btn-primary" href="/tasks/edit/<?= $task['id'] ?>">Edit</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-12">
        <nav aria-label="Страницы">
            <ul class="pagination justify-content-center">
                <?php if ($pagination->getPrevUrl()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pagination->getPrevUrl() ?>" aria-label="Предыдущая">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php foreach ($pagination->getPages() as $page): ?>
                    <?php if ($page['isCurrent']): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="<?= $page['url'] ?>"><?= $page['num'] ?></a>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $page['url'] ?>"><?= $page['num'] ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($pagination->getNextUrl()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pagination->getNextUrl() ?>" aria-label="Следующая">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

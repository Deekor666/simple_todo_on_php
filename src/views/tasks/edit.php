<div class="container mt-5">
    <h1 class="mb-4">Edit Task</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form class="form" action="/tasks/update/<?php echo $task['id']; ?>" method="POST">
        <div class="form-group mb-3">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?php echo $task['username']; ?>">
        </div>
        <div class="form-group mb-3">
            <label for="text">Text:</label>
            <textarea class="form-control" id="text" name="text"><?php echo $task['text']; ?></textarea>
        </div>
        <div class="form-group form-check form-switch mb-3">
            <input type="checkbox" class="form-check-input" id="status"
                   name="status" <?= $task['status'] ? 'checked' : '' ?>
                   value="<?php echo $task['status']; ?>">
            <label class="form-check-label" for="status">
                Done
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>

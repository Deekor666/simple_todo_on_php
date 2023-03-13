<div class="container">
    <h1>Create New Task</h1>
    <form method="POST" action="/tasks/create">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?= $_SESSION['user_username'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label for="text">Text</label>
            <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
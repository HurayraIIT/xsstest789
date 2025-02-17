<?php
// File to store tasks
$tasksFile = 'tasks.txt';

// Load existing tasks from the file
$tasks = [];
if (file_exists($tasksFile)) {
    $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add a new task
        $newTask = trim($_POST['task_name']);
        if (!empty($newTask)) {
            $tasks[] = $newTask;
            file_put_contents($tasksFile, implode(PHP_EOL, $tasks) . PHP_EOL);
        }
    } elseif (isset($_POST['delete'])) {
        // Delete a task
        $taskIndex = (int)$_POST['task_index'];
        if (isset($tasks[$taskIndex])) {
            array_splice($tasks, $taskIndex, 1);
            file_put_contents($tasksFile, implode(PHP_EOL, $tasks) . PHP_EOL);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Task Manager</title>
</head>
<body>
    <h1>Task Manager</h1>

    <!-- Form to add a new task -->
    <form method="POST">
        <input type="text" name="task_name" placeholder="Enter a task" required>
        <button type="submit" name="add">Add Task</button>
    </form>

    <!-- Display tasks -->
    <h2>Tasks List</h2>
    <ul>
        <?php foreach ($tasks as $index => $task): ?>
            <li>
                <?php echo htmlspecialchars($task); ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="task_index" value="<?php echo $index; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<?php
require_once 'dbconnection.php';
$db = new Database();
$conn = $db->getDb();

if (isset($_POST['update'])) {
    $userid = intval($_GET['id']);
    $users = $_POST['users'];
    $title = $_POST['title'];
    $messages = $_POST['messages'];

    $sql = "UPDATE users SET users = :users, title = :title, messages = :messages WHERE id = :uid";
    $query = $conn->prepare($sql);

    $query->bindParam(':users', $users, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':messages', $messages, PDO::PARAM_STR);
    $query->bindParam(':uid', $userid, PDO::PARAM_INT);

    $query->execute();
    echo "<script>alert('Record updated successfully');</script>";
    echo "<script>window.location.href = 'userchecker.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }
        body{
            background-image: url(edit.webp);
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 overflow-hidden">
    <div class="flex justify-end p-4">
        <div class="relative">
            <button id="dropdownButton" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 transition-transform transform -translate-y-2">
                <a href="attendancechecker.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Check Users</a>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center items-center h-screen px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg px-6 py-8 shadow-2xl ring-2 ring-gray-900/10 max-w-md w-full space-y-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-center shadow-text">EDIT NOTEPAD</h1>
            </div>
            <?php
            $userid = intval($_GET['id']);
            $sql = "SELECT * FROM users WHERE id = :uid";
            $query = $conn->prepare($sql);

            $query->bindParam('uid', $userid, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($result as $results) {
            ?>
                    <form id="userForm" method="POST" class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input placeholder="Title" type="text" name="title" id="title" value="<?php echo htmlentities($results['title']) ?>" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="messages" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Messages</label>
                            <input placeholder="Messages" type="text" name="Messages" id="Messages" value="<?php echo htmlentities($results['messages']) ?>" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="users" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                            <input placeholder="Username" type="text" name="users" id="users" value="<?php echo htmlentities($results['users']) ?>" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                        </div>
                <?php
                    $cnt++;
                }
            }
                ?>
                <div class="flex justify-between">
                    <input type="submit" id="update" name="update" value="Submit" class="px-6 py-3 bg-blue-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <a href="attendancechecker.php"><input type="button" value="Cancel" class="px-6 py-3 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"></a>
                </div>
                    </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dropdownButton').click(function() {
                $('#dropdownMenu').toggleClass('hidden');
                $('#dropdownMenu').toggleClass('translate-y-0');
            });
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            background-image: url(note.webp);
            background-size: cover;
        }
        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }

        .shadow-text {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .form-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body>
    <div class="flex justify-end p-4">
        <div class="relative">
            <button id="dropdownButton" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 transition-transform transform -translate-y-2">
                <a href="userchecker.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Check Users</a>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center items-center h-screen px-4 sm:px-6 lg:px-8">
        <div class="bg-gray dark:bg-gray-800 rounded-lg px-6 py-8 shadow-2xl ring-2 ring-gray-900/10 max-w-md w-full space-y-8 form-shadow">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-center shadow-text">NOTEPAD</h1>
            </div>
            <form id="userForm" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input placeholder="Title" type="text" name="title" id="title" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                </div>
                <div>
                    <label for="messages" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                    <input placeholder="Message" type="text" name="messages" id="messages" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                </div>
                <div>
                    <label for="users" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                    <input placeholder="Username" type="text" name="users" id="users"  class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">
                </div>
                <div class="flex justify-between">
                    <input type="submit" value="Submit" class="px-6 py-3 bg-blue-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <input type="reset" value="Reset" class="px-6 py-3 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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

            $('#userForm').submit(function(e) {
                e.preventDefault();

                let title = $('#title').val().trim();
                let messages = $('#messages').val().trim();
                let users = $('#users').val().trim();

                if (!title || !messages || !users) {
                    alert("All fields are required!");
                    return;
                }

                const frm = new FormData();
                frm.append("method", "saveUser");
                frm.append("title", title);
                frm.append("messages", messages);
                frm.append("users", users);

                axios.post("handler.php", frm)
                    .then(function(response) {
                        if (response.data.ret == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Entered Successfully",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#title').val('');
                            $('#messages').val('');
                            $('#users').val('');
                        } else {
                            alert("Error: " + (response.data.msg || "Unknown error"));
                        }
                    })
                    .catch(function(error) {
                        console.error("Request failed:", error);
                        alert("Something went wrong!");
                    });
            });
        });
    </script>
</body>

</html>
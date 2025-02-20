<?php
// Koneksi ke database
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];
    $password = $_POST['pass'];
    $role = 'user';

    
    $stmt = $conn->prepare("INSERT INTO form (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $role);
    
    if ($stmt->execute()) {
        header("Location: sukses.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="/css/style.css">
    <script>
        function togglePassword() {
          const passwordInput = document.getElementById("password");
          const passIcon = document.getElementById("pass-icon");
  
          if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passIcon.src = "/img/eye.png"; 
          } else {
            passwordInput.type = "password";
            passIcon.src = "/img/hidden.png"; 
          }
        }
      </script>
</head>
<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="flex flex-col items-center">
            <img src="img\Logo2.png" alt="Logo" class="h-12 mb-4">   
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">register</h2>
        </div>

            <form action="register.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="Masukan email Kamu"
                        name="mail"
                        required
                    />
                </div>

                <div class="relative w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all pr-10"
                            placeholder="••••••••"
                            id="password"
                            name="pass"
                            required
                        />
                        <img
                            src="/img/hidden.png"
                            onclick="togglePassword()"
                            id="pass-icon"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 cursor-pointer"
                        />
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Daftar
                </button>
            </form>
        </div>
    </div>
</body>
</html>

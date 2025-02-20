<?php
session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query untuk mengecek email dan password
  $stmt = $conn->prepare("SELECT * FROM form WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role']; // Sesuaikan dengan kolom role jika ada
    
      // Redirect berdasarkan role
      if ($user['role'] === 'admin') {
          header("Location: admin.php");
      } else {
          header("Location: home.php");
      }
      exit();
  } else {
      $error = "Email atau password salah!";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk</title>
    <link rel="stylesheet" href="/css/style.css" />     
    <script>
      function togglePassword() {
        const passwordInput = document.getElementById("password");
        const passIcon = document.getElementById("pass-icon");

        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          passIcon.src = "/public/img/eye.png"; 
        } else {
          passwordInput.type = "password";
          passIcon.src = "/public/img/hidden.png"; 
        }
      }
    </script>
</head>
<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="flex flex-col items-center">
            <img src="img\Logo2.png" alt="Logo" class="h-16 mb-4">   
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Masuk</h2>
        </div>

            <form method="post" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="Masukan email kamu"
                        required
                    />
                </div>

                <div class="relative w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all pr-10"
                            placeholder="••••••••"
                            id="password"
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

                <?php if (isset($error)): ?>
                    <div class="text-red-600 text-sm"><?php echo $error; ?></div>
                <?php endif; ?>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors"
                >
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
               Belum punya akun?
                <a
                    href="register.php"
                    class="text-indigo-600 hover:text-indigo-500 font-medium"
                >Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>

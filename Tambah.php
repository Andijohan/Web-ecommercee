<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    
    <div class="w-64 bg-sky-300 shadow-md">
        <div class="flex items-center justify-center h-20 shadow-md">
        <a href="admin.php"><img src="img\Logo2.png" alt="Logo" class="h-16 mb-4 mt-4"> </a>
        </div>
        <ul class="py-4">
            <li>
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">➕</span>
                    <span class="font-medium">Tambah Barang</span>
                </a>
            </li>
            <li>
                <a href="list.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">✏️</span>
                    <span class="font-medium">List Barang</span>
                </a>
            </li>
            <li>
                <a href="Masuk.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-sky-400 transition">
                    <span class="text-lg text-gray-600 mr-3">🚪</span>
                    <span class="font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="flex-1 p-10">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Produk</h1>
        <p class="text-gray-600 mt-2">Silakan isi formulir di bawah ini untuk menambahkan produk baru.</p>

        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md mt-10">
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                
            <div id="drop-zone" class="relative border-2 border-dashed border-gray-300 p-8 text-center bg-gray-50 rounded-lg cursor-pointer flex flex-col items-center justify-center hover:bg-gray-100 transition">
                <input type="file" id="file-input" name="gambar" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <p class="text-gray-500 mt-3 text-lg font-medium">Klik atau drag & drop untuk mengunggah gambar</p>
            </div>

            <div id="preview-container" class="mt-4 flex flex-col items-center">
                <img id="preview-image" class="w-full max-h-full object-cover rounded-md border border-gray-300 shadow-md">
                <button type="button" id="remove-image" class="mt-3 px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600">Hapus</button>
            </div>

            <div class="mb-5 mt-4">
                <label for="nama_barang" class="block mb-2 text-sm font-medium text-black">Nama Produk :</label>
                <input type="text" name="nama_barang" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama barang" required />
            </div>

            <div class="mb-5">
                <label for="kategori_barang" class="block mb-2 text-sm font-medium text-black">Kategori Barang :</label>
                <select name="kategori_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Pakaian">Pakaian</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="harga" class="block mb-2 text-sm font-medium text-black">Harga Barang :</label>
                <input type="number" name="harga" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan harga barang" required />
            </div>

            <div class="mb-5">
                <label for="deskripsi_barang" class="block mb-2 text-sm font-medium text-black">Deskripsi Barang :</label>
                <textarea name="deskripsi_barang" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan deskripsi barang" required></textarea>
            </div>

            <div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const removeImage = document.getElementById('remove-image');

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    removeImage.addEventListener('click', () => {
        previewImage.src = '';
        previewContainer.classList.add('hidden');
        fileInput.value = '';
    });
</script>

</body>
</html>

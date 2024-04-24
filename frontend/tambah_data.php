<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <h1 class="text-3xl font-bold text-center my-4">Tambah Data Mahasiswa</h1>
    <div id="form-container" class="w-full max-w-md mx-auto">
        <form id="add-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nim">
                    NIM
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nim" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_mk">
                    Kode MK
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kode_mk" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nilai">
                    Nilai
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nilai" type="text" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onclick="addData()">
                    Save
                </button>
            </div>
        </form>
    </div>

    <script>
        function addData() {
    const nim = document.getElementById('nim').value;
    const kode_mk = document.getElementById('kode_mk').value;
    const nilai = document.getElementById('nilai').value;

    fetch('http://localhost/PSAIT_UTS/backend/mahasiswa.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            nim: nim,
            kode_mk: kode_mk,
            nilai: nilai
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.error) {
            alert(data.error);
        } else {
            alert('Data successfully added');
            window.location.href = 'index.php';
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
    </script>
</body>
</html>
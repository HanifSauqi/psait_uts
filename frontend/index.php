<!DOCTYPE html>
<html>
<head>
    <title>Nilai Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Style for the popup card */
        #popup-card {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        #popup-card-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
    <script>
        window.onload = function() {
            fetch('http://localhost/PSAIT_UTS/backend/mahasiswa.php')
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.nim.localeCompare(b.nim));

                let data_mahasiswa = document.getElementById('data_mahasiswa');
                let no = 1;
                data.forEach(row => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2">${no++}</td>
                    <td class="px-4 py-2">${row.nim}</td>
                    <td class="px-4 py-2">${row.nama}</td>
                    <td class="px-4 py-2">${row.alamat}</td>
                    <td class="px-4 py-2">${row.tanggal_lahir}</td>
                    <td class="px-4 py-2">${row.kode_mk}</td>
                    <td class="px-4 py-2">${row.nama_mk}</td>
                    <td class="px-4 py-2">${row.sks}</td>
                    <td class="px-4 py-2">${row.nilai}</td>
                    <td class="px-4 py-2"><button class="px-2 py-1 bg-green-500 text-white rounded" onclick="updateData('${row.nim}', '${row.kode_mk}')">Edit</button></td>
                    <td class="px-4 py-2"><button class="px-2 py-1 bg-red-500 text-white rounded" onclick="deleteData('${row.nim}', '${row.kode_mk}')">Delete</button></td>
                `;
                data_mahasiswa.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));

            // Add event listener to close popup card when clicked outside
            window.addEventListener('click', function(event) {
                let popupCard = document.getElementById('popup-card');
                if (event.target == popupCard) {
                    popupCard.style.display = "none";
                }
            });
        };

        function deleteData(nim, kode_mk) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                fetch(`http://localhost/PSAIT_UTS/backend/mahasiswa.php?nim=${nim}&kode_mk=${kode_mk}`, {
                    method: 'DELETE',
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text().then((text) => {
                        return text ? JSON.parse(text) : {}
                    })
                })
                .then((data) => {
                    // Refresh the page or remove the row from the table
                    alert('Data berhasil dihapus');
                    location.reload();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        }

        function updateData(nim, kode_mk) {
            let popupCard = document.getElementById('popup-card');
            let form = document.getElementById('form-nilai');
            form.nim.value = nim;
            form.kode_mk.value = kode_mk;
            popupCard.style.display = "block";
        }

        function submitForm() {
            let form = document.getElementById('form-nilai');
            let nim = form.nim.value;
            let kode_mk = form.kode_mk.value;
            let nilai = form.nilai.value;

            fetch(`http://localhost/PSAIT_UTS/backend/mahasiswa.php?nim=${nim}&kode_mk=${kode_mk}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nilai: nilai
                }),
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text().then((text) => {
                    return text ? JSON.parse(text) : {}
                })
            })
            .then((data) => {
                alert('Data successfully updated');
                location.reload();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body class="bg-gray-100">
    <h1 class="text-3xl font-bold text-center my-4">Nilai Mahasiswa</h1>
    <div class="flex justify-end mb-4">
        <a href="tambah_data.php" class="px-4 py-2 bg-blue-500 text-white rounded">Tambah Data</a>
    </div>

    <table class="w-full table-auto bg-white rounded-lg shadow-md">
        <thead class="bg-blue-500 text-white">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">NIM</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Alamat</th>
                <th class="px-4 py-2">Tanggal Lahir</th>
                <th class="px-4 py-2">Kode MK</th>
                <th class="px-4 py-2">Nama MK</th>
                <th class="px-4 py-2">SKS</th>
                <th class="px-4 py-2">Nilai</th>
                <th class="px-4 py-2">Edit</th>
                <th class="px-4 py-2">Delete</th>
            </tr>
         </thead>
        <tbody id="data_mahasiswa" class="text-center">
             <!-- Data will be inserted here -->
        </tbody>
    </table>


  <!-- Popup card for updating nilai -->
    <div id="popup-card" class="fixed z-10 inset-0 overflow-auto bg-black bg-opacity-40">
        <div id="popup-card-content" class="m-auto p-5 border border-gray-800 w-4/5 bg-white">
            <h2 class="text-xl font-bold mb-4">Edit Nilai</h2>
            <form id="form-nilai" onsubmit="event.preventDefault(); submitForm();" class="space-y-4">
                <input type="hidden" name="nim">
                <input type="hidden" name="kode_mk">
                <label for="nilai" class="block">Nilai:</label>
                <input type="text" id="nilai" name="nilai" class="w-full px-3 py-2 border border-gray-300 rounded">
                <input type="submit" value="Submit" class="px-4 py-2 bg-blue-500 text-white rounded">
            </form>
        </div>
    </div>
</body>
</html>
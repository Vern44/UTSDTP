
<?php
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Kerusakan Fasilitas Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- HEADER -->
    <header class="bg-slate-800 text-white">
        <div class="max-w-5xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
            <div>
                <h1 class="text-lg font-bold">
                    Pelaporan Kerusakan Fasilitas
                </h1>
                <p class="text-xs text-slate-300">
                    Sistem Laporan Kerusakan Sekolah
                </p>
            </div>

            <nav class="flex gap-2 text-sm">
                <a href="#form-laporan"
                   class="px-3 py-2 rounded hover:bg-slate-700">
                    Buat Laporan
                </a>

                <a href="#daftar-laporan"
                   class="px-3 py-2 rounded hover:bg-slate-700">
                    Daftar Laporan
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-4 space-y-5">

        <!-- PESAN SUKSES -->
        <?php if (!empty($pesan_sukses)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg text-sm">
                <?= htmlspecialchars($pesan_sukses) ?>
            </div>
        <?php endif; ?>

        <!-- PESAN ERROR -->
        <?php if (!empty($pesan_error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
                <?= htmlspecialchars($pesan_error) ?>
            </div>
        <?php endif; ?>


        <!-- FORM LAPORAN -->
        <section id="form-laporan"
                 class="bg-white p-5 rounded-lg border border-gray-200">

            <div class="mb-4">
                <h2 class="text-lg font-bold">
                    Buat Laporan
                </h2>
                <p class="text-sm text-gray-500">
                    Isi informasi fasilitas yang mengalami kerusakan.
                </p>
            </div>

            <form action="#form-laporan" method="post" class="space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label for="nama_pelapor"
                               class="block text-sm font-medium mb-1">
                            Nama Pelapor
                        </label>

                        <input type="text"
                               id="nama_pelapor"
                               name="nama_pelapor"
                               required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    </div>

                    <div>
                        <label for="nama_fasilitas"
                               class="block text-sm font-medium mb-1">
                            Nama Fasilitas
                        </label>

                        <input type="text"
                               id="nama_fasilitas"
                               name="nama_fasilitas"
                               required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    </div>

                    <div>
                        <label for="lokasi"
                               class="block text-sm font-medium mb-1">
                            Lokasi Kerusakan
                        </label>

                        <input type="text"
                               id="lokasi"
                               name="lokasi"
                               required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    </div>

                    <div>
                        <label for="id_kategori"
                               class="block text-sm font-medium mb-1">
                            Kategori Fasilitas
                        </label>

                        <select id="id_kategori"
                                name="id_kategori"
                                required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-400">

                            <option value="">Pilih kategori</option>

                            <?php foreach ($list_kategori as $kat): ?>
                                <option value="<?= (int) $kat['id_kategori'] ?>">
                                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                </div>

                <div>
                    <label for="deskripsi"
                           class="block text-sm font-medium mb-1">
                        Deskripsi Kerusakan
                    </label>

                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              required
                              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400"
                              placeholder="Jelaskan kerusakan fasilitas..."></textarea>
                </div>

                <div class="sm:w-1/2">
                    <label for="prioritas"
                           class="block text-sm font-medium mb-1">
                        Prioritas
                    </label>

                    <select id="prioritas"
                            name="prioritas"
                            required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-400">

                        <option value="">Pilih prioritas</option>
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Tinggi">Tinggi</option>

                    </select>
                </div>

                <button type="submit"
                        class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Kirim Laporan
                </button>

            </form>
        </section>


        <!-- DAFTAR LAPORAN -->
        <section id="daftar-laporan"
                 class="bg-white rounded-lg border border-gray-200 overflow-hidden">

            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-bold">
                    Daftar Laporan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ringkasan laporan kerusakan fasilitas sekolah.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 font-semibold">No.</th>
                            <th class="px-4 py-3 font-semibold">Fasilitas</th>
                            <th class="px-4 py-3 font-semibold">Pelapor</th>
                            <th class="px-4 py-3 font-semibold">Prioritas</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        <?php if (!empty($list_laporan)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($list_laporan as $row): ?>

                                

                                <tr class="hover:bg-gray-50">

                                    <!-- NOMOR -->
                                    <td class="px-4 py-3 text-gray-500">
                                        <?= $no++ ?>
                                    </td>

                                    <!-- FASILITAS, LOKASI, KATEGORI -->
                                    <td class="px-4 py-3 min-w-48">

                                        <p class="font-medium text-gray-800">
                                            <?= htmlspecialchars($row['nama_fasilitas']) ?>
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            <?= htmlspecialchars($row['lokasi']) ?>
                                            &middot;
                                            <?= htmlspecialchars($row['nama_kategori']) ?>
                                        </p>

                                        <p class="text-xs text-gray-400 mt-1">
                                            <?= htmlspecialchars(
                                                mb_strimwidth(
                                                    $row['deskripsi'],
                                                    0,
                                                    55,
                                                    '...'
                                                )
                                            ) ?>
                                        </p>

                                        <p class="text-xs text-gray-400 mt-1">
                                            <?= date(
                                                'd/m/Y',
                                                strtotime($row['tanggal_laporan'])
                                            ) ?>
                                        </p>

                                    </td>

                                    <!-- PELAPOR -->
                                    <td class="px-4 py-3">
                                        <?= htmlspecialchars($row['nama_pelapor']) ?>
                                    </td>

                                    <!-- PRIORITAS -->
                                   <td class="px-4 py-3">
                                         <span class="text-xs font-medium text-gray-700">
                                        <?= htmlspecialchars($row['prioritas']) ?>
                                        </span>
                                    </td>
                                    <!-- STATUS -->
                                    <td class="px-4 py-3">
                                    <span class="text-xs font-medium text-gray-700">
                                        <?= htmlspecialchars($row['status']) ?>
                                     </span>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5"
                                    class="px-4 py-10 text-center text-gray-400">
                                    Belum ada laporan kerusakan.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>
        </section>

    </main>


    <!-- FOOTER -->
    <footer class="text-center py-5 text-xs text-gray-400 mt-4">
        &copy; <?= date('Y') ?> Pelaporan Kerusakan Fasilitas Sekolah
    </footer>

</body>
</html>

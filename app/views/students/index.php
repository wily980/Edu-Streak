<div class="mt-8 space-y-4">
            <!--Card header start-->
            <div class="bg-white shadow rounded-lg p-4">
<h1 class="text-2xl font-bold font-unbounded">Daftar Siswa</h1>
                <p>Menampilkan daftar siswa yang terdaftar</p>
            </div>
            <!--Card header end-->
 
            <!--Card content start-->
            <div class="bg-white shadow rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">No</th>
                            <th class="py-2 px-4 text-left">Nama</th>
                            <th class="py-2 px-4 text-left">NIS</th>
                            <th class="py-2 px-4 text-left">class</th>
                            <th class="py-2 px-4 text-left">No Telepon</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $index => $student): ?>
                        <tr>
                            <td class="py-2 px-4 text-left">
                                <?= $index + 1 ?>
                            </td>
                            <td class="py-2 px-4 text-left">
                                <?= $student['name'] ?>
                            </td>
                            <td class="py-2 px-4 text-left">
                                <?= $student['nis'] ?>
                            </td>
                            <td class="py-2 px-4 text-left">
                                <?= $student['class'] ?>
                            </td>
                            <td class="py-2 px-4 text-left">
                                <?= $student['phone_number'] ?></td>
                            <td class="py-2 px-4">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="/students/<?= $student['id'] ?>" class="text-green-500">Detail</a>
                                    <a href="/students/<?= $student['id'] ?>/edit" class="text-yellow-500">Edit</a>
                                    <form onsubmit="return comfirm('Apakah Anda yakin ingin menghapus data siswa ini?')" action="/students/<?= $student['id']?>" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-red-500">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach?>
                       
                    </tbody>
                </table>
            </div>
            <!--Card content end-->
        </div>
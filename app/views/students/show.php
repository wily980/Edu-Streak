<div class="mt-8 space-y-4">
            <!--Card header start-->
            <div class="bg-white shadow rounded-lg p-4">
                <h1 class="text-2xl font-bold">Detail Siswa</h1>
                <p>Menampilkan detail siswa yang terdaftar</p>
            </div>
            <!--Card header end-->
 
            <!--Card content start-->
            <div class="bg-white shadow rounded-lg">
                <div class="p-4 grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block font-bold" for="name">Nama</label>
                        <input value="<?= $student['name'] ?>" class= "w-full border rounded-lg py-2 px-4" type="text" name="name" id="name" placeholder="Masukkan Nama" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-bold" for="nis">NIS</label>
                        <input value="<?= $student['nis'] ?>" class=" w-full border rounded-lg py-2 px-4" type="text" name="nis" id="nis" placeholder="Masukkan NIS" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-bold" for="class">class</label>
                        <input value="<?= $student['class'] ?>" class="w-full border rounded-lg py-2 px-4" type="text" name="class" id="class" placeholder="Masukkan class" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-bold" for="phone_number">No Telepon</label>
                        <input value="<?= $student['phone_number'] ?>" class="w-full border rounded-lg py-2 px-4" type="text" name="phone_number" id="phone_number" placeholder="Masukkan no Telepon" readonly>
                    </div>
                    <div class="flex justify-end gap-4 col-span-2">
                        <a href="/students" class="py-2 px-4 bg-gray-100 rounded-lg">Kembali</a>
                    </div>
                </div>
            </div>
            <!--Card content end-->
        </div>
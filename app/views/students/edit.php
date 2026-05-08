        <div class="mt-8 space-y-4">
            <!--Card header start-->
            <div class="bg-white shadow rounded-lg p-4">
                <h1 class="text-2xl font-bold">edit Siswa</h1>
                <p>halaman edit siswa</p>
            </div>
            <!--Card header end-->
 
            <!--Card content start-->
            <div class="bg-white shadow rounded-lg">
 
               <form action="/students/<?= $student['id']?>" method="POST" class="p-4 grid grid-cols-2 gap-4">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="space-y-2">
                    <label for="name" class="block font-bold ">Nama</label>
                    <input value="<?= $student['name']?>" type="text" name="name" id="name" placeholder="Masukkan nama" class="w-full border rounded-lg py-2 px-4">
                </div>
                    <div class="space-y-2">
                    <label for="nis" class="block font-bold ">Nis</label>
                    <input value="<?= $student['nis']?>" type="text" name="nis" id="nis" placeholder="Masukkan nis" class="w-full border rounded-lg py-2 px-4">
                </div>
                    <div class="space-y-2">
                    <label for="class" class="block font-bold ">class</label>
                    <input value="<?= $student['class']?>" type="text" name="class" id="class" placeholder="Masukkan class" class="w-full border rounded-lg py-2 px-4">
                </div>
                    <div class="space-y-2">
                    <label for="phone-number" class="block font-bold ">No Telepon</label>
                    <input value="<?= $student['phone_number']?>" type="text" name="phone_number" id="phone_number" placeholder="Masukkan no telepon" class="w-full border rounded-lg py-2 px-4">
                </div>
                <div class="flex justify-end gap-4 col-span-2">
                    <a href="/students" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
               </form>
 
            </div>
            <!--Card content end-->
        </div>

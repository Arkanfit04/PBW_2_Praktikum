<x-layout>
    <div class="container mt-5">
        <div class="card ">
            <h3 class="card-header">Ini Halaman Buku</h3>
            @csrf
            <div class="card-body">
                <a href="/buku/create" class="btn btn-primary">Tambah data
                </a>
            </div>
            <table class="table table-bordered table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Sampul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bukus as $buku)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->kategori}}</td>
                        <td>
                            <img src="" class="rounded img-fluid" width="100px">
                        </td>
                        <td>
                            <a class="btn btn-warning" href="/buku/{{ $buku->id }}/edit">Ubah</a>
                            <!-- Tombol Hapus dengan Konfirmasi -->
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout>
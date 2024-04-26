<table id="tbl-stok" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Jumlah</th>
            <th class="text-center pe-0">Tools</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stok as $p)
            <tr>
                <td>{{ $i = !isset($i) ? ($i = 1) : ++$i }}</td>
                <td>{{ $p->menu->nama_menu }}</td>
                <td>{{ $p->jumlah }}</td>
                <td class="text-center">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modalFormStok" data-mode="edit"
                        data-id="{{ $p->id }}" data-menu_id="{{ $p->menu_id }}"
                        data-jumlah="{{ $p->jumlah }}">
                        <i class="bi bi-pencil-fill text-success"></i>
                    </button>
                    <form method="post" action="{{ route('stok.destroy', $p->id) }}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn delete-data" data-jumlah="{{ $p->jumlah }}">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

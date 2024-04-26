<table id="tbl-menu" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Jenis</th>
            <th>Nama Menu</th>
            <th>Harga</th>
            <th>Image</th>
            <th>Deskripsi</th>
            <th class="text-center pe-0">Tools</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menu as $p)
            <tr>
                <td>{{ $i = !isset($i) ? ($i = 1) : ++$i }}</td>
                <td>{{ $p->jenis->nama_jenis }}</td>
                <td>{{ $p->nama_menu }}</td>
                <td>{{ $p->harga }}</td>
                @if (request()->route()->getActionMethod() == 'menuPdf')
                    <td><img width="70px" src="data:image/jpeg;base64,{{ $p->imageData }}" alt=""></td>
                @else
                    <td><img width="70px" src="{{ asset('images/' . $p->image) }}" alt=""></td>
                @endif
                <td>{{ $p->deskripsi }}</td>
                <td class="text-center">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modalFormMenu" data-mode="edit"
                        data-id="{{ $p->id }}" data-nama_menu="{{ $p->nama_menu }}"
                        data-jenis_id="{{ $p->jenis_id }}" data-harga="{{ $p->harga }}"
                        data-image="{{ $p->image }}" data-deskripsi="{{ $p->deskripsi }}">
                        <i class="bi bi-pencil-fill text-success"></i>
                    </button>
                    <form method="post" action="{{ route('menu.destroy', $p->id) }}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn delete-data" data-nama_menu="{{ $p->nama_menu }}">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

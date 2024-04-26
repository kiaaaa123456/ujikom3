<table id="tbl-meja" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>No Meja</th>
            <th>Kapasitas</th>
            <th>Status</th>
            <th class="text-center pe-0">Tools</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($meja as $p)
            <tr>
                <td>{{ $i = !isset($i) ? ($i = 1) : ++$i }}</td>
                <td>{{ $p->nomor_meja }}</td>
                <td>{{ $p->kapasitas }}</td>
                <td>{{ $p->status }}</td>
                <td>
                    <button class="btn text-warning" data-bs-toggle="modal" data-bs-target="#modalFormMeja" data-mode="edit"
                        data-id="{{ $p->id }}" data-nomor_meja="{{ $p->nomor_meja }}"
                        data-kapasitas="{{ $p->kapasitas }}" data-status="{{ $p->status }}">
                        <i class="bi bi-pencil-fill text-success"></i>
                    </button>
                    <form method="post" action="{{ route('meja.destroy', $p->id) }}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn text-danger delete-data"
                            data-nomor_meja="{{ $p->nomor_meja }}">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

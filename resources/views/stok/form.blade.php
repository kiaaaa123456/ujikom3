<div class="modal fade" id="modalFormStok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('stok.store') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Nama Menu</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="menu_id" id="menu_id">
                                <option value="" disabled>- Pilih -</option>
                                @foreach ($menu as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_menu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="staticEmail" class="form-label col-sm-4">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="jumlah" value="" name="jumlah">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>

        </div>
    </div>

<div class="modal fade" id="modalFormMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Nama Menu</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama_menu" value="" name="nama_menu">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Nama Jenis</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="jenis_id" id="jenis_id">
                                <option value="">- Pilih -</option>
                                @foreach ($jenis as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="method"></div>
                    <div class="input-group mb-3">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Harga</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" class="form-control" id="harga" placeholder="Harga" name="harga">
                    </div>
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="fileInput" class="col-sm-4 col-form-label">Pilih Gambar</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="image" value="" name="image">
                        </div>
                    </div>
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="exampleFormControlTextarea1" class="form-label col-sm-4">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="deskripsi" value="" name="deskripsi"></textarea>
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

<x-toaha-admin-master>
    <div class="card ">
        <div class="card-header header-elements-inline bg-dark py-1 bg-dark ">
            <h5 class="card-title ">Cities Import</h5>
            <div class="float-right">
                <a href="{{ route('file_upload.index') }}" class="btn btn-sm btn-info float-right" title="Import Us Cities"><i class="fa fa-list"></i> Us Cities List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="execl-file" accept=".xls,.xlsx,.odd">
                                <label class="custom-file-label" for="execl-file">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary excel-upload-btn" type="button" data-errors=0><i class="fa fa-upload"></i> UPLOAD FILE</button>
                                <button class="btn btn-outline-secondary" type="button" data-errors=0 id="clear-btn"><i class="fa fa-sync"></i> CLEAR</button>
                            </div>
                        </div>
                    </div>
    
                    <div class="table-responsive" id="table-area">
                        <div id='my-spreadsheet'></div>
                    </div>
                    <div id="proccesing" class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
                        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="text-center"><i class="icon-spinner9 spinner icon-4x text-muted"></i></p>
                                <h4 class="text-center">Loading....</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/jexcel/jexcel.css') }}" rel="stylesheet">
    @endpush

    @push('js')
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/sweetalert2.min.js') }}"></script>
        <script>
            const swalInit = Swal;
            const ELEMENT_LOADING  = `<div class="removable-tr text-center"><p class="display-4 text-muted"><i class="fa fa-spinner spinner"></i> LOADING...</p></div>`; 
        </script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/xlsx.full.min.js') }}"></script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/jexcel/jexcel.js') }}"></script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/jexcel/jsuites.js') }}"></script>

        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/js/uscities/excel-upload.js?cache='.uniqid()) }}"></script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/js/uscities/excel-create.js?cache='.uniqid()) }}"></script>
    @endpush
</x-toaha-admin-master>
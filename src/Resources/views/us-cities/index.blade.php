<x-toaha-admin-master>
    <div class="card">
        <div class="card-header header-elements-inline bg-dark py-1 bg-dark ">
            <h5 class="card-title ">Cities List</h5>
            <div class="float-right">
                <a href="{{ route('file_upload.import') }}" class="btn btn-sm btn-info float-right" title="Import Us Cities"><i class="fa fa-file-excel"></i> Import Us Cities</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm mb-2">
                <thead>
                    <tr class="bg-dark single-line">
                        <th filter="true">Sl</th>
                        <th filter="true">City</th>
                        <th filter="true">City Ascii</th>
                        <th filter="true">State Name</th>
                        <th filter="true">County Name</th>
                        <th filter="true">Population</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <tr class="bg-light">
                        <th>
                            <button onclick="clearAllFilters()" class="btn  btn-danger btn-sm">
                                <i class="fa fa-times"></i>
                            </button>
                        </th>
                        <th>
                            <input type="text" class="form-control" id="city" onkeyup="index()" placeholder="City">
                        </th>
                        <th>
                            <input type="text" class="form-control" id="city_ascii" onkeyup="index()" placeholder="City Ascii">
                        </th>
                        <th>
                            <input type="text" class="form-control" id="state_name" onkeyup="index()" placeholder="State Name">
                        </th>
                        <th>
                            <input type="text" class="form-control" id="county_name" onkeyup="index()" placeholder="County Name">
                        </th>
                        <th>
                            <input type="text" class="form-control" id="population" onkeyup="index()"placeholder="Population">
                        </th>
                        <th>
                            <select class="form-control" id="numberOfRowsPerPage">
                                <option {{ $rowsPerPage == '5' ? 'selected' : '' }}>5</option>
                                <option {{ $rowsPerPage == '10' ? 'selected' : '' }}>10</option>
                                <option {{ $rowsPerPage == '20' ? 'selected' : '' }}>20</option>
                                <option {{ $rowsPerPage == '30' ? 'selected' : '' }}>30</option>
                                <option {{ $rowsPerPage == '40' ? 'selected' : '' }}>40</option>
                                <option {{ $rowsPerPage == '50' ? 'selected' : '' }}>50</option>
                                <option {{ $rowsPerPage == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
    
            <nav aria-label="Page navigation" class="text-uppercase" id="ponditPagination">
                <ul class="pagination float-right" id="pagesList"></ul>
                <div>Page: <span class="badge badge-primary text-white current-page-number">0</span> of
                    <span class="badge badge-primary text-white total-page-number">0</span> Records: <span
                        class="badge badge-primary text-white total-record-number">0</span>
                </div>
            </nav>
        </div>
    </div>

    <div id="show-city-modal" class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title">City Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td class="font-weight-bold">City :</td>
                                <td><p id="show_city"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">City Ascii :</td>
                                <td><p id="show_city_ascii"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">State ID :</td>
                                <td><p id="show_state_id"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">State Name :</td>
                                <td><p id="show_state_name"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">County Fips :</td>
                                <td><p id="show_county_fips"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">County Name :</td>
                                <td><p id="show_county_name"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Lat :</td>
                                <td><p id="show_lat"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Lng :</td>
                                <td><p id="show_lng"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Population :</td>
                                <td><p id="show_population"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Density :</td>
                                <td><p id="show_density"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Source :</td>
                                <td><p id="show_source"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Military :</td>
                                <td><p id="show_military"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Incorporated :</td>
                                <td><p id="show_incorporated"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Timezone :</td>
                                <td><p id="show_timezone"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Ranking :</td>
                                <td><p id="show_ranking"></p></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Zips :</td>
                                <td><p id="show_zips"></p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/libs/axios.min.js') }}"></script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/js/uscities/paginator.js') }}"></script>
        <script src="{{ asset('vendor/Toaha/UsCitiesAdmin/assets/js/uscities/index.js?cache='.uniqid()) }}"></script>
    @endpush
</x-toaha-admin-master>
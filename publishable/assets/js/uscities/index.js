$(document).ready(function() {
    $(document).on("click", ".city-view-btn", openShowCityModal);
});

function openShowCityModal() {
    const uuid = $(this).data('item-id');

    $.get('/api/uscities/get-city-data?uuid='+uuid ?? 0, (resp)=>{
        $('#show_city').html(resp?.city ?? 'N/A')
        $('#show_city_ascii').html(resp?.city_ascii ?? 'N/A')
        $('#show_state_id').html(resp?.state_id ?? 'N/A')
        $('#show_state_name').html(resp?.state_name ?? 'N/A')
        $('#show_county_fips').html(resp?.county_fips ?? 'N/A')
        $('#show_county_name').html(resp?.county_name ?? 'N/A')
        $('#show_lat').html(resp?.lat ?? 'N/A')
        $('#show_lng').html(resp?.lng ?? 'N/A')
        $('#show_population').html(resp?.population ?? 'N/A')
        $('#show_density').html(resp?.density ?? 'N/A')
        $('#show_source').html(resp?.source ?? 'N/A')
        $('#show_military').html(resp?.military ?? 'N/A')
        $('#show_incorporated').html(resp?.incorporated ?? 'N/A')
        $('#show_timezone').html(resp?.timezone ?? 'N/A')
        $('#show_ranking').html(resp?.ranking ?? 'N/A')
        $('#show_zips').html(resp?.zips ?? 'N/A')
    });
    $(document).find('#show-city-modal').modal('show');
}

const filterableColumns  = ['city', 'city_ascii', 'state_name', 'county_name','population'];

function clearAllFilters() {
    filterableColumns.forEach(function(column) {
        document.querySelector('#' + column).value = '';
    });
    index();
}

window.onload = function() {
    /*Number of rows onchange*/
    let numberOfRowsPerPage = document.querySelector('#numberOfRowsPerPage');
    numberOfRowsPerPage.addEventListener('change', function() {
        index();
    });

    /*Filterable columns onchange*/
    filterableColumns.forEach(function(column) {
        document.getElementById(column).addEventListener('change', function() {
            index();
        })
    })
    index();
}

function index(page_url = null) {
    let numberOfRowsPerPageInput = document.querySelector('#numberOfRowsPerPage');
    let rowsPerPage = numberOfRowsPerPageInput.options[numberOfRowsPerPageInput.selectedIndex].value
    
    let queryString = '';

    queryString += '&rows_per_page=' + rowsPerPage;

    let filterColumns = '';
    let filterColumnsValue = new Array();
    filterableColumns.forEach(function(column) {
        let val = document.querySelector('#' + column).value;
        filterColumnsValue[filterColumnsValue.length] = val;

        filterColumns += column + '|' + val + ';';
    });

    queryString += filterColumns.length > 0 ? '&filterable_columns=' + filterColumns : '';
    
    page_url = page_url || `/api/uscities/get-cities-data?${queryString}`;
    axios.get(page_url)
        .then(res => {
            let numberOfRowsPerPageInput = document.querySelector('#numberOfRowsPerPage');
            let rowsPerPage = numberOfRowsPerPageInput.options[numberOfRowsPerPageInput.selectedIndex].value
            let parentElement = document.querySelector('#tableBody');
            parentElement.innerHTML = '';
            let items = res.data.data;
            if (items.data.length == 0) {
                $("#tableBody").html(`
                    <tr>
                        <td colspan="7" class="text-center">No Data Found</td>
                    </tr>
                    `);
            }
            let sl = res.data.sl + 1;
            items.data.forEach(item => {
                createRowElement(item, sl++)
            });

            let searchKeyWord = '';
            return {
                parent_element: parentElement,
                url           : `/api/uscities/get-cities-data`,
                current_page  : items.current_page,
                last_page     : items.last_page,
                total_rows    : items.total,
                keyword       : searchKeyWord,
                row_per_page  : rowsPerPage,
                pages         : res.data.pages,
                query_string  : queryString
            };
        })
        .then(data => {
            makePagination(data);
        })
        .catch(err => console.log(err))

}

function createRowElement(data, sl) {

    let tr = `
                <tr class="bg-light fabricSelect">
                    <td>${sl}</td>
                    <td>${ data.city }</td>
                    <td>${ data.city_ascii }</td>
                    <td>${ data.state_name }</td>
                    <td>${ data.county_name }</td>
                    <td>${data.population }</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="#" id="" data-item-id="${data.uuid}" class="city-view-btn btn btn-outline bg-success btn-icon text-success btn-sm border-success border-2 rounded-round legitRipple mr-1" data-popup="tooltip" title="" data-original-title="ViewFabricBookingItems">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
    `;

    $("#tableBody").append(tr);

}
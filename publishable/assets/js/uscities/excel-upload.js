(($)=>{
    $(document).ready(()=>{
        $(document).on('change', '#execl-file', loadXl);
    });
})(jQuery)

const loadXl = (event) => {
    $('.excel-upload-btn').attr('id', 'save-btn');
    $(event.target).prop('disabled', true);
    $("#my-spreadsheet").addClass("d-none");
    $("#table-area").append(ELEMENT_LOADING);
    const fileReader = new FileReader();
    fileReader.readAsBinaryString(document.querySelector("#execl-file").files[0]);
    fileReader.onload = (event) => {
        const data = event.target.result;
        const workbook = XLSX.read(data, { type: "binary" });
        const rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[workbook.SheetNames[0]]);
        tableOutput(rowObject);

    }
    $(event.target).prop('disabled', false);
}

const tableOutput = rows => {
    jxlTable.setData([[]]);
    let   data          = [];
    														
    for (const row of rows) {
        const new_row = {
            0: String(row['city'])?.trim(),
            1: String(row['city_ascii'])?.trim(),
            2: String(row['state_id'])?.trim(),
            3: String(row['state_name'])?.trim(),
            4: String(row['county_fips'])?.trim(),
            5: String(row['county_name'])?.trim(),
            6: String(row['lat'])?.trim(),
            7: String(row['lng'])?.trim(),
            8: String(row['population'])?.trim(),
            9: String(row['density'])?.trim(),
           10: String(row['source'])?.trim(),
           11: String(row['military'])?.trim(),
           12: String(row['incorporated'])?.trim(),
           13: String(row['timezone'])?.trim(),
           14: String(row['ranking'])?.trim(),
           15: String(row['zips'])?.trim(),
        };
        data.push(new_row);
    }
    jxlTable.setData(data.length > 0 ? data : [[]]);
    $('.removable-tr').remove();
    $("#my-spreadsheet").removeClass("d-none");

}

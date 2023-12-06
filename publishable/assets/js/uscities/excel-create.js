(function ($) {
  $(document).ready(function () {
    $(document).on('click', '#save-btn', saveData);
    $(document).on('click', '#clear-btn', clearTableData);
    $(document).on('click', '#upload-btn', clickExeclUpload);
    $(document).on('drop', '.content-wrapper', dropHandler);
    $(document).on('dragover', '.content-wrapper', dragOverHandler);
  });
})(jQuery);

const clickExeclUpload = () => {
  document.getElementById('execl-file').click();
}

const jxlTable = jspreadsheet(document.getElementById('my-spreadsheet'), {
  contextMenu: false,
  data: [[], [], [], [], []],
  colHeaders: ['City', 'City Ascii', 'State Id', 'State Name', 'County Fips', 'County Name', 'Lat', 'Lng', 'Population', 'Density', 'Source', 'Military', 'Incorporated', 'Timezone', 'Ranking', 'Zips'],
  colWidths: [120, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100],
  columns: [{}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}],
});

const saveData = async () => {
  const this_el = $('.excel-upload-btn');
  const allData = jxlTable.getJson();
  if (dataFormat(allData) === undefined) { return; }

  let chunkedArray = chunkArray(dataFormat(allData), 50);
  let checkLength = 0;
      for (const data of chunkedArray) {
        checkLength += 1;

        await $.ajax({
          url: `/api/uscities/fie-upload`,
          method: 'POST',
          headers     : {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: { data: data },
          beforeSend: function () {
            $(this_el).html(`<i class="icon-spinner9 spinner"></i> UPLOADING...`);
            $(this_el).prop('disabled', true);
          },
          success: (res) => {
            if(checkLength == chunkedArray.length){
                swalInit.fire({
                    title   : res.msg,
                    type    : "success"
                }).then(()=>{
                    window.location.href='/uscities/file-upload';
                });
            }
          },
          error: (err) => {
            swalInit.fire({
              title: err.responseJSON.msg ?? "Something Went Wrong",
              type: "error",
            });
          },
          complete: function () {
            if(checkLength == chunkedArray.length){
              $(this_el).prop('disabled', false);
              $(this_el).html(`<i class="fa fa-upload"></i> UPLOAD GATE-IN`);
            }
          },
        });
      }

}
const dataFormat = (allData) => {
  let arr = [];
  for (const data of allData) {
    let item_data = {};
    item_data.city        = data[0];
    item_data.city_ascii  = data[1];
    item_data.state_id    = data[2];
    item_data.state_name  = data[3];
    item_data.county_fips = data[4];
    item_data.county_name = data[5];
    item_data.lat         = data[6];
    item_data.lng         = data[7];
    item_data.population  = data[8];
    item_data.density     = data[9];
    item_data.source      = data[10];
    item_data.military    = data[11];
    item_data.incorporated= data[12];
    item_data.timezone    = data[13];
    item_data.ranking     = data[14];
    item_data.zips        = data[15];
    arr.push(item_data)
  }
  return arr;
}

const clearData = () => jxlTable.setData([[]]);

const dropHandler = (ev) => {
  ev.preventDefault();
  const fileTrans = ev.originalEvent.dataTransfer;
  if (fileTrans.items) {
    for (let i = 0; i < fileTrans.items.length; i++) {
      if (fileTrans.items[i].kind === "file") {
        const file = fileTrans.items[i].getAsFile();
        let container = new DataTransfer();
        container.items.add(file);
        document.querySelector('#execl-file').files = container.files;
        $('#execl-file').trigger('change');
      }
    }
  } else {
    for (let i = 0; i < fileTrans.files.length; i++) {
      console.log(
        `… file[${i}].name = ${fileTrans.files[i].name}`
      );
    }
  }
}

const dragOverHandler = (ev) => {
  ev.preventDefault();
}

function clearTableData() {
  jxlTable.setData([[], [], [], [], []]);
  $('.removable-tr').remove();
  $("#my-spreadsheet").removeClass("d-none");
  $('#execl-file').val(null);
  $('.custom-file-label').html("Choose file");
}

function chunkArray(array, chunkSize) {
  let result = [];
  for (let i = 0; i < array.length; i += chunkSize) {
      result.push(array.slice(i, i + chunkSize));
  }
  return result;
}
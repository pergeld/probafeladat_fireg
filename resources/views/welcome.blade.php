<x-app>
<h2 style="margin-top: 12px;" class="alert alert-success">Tűzoltó készülékek</h2><br>
<div class="row">
    <div class="col-12 text-right">
        <a href="javascript:void(0)" class="btn btn-danger mb-3" id="create-new-appliance" onclick="addAppliance()">Új hozzáadása</a>
    </div>
</div>
<div class="row" style="clear: both;margin-top: 18px;">
    <div class="col-12">
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Gyári szám</th>
                <th>Telephely</th>
                <th>Készenléti helye</th>
                <th>Típusa</th>
                <th>Gyártás dátuma</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($appliances as $appliance)
            <tr id="row_{{ $appliance->id }}">
               <td>{{ $appliance->id  }}</td>
               <td>{{ $appliance->serial_number }}</td>
               <td>{{ $appliance->site }}</td>
               <td>{{ $appliance->location  }}</td>
               <td>{{ $appliance->type }}</td>
               <td>{{ $appliance->production_date }}</td>
               <td>
                <a
                    href="javascript:void(0)"
                    data-id="{{ $appliance->id }}"
                    onclick="editAppliance(event.target)"
                    class="btn btn-info"
                >Szerkesztés</a></td>
               <td>
                <a
                    href="javascript:void(0)"
                    data-id="{{ $appliance->id }}"
                    onclick="deleteAppliance(event.target)"
                    class="btn btn-danger"
                >Törlés</a></td>
                <td><a href="/controls/{{ $appliance->id }}" class="btn btn-primary">Karbantartások</a></td>
            </tr>
            @endforeach
        </tbody>
      </table>
   </div>
</div>
<div class="row">
    <div class="col-12 text-right">
        <a href="javascript:void(0)" onclick="printPDF()" class="btn btn-primary">Nyomtatás</a>
    </div>
</div>

{{-- model --}}
<div class="modal fade" id="appliance-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form name="applianceForm" class="form-horizontal">
               <input type="hidden" name="appliance_id" id="appliance_id">
               {{-- Telephely : site --}}
                <div class="form-group">
                    <label for="site" class="col-sm-2">Telephely</label>
                    <div class="col-sm-12">
                        <input
                            type="text"
                            id="site"
                            name="site"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Készenléti helye : location --}}
                <div class="form-group">
                    <label for="location" class="col-sm-2">Készenléti helye</label>
                    <div class="col-sm-12">
                        <input
                            type="text"
                            id="location"
                            name="location"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Készülék típusa : type --}}
                <div class="form-group">
                    <label for="type" class="col-sm-2">Készülék típusa</label>
                    <div class="col-sm-12">
                        <input
                            type="text"
                            id="type"
                            name="type"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Gyári száma : serial_number --}}
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2">Gyári száma</label>
                    <div class="col-sm-12">
                        <input
                            type="text"
                            id="serial_number"
                            name="serial_number"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Gyártás dátuma : production_date --}}
                <div class="form-group">
                    <label for="production_date" class="col-sm-2">Gyártás dátuma</label>
                    <div class="col-sm-12">
                        <input
                            type="date"
                            id="production_date"
                            name="production_date"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Megjegyzés : description --}}
                <div class="form-group">
                    <label class="col-sm-2">Megjegyzés</label>
                    <div class="col-sm-12">
                        <textarea
                            id="description"
                            name="description"
                            class="form-control"
                            rows="7"
                        ></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="createAppliance()">Mentés</button>
        </div>
    </div>
  </div>
</div>
{{-- model end --}}


<script>
function addAppliance() {
  $("#appliance_id").val('');
  $('#appliance-modal').modal('show');
}

function editAppliance(event) {
  var id  = $(event).data("id");
  let _url = `/appliances/${id}/edit`;
  
  $.ajax({
    url: _url,
    type: "GET",
    success: function(response) {
        if(response) {
          $("#location").val(response.location);
          $("#site").val(response.site);
          $("#type").val(response.type);
          $("#serial_number").val(response.serial_number);
          $("#production_date").val(response.production_date);
          $("#description").val(response.description);
          $("#appliance_id").val(response.id);
          $('#appliance-modal').modal('show');
        }
    }
  });
}

function createAppliance() {
  var location = $('#location').val();
  var site = $('#site').val();
  var type = $('#type').val();
  var serial_number = $('#serial_number').val();
  var production_date = $('#production_date').val();
  var description = $('#description').val();
  var id = $('#appliance_id').val();

  let _url     = `/appliances`;
  let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: _url,
      type: "POST",
      data: {
        id: id,
        site: site,
        location: location,
        type: type,
        serial_number: serial_number,
        production_date: production_date,
        description: description,
        _token: _token
      },
      success: function(response) {
          if(response.code == 200) {
            if(id != ""){
              $("#row_"+id+" td:nth-child(2)").html(response.data.serial_number);
              $("#row_"+id+" td:nth-child(3)").html(response.data.site);
              $("#row_"+id+" td:nth-child(4)").html(response.data.location);
              $("#row_"+id+" td:nth-child(5)").html(response.data.type);
              $("#row_"+id+" td:nth-child(6)").html(response.data.production_date);
            } else {
              $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.serial_number+'</td><td>'+response.data.site+'</td><td>'+response.data.location+'</td><td>'+response.data.type+'</td><td>'+response.data.production_date+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editAppliance(event.target)" class="btn btn-info">Szerkesztés</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteAppliance(event.target)">Törlés</a></td><td><a href="/controls/{{ $appliance->id }}" class="btn btn-primary">Karbantartások</a></td></tr>');
            }
            $('#serial_number').val('');
            $('#site').val('');
            $('#location').val('');
            $('#type').val('');
            $('#production_date').val('');
            $('#appliance-modal').modal('hide');
          }
      }
    });
}



function deleteAppliance(event) {
  var id  = $(event).data("id");
  let _url = `/appliances/${id}`;
  let _token   = $('meta[name="csrf-token"]').attr('content');
    
  $.ajax({
    url: _url,
    type: 'DELETE',
    data: {
      _token: _token
    },
    success: function(response) {
      $("#row_"+id).remove();
    }
  });
}

function printPDF(){
  var req = new XMLHttpRequest();
  req.open('GET', '/pdf/create', true);
  req.responseType = "blob";

  req.onload = function (event) {
    var blob = req.response;
    var link=document.createElement('a');
    link.href=window.URL.createObjectURL(blob);
    link.target = '_blank';
    link.download="probafeladat.pdf";
    link.click();
    window.open(link);
  };

  req.send();
  
}


</script>
</x-app>
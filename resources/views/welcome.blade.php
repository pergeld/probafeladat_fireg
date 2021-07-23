<x-app>
<h2 class="title_text">Tűzoltó készülékek</h2><br>
<div class="row">
    <div class="col-12 text-right">
        <a href="javascript:void(0)" class="primary_btn add_btn" id="create-new-appliance" onclick="addAppliance()"><i class="fas fa-plus"></i> Új hozzáadása</a>
    </div>
</div>
<div class="row">
    <div class="main_div">
      <table class="main_table">
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
                    class="second_btn edit_btn"
                >Szerkesztés</a></td>
               <td>
                <a
                    href="javascript:void(0)"
                    data-id="{{ $appliance->id }}"
                    onclick="deleteAppliance(event.target)"
                    class="second_btn delete_btn"
                >Törlés</a></td>
                <td><a href="/controls/{{ $appliance->id }}" class="second_btn control_btn">Karbantartások</a></td>
            </tr>
            @endforeach
        </tbody>
      </table>
   </div>
</div>
<div class="row">
    <div class="col-12 text-right">
        <a href="javascript:void(0)" onclick="printPDF()" class="primary_btn print_btn"><i class="fas fa-print"></i> Nyomtatás</a>
    </div>
</div>

{{-- model --}}
<div class="modal fade" id="appliance-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body form_elements">
            <form name="applianceForm">
               <input type="hidden" name="appliance_id" id="appliance_id">
               {{-- Telephely : site --}}
                <div class="form_element">
                    <label for="site" class="label_element">Telephely</label>
                    <div class="input_div">
                        <input
                            type="text"
                            id="site"
                            name="site"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Készenléti helye : location --}}
                <div class="form_element">
                    <label for="location" class="label_element">Készenléti helye</label>
                    <div class="input_div">
                        <input
                            type="text"
                            id="location"
                            name="location"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Készülék típusa : type --}}
                <div class="form_element">
                    <label for="type" class="label_element">Készülék típusa</label>
                    <div class="input_div">
                        <input
                            type="text"
                            id="type"
                            name="type"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Gyári száma : serial_number --}}
                <div class="form_element">
                    <label for="serial_number" class="label_element">Gyári száma</label>
                    <div class="input_div">
                        <input
                            type="text"
                            id="serial_number"
                            name="serial_number"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Gyártás dátuma : production_date --}}
                <div class="form_element">
                    <label for="production_date" class="label_element">Gyártás dátuma</label>
                    <div class="input_div">
                        <input
                            type="date"
                            id="production_date"
                            name="production_date"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Megjegyzés : description --}}
                <div class="form_element">
                    <label class="label_element">Megjegyzés</label>
                    <div class="input_div">
                        <textarea
                            id="description"
                            name="description"
                            class="input_element"
                            rows="7"
                        ></textarea>
                    </div>
                </div>


                {{-- Többszörösítés : multiplication --}}
                <div class="form_element">
                    <label for="multiplication" class="label_element">Többszörösítés</label>
                    <div class="input_div">
                        <select name="multiplication" id="multiplication" class="input_element">
                          <option value="1" selected>-</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="second_btn control_btn" onclick="createAppliance()">Mentés</button>
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
  var multiplication = $('#multiplication').val();
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
        multiplication: multiplication,
        _token: _token
      },
      success: function(response) {
          if(response.code == 200) {
            if(id != ""){
              //szerkesztés
              $("#row_"+id+" td:nth-child(2)").html(response.data.serial_number);
              $("#row_"+id+" td:nth-child(3)").html(response.data.site);
              $("#row_"+id+" td:nth-child(4)").html(response.data.location);
              $("#row_"+id+" td:nth-child(5)").html(response.data.type);
              $("#row_"+id+" td:nth-child(6)").html(response.data.production_date);
            } else {
              //új hozzáadása
              for (let i = 0; i < multiplication; i++) {
                var azon = (response.data.id - multiplication + 1) + i;
                $('table tbody').prepend('<tr id="row_'+azon+'"><td>'+azon+'</td><td>'+response.data.serial_number+'</td><td>'+response.data.site+'</td><td>'+response.data.location+'</td><td>'+response.data.type+'</td><td>'+response.data.production_date+'</td><td><a href="javascript:void(0)" data-id="'+azon+'" onclick="editAppliance(event.target)" class="second_btn edit_btn">Szerkesztés</a></td><td><a href="javascript:void(0)" data-id="'+azon+'" class="second_btn delete_btn" onclick="deleteAppliance(event.target)">Törlés</a></td><td><a href="/controls/'+azon+'" class="second_btn control_btn">Karbantartások</a></td></tr>');
              }
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
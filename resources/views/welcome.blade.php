<x-app>
<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-body">
            <slot name="body">
              
            </slot>
          </div>

        </div>
      </div>
    </div>
  </transition>
</script>

<div class="row">
  <h2 class="title_text">Tűzoltó készülék üzemeltetési napló</h2>
</div>
<div class="row">
    <div class="add_btn_container">
        <a href="javascript:void(0)" class="add_btn" id="create-new-appliance" onclick="addAppliance()"><i class="fas fa-plus"></i> Új tűzoltó készülék</a>
    </div>
</div>
<div id="app" class="row">
    <div class="main_div">
      <table class="main_table">
        <thead>
            <tr>
                <th></th>
                <th colspan="4">Tűzoltó készülék</th>
                <th>Gyártás</th>
                <th colspan="5">Karbantartás időpontja</th>
                <th>Eszköz megj.</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th>Gyári szám</th>
                <th>Készenléti helye</th>
                <th>Típusa</th>
                <th></th>
                <th>1. karb</th>
                <th>2. karb</th>
                <th>3. karb</th>
                <th>4. karb</th>
                <th>5. karb</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($appliances as $appliance)
            <tr id="row_{{ $appliance->id }}">
              <td>{{ $appliance->id }}</td>
              <td>
                <div class="btn_div extinguisher_div">
                <a class="second_btn extinguisher_btn" id="show-modal" @click="showModal = true"><i class="fas fa-fire-extinguisher"></i></a>
  <!-- use the modal component, pass in the prop -->
  <modal v-show="showModal" @close="showModal = false">
    <template v-slot:body>

        <div class="modal_title_text">
            <h4 class="title_text">Tűzoltó készülék hozzáadása</h4>
            <div class="exit_btn_div">
              <a class="exit_btn" @click="showModal = false"><i class="fas fa-times"></i></a>
            </div>
        </div>
        <div class="modal-body form_elements">
        <form action="/storecontrol" method="post">
          @csrf
               <input type="hidden" name="appliance_id" id="appliance_id" value="{{$appliance->id}}">

               {{-- Karbantartás : maintenance --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="maintenance" class="label_element">Karbantartás</label>
                 </div>
                 <div class="col-75">
                   <input type="text" id="maintenance" name="maintenance" class="input_element" placeholder="karbantartás" required>
                 </div>
               </div>

               {{-- Karbantartás dátuma : date --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="date" class="label_element">Karbantartás dátuma</label>
                 </div>
                 <div class="col-75">
                   <input type="date" id="date" name="date" class="input_element" required>
                 </div>
               </div>

               {{-- Megjegyzés : description --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="description" class="label_element">Megjegyzés</label>
                 </div>
                 <div class="col-75">
                   <textarea name="description" id="description" rows="4" class="input_element" placeholder="megjegyzés"></textarea>
                 </div>
               </div>

               <div class="modal-footer">
                  <button type="submit" class="save_btn"><i class="fas fa-check"></i> Mentés</button>
              </div>

            </form>
        </div>
        
    </template>
  </modal>
</div>
        {{-- end modal --}}
                </div>
                <div class="btn_div wrench_div">
                <a href="/controls/{{ $appliance->id }}" class="second_btn wrench_btn"><i class="fas fa-wrench"></i></a>
                </div>
              </td>
              <td>{{ $appliance->serial_number }}</td>
              <td>{{ $appliance->location }}</td>
              <td>{{ $appliance->type }}</td>
              <td>{{ $appliance->production_date }}</td>
              @php
                $counter = 0; 
              @endphp
              @foreach($appliance->controls as $control)
                <td>{{ $control->maintenance }}</td>
                @php
                $counter = $counter + 1;
                @endphp
              @endforeach
              @for($i = 0; $i < 5-$counter; $i++)
              <td></td>
              @endfor
              <td>{{ $appliance->description }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
   </div>
</div>
<div class="row">
    <div class="print_btn_div text-right">
        <a href="javascript:void(0)" onclick="printPDF()" class="print_btn"><i class="fas fa-print"></i> Dokumentum készítése</a>
    </div>
</div>


{{-- tuzoltokeszulek modal --}}
<div class="modal fade" id="appliance-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal_title_text">
            <h4 class="title_text">Tűzoltó készülék hozzáadása</h4>
        </div>
        <div class="modal-body form_elements">
            <form name="applianceForm">
               <input type="hidden" name="appliance_id" id="appliance_id">

               {{-- Telephely : site --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="site" class="label_element">Telephely</label>
                 </div>
                 <div class="col-75">
                   <input type="text" id="site" name="site" class="input_element" placeholder="telephely" required>
                 </div>
               </div>

               {{-- Készenléti helye : location --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="location" class="label_element">Készenléti helye</label>
                 </div>
                 <div class="col-75">
                   <input type="text" id="location" name="location" class="input_element" placeholder="készenléti helye" required>
                 </div>
               </div>

               {{-- Készülék típusa : type --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="type" class="label_element">Készülék típusa</label>
                 </div>
                 <div class="col-75">
                   <input type="text" id="type" name="type" class="input_element" placeholder="készülék típusa" required>
                 </div>
               </div>

               {{-- Gyári száma : serial_number --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="serial_number" class="label_element">Gyári száma</label>
                 </div>
                 <div class="col-75">
                   <input type="text" id="serial_number" name="serial_number" class="input_element" placeholder="gyári száma" required>
                 </div>
               </div>

               {{-- Gyártás dátuma : production_date --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="production_date" class="label_element">Gyártás dátuma</label>
                 </div>
                 <div class="col-75">
                   <input type="date" id="production_date" name="production_date" class="input_element" required>
                 </div>
               </div>

               {{-- Megjegyzés : description --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="descriptionb" class="label_element">Megjegyzés</label>
                 </div>
                 <div class="col-75">
                   <textarea name="descriptionb" id="descriptionb" rows="4" class="input_element" placeholder="megjegyzés"></textarea>
                 </div>
               </div>

               {{-- Többszörösítés : multiplication --}}
               <div class="form_element">
                 <div class="col-25">
                   <label for="multiplication" class="label_element">Többszörösítés</label>
                 </div>
                 <div class="col-75">
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
            <button type="button" class="save_btn" onclick="createAppliance()"><i class="fas fa-check"></i> Mentés</button>
        </div>
    </div>
  </div>
</div>
{{-- tuzoltokeszulek modal vege --}}


<script>
  const app = Vue.createApp({
  data() {
    return {
      showModal: false
    }
  }
})

app.component("modal", {
  template: "#modal-template",
})

app.mount('#app')


function addAppliance() {
  $("#appliance_id").val('');
  $('#appliance-modal').modal('show');
}
/*
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
*/
function createAppliance() {
  var location = $('#location').val();
  var site = $('#site').val();
  var type = $('#type').val();
  var serial_number = $('#serial_number').val();
  var production_date = $('#production_date').val();
  var description = $('#descriptionb').val();
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
              $("#row_"+id+" td:nth-child(3)").html(response.data.location);
              $("#row_"+id+" td:nth-child(4)").html(response.data.type);
              $("#row_"+id+" td:nth-child(5)").html(response.data.production_date);
              $("#row_"+id+" td:nth-child(6)").html(response.data.description);
            } else {
              //új hozzáadása
              for (let i = 0; i < multiplication; i++) {
                var azon = (response.data.id - multiplication + 1) + i;
                $('table tbody').prepend('<tr id="row_'+azon+'"><td>'+azon+'</td><td><div class="btn_div extinguisher_div"><a class="second_btn extinguisher_btn" id="show-modal" @click="showModal = true"><i class="fas fa-fire-extinguisher"></i></a></div><div class="btn_div wrench_div"><a href="/controls/'+azon+'" class="second_btn wrench_btn"><i class="fas fa-wrench"></i></a></div></td><td>'+response.data.serial_number+'</td><td>'+response.data.location+'</td><td>'+response.data.type+'</td><td>'+response.data.production_date+'</td><td></td><td></td><td></td><td></td><td></td><td>'+response.data.description+'</td></tr>');
              }
            }
            $('#serial_number').val('');
            $('#site').val('');
            $('#location').val('');
            $('#type').val('');
            $('#production_date').val('');
            $('#description').val('');
            $('#appliance-modal').modal('hide');
          }
      }
    });
}


/*
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
*/
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
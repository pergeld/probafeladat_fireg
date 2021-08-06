<x-app>
<h2 class="title_text">{{ $id }} azonosító számú tűzoltókészülék karbantartásai</h2><br>
<div class="row">
    <div class="main_div">
      <table class="main_table">
        <thead>
            <tr>
                <th>#</th>
                <th>Karbantartás</th>
                <th>Dátum</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($controls as $control)
            <tr id="row_{{ $control->id }}">
               <td>{{ $control->id  }}</td>
               <td>{{ $control->maintenance }}</td>
               <td>{{ $control->date }}</td>
               <td>
                  <div class="btn_div">
                    <a
                        href="javascript:void(0)"
                        data-id="{{ $control->id }}"
                        onclick="editControl(event.target)"
                        class="second_btn extinguisher_btn"
                    ><i class="fas fa-edit"></i></a>
                  </div>
               </td>
               <td>
                <div class="btn_div">
                  <a
                      href="javascript:void(0)"
                      data-id="{{ $control->id }}"
                      onclick="deleteControl(event.target)"
                      class="second_btn extinguisher_btn"
                  ><i class="fas fa-trash-alt"></i></a>
                </div>
              </td>
            </tr>
            @endforeach
        </tbody>
      </table>
   </div>
</div>

{{-- model --}}
<div class="modal fade" id="control-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Új karbantartás hozzáadása</h4>
        </div>
        <div class="modal-body form_elements">
            <form name="controlForm">
               <input type="hidden" name="control_id" id="control_id">
               <input type="hidden" name="appliance_id" id="appliance_id" value="{{$id}}">
               {{-- Karbantartás : maintenance --}}
                <div class="form_element">
                    <div class="col-25">
                      <label for="maintenance" class="label_element">Karbantartás</label>
                    </div>
                    <div class="col-75">
                        <input
                            type="text"
                            id="maintenance"
                            name="maintenance"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                {{-- Dátum : date --}}
                <div class="form_element">
                    <div class="col-25">
                      <label for="date" class="label_element">Karbantartás dátuma</label>
                    </div>
                    <div class="col-75">
                        <input
                            type="date"
                            id="date"
                            name="date"
                            class="input_element"
                            required
                        >
                    </div>
                </div>

                <div class="form_element">
                    <div class="col-25">
                      <label class="label_element">Megjegyzés</label>
                    </div>
                    <div class="col-75">
                        <textarea
                            id="description"
                            name="description"
                            class="input_element"
                            rows="7"
                        ></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="save_btn" onclick="createControl()">Mentés</button>
        </div>
    </div>
  </div>
</div>
{{-- model end --}}


<script>
  function addControl() {
    $("#control_id").val('');
    $('#control-modal').modal('show');
  }

  function editControl(event) {
    var id  = $(event).data("id");
    let _url = `/controls/${id}/edit`;
    
    $.ajax({
      url: _url,
      type: "GET",
      success: function(response) {
          if(response) {
            $("#maintenance").val(response.maintenance);
            $("#date").val(response.date);
            $("#description").val(response.description);
            $("#control_id").val(response.id);
            $('#control-modal').modal('show');
          }
      }
    });
  }

  function createControl() {
    var maintenance = $('#maintenance').val();
    var date = $('#date').val();
    var appliance_id = $('#appliance_id').val();
    var description = $('#description').val();
    var id = $('#control_id').val();

    let _url     = `/controls`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: _url,
        type: "POST",
        data: {
          id: id,
          maintenance: maintenance,
          date: date,
          appliance_id: appliance_id,
          description: description,
          _token: _token
        },
        success: function(response) {
            if(response.code == 200) {
              if(id != ""){
                $("#row_"+id+" td:nth-child(2)").html(response.data.maintenance);
                $("#row_"+id+" td:nth-child(3)").html(response.data.date);
              }
              $('#maintenance').val('');
              $('#date').val('');

              $('#control-modal').modal('hide');
            }
        }
      });
  }



  function deleteControl(event) {
    var id  = $(event).data("id");
    let _url = `/controls/${id}`;
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

</script>
</x-app>
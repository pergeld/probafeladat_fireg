<x-app>
<h2 style="margin-top: 12px;" class="alert alert-success">{{ $id }} azonosító számú tűzoltókészülék karbantartásai</h2><br>
<div class="row">
    <div class="col-12 text-right">
        <a href="javascript:void(0)" class="btn btn-danger mb-3" id="create-new-control" onclick="addControl()">Új hozzáadása</a>
    </div>
</div>
<div class="row" style="clear: both;margin-top: 18px;">
    <div class="col-12">
      <table class="table table-striped table-bordered">
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
                <a
                    href="javascript:void(0)"
                    data-id="{{ $control->id }}"
                    onclick="editAppliance(event.target)"
                    class="btn btn-info"
                >Szerkesztés</a></td>
               <td>
                <a
                    href="javascript:void(0)"
                    data-id="{{ $control->id }}"
                    onclick="deleteControl(event.target)"
                    class="btn btn-danger"
                >Törlés</a></td>
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
        <div class="modal-body">
            <form name="controlForm" class="form-horizontal">
               <input type="hidden" name="control_id" id="control_id">
               <input type="hidden" name="appliance_id" id="appliance_id" value="{{$id}}">
               {{-- Karbantartás : maintenance --}}
                <div class="form-group">
                    <label for="maintenance" class="col-sm-2">Karbantartás</label>
                    <div class="col-sm-12">
                        <input
                            type="text"
                            id="maintenance"
                            name="maintenance"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                {{-- Dátum : date --}}
                <div class="form-group">
                    <label for="date" class="col-sm-2">Karbantartás dátuma</label>
                    <div class="col-sm-12">
                        <input
                            type="date"
                            id="date"
                            name="date"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

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
            <button type="button" class="btn btn-primary" onclick="createControl()">Mentés</button>
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
              } else {
                $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.maintenance+'</td><td>'+response.data.date+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editControl(event.target)" class="btn btn-info">Szerkesztés</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteControl(event.target)">Törlés</a></td></tr>');
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
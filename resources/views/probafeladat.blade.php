<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
</style>  
<body>
	<div class="container">
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
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
</body>
</html>
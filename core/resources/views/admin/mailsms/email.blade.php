@extends('admin')

@section('body')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-envelope-o"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{url()->current()}}">E-Mail  Settings</a></li>
        </ul>
    </div>


    <div class="row">
		<div class="col-md-12">
			<div class="tile">
				<h3 class="tile-title ">Email Template</h3>
				<div class="tile-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th> # </th>
								<th> CODE </th>
								<th> DESCRIPTION </th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td> 1 </td>
								<td> <pre>&#123;&#123;message&#125;&#125;</pre> </td>
								<td> Details Text From Script</td>
							</tr>
							<tr>
								<td> 2 </td>
								<td> <pre>&#123;&#123;name&#125;&#125;</pre> </td>
								<td> Users Name. Will Pull From Database and Use in EMAIL text</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<h3 class="tile-title ">Email  Template</h3>
				<div class="tile-body">
					<form role="form" method="POST" action="{{route('template.update')}}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group ">
								<label><strong>Email Sent Form</strong></label>
								<input type="email" name="esender" class="form-control form-control-lg" value="{{$temp->esender}}">
							</div>

							<div class="form-group">
								<label><strong>Email Message</strong></label>
								<textarea class="form-control form-control-lg" name="emessage" id="emessage" rows="10">
									{{$temp->emessage}}
								</textarea>
							</div>
						</div>
						<div class="form-group form-actions">
							<button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



@endsection

@section('script')
	<script src="{{asset('assets/admin/js/nicEdit-latest.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
        new nicEditor().panelInstance('emessage');
	</script>
@stop

@extends('master')
@section('title', 'Manage Blog')
@section('main')
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
				Manage Blog
				@if($superadmin!=0)
				<a class="pull-right btn btn-success" href="/add-blog" data-filter="*">Add Blog</a>
				@endif
            </h3>
        </div>
        <!-- page heading end-->
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Select Filter
            </header>
            <div class="panel-body">
				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif
                <form class="" method="get" action="/manage-blog">
                    <div class="col-md-3 form-group">
						<label>Blog Name</label>
						<input type="text" class="form-control" placeholder="Blog Name" name="name" value="<?php echo isset($_REQUEST['name'])?$_REQUEST['name']:'' ?>">
					</div>
					<div class="col-md-2 form-group">
						<label>&nbsp;</label>
						<button type="submit" class="btn-primary form-control">Search</button>
					</div>
                </form>
            </div>
        </section>
        </div>
        </div>
		<!-- table data row start -->
		<div class="row">
		<div class="col-lg-12">
        <section class="panel">
			<header class="panel-heading">
				Total {{$GetBlogData->total()}} Record Found
			</header>
			<div class="panel-body">
				<div class="adv-table">
					<span style="float:right;">{{ $GetBlogData->appends($searchItem)->links() }}</span>
					<table class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>Actions</th>
								<th>Title</th>
								<th>Image</th>
								<th>Content Text</th>
								<th>Created Date</th>
								<th>Update Date</th>
								<th>Status</th>
								<th>Created By</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($GetBlogData))
						@foreach($GetBlogData as $row)
							<tr class="gradeX">
								<td>
								@if($superadmin!=0)
								<a href='{{ url("/edit-blog/$row->blogid") }}'><i class="fa fa-edit"></i> Edit</a><br />
								<a href='{{ url("/delete-blog/$row->blogid") }}'><i class="fa fa-edit"></i> Delete</a>
								@else
								Edit<br />
								Delete
								@endif
								</td>
								<td style="word-break: break-all;">{{ ucfirst($row->title) }}</td>
								<td><img width="170" height="120" src="http://blogpost.dev{{ $UploadPath }}/{{ $row->blogimage }}" /></td>
								<td>{{ $row->content_text }}</td>
								<td>{{ $row->create_date }}</td>
								<td>{{ $row->update_date }}</td>
								<td>@if($row->status==1) ACTIVE @else DEACTIVE @endif</td>
								<td>{{ $row->admin_user_name }}</td>
							</tr>
						@endforeach
						@endif
						</tbody>
						<tfoot>
							<tr>
								<th>Actions</th>
								<th>Title</th>
								<th>Image</th>
								<th>Content Text</th>
								<th>Created Date</th>
								<th>Update Date</th>
								<th>Status</th>
								<th>Created By</th>
							</tr>
						</tfoot>
					</table>
					<span style="float:right;">{{ $GetBlogData->appends($searchItem)->links() }}</span>
				</div>
			</div>
        </section>
        </div>
        </div>
		<!-- table data row end -->
        <!-- page end-->
        </section>
        <!--body wrapper end-->
    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ URL('/') }}/js/admin/jquery-ui-1.9.2.custom.min.js"></script>
<script src="{{ URL('/') }}/js/admin/jquery-migrate-1.2.1.min.js"></script>
<script src="{{ URL('/') }}/js/admin/bootstrap.min.js"></script>
<script src="{{ URL('/') }}/js/admin/modernizr.min.js"></script>
<script src="{{ URL('/') }}/js/admin/jquery.nicescroll.js"></script>

<!--common scripts for all pages-->
<script src="{{ URL('/') }}/js/admin/scripts.js"></script>
</body>
@endsection
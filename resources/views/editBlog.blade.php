@extends('master')
@section('title', 'Edit Blog')
@section('main') 
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Edit Blog
            </h3>
        </div>
        <!-- page heading end-->
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
			<div class="col-lg-8">
				<section class="panel">
					<div class="panel-body">
						@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif
					    @if (session('warning'))
							<div class="alert alert-danger">
								<p>{{ session('warning') }}</p>
							</div>
						@endif
						<form class="" method="post" action='/updateBlog' enctype="multipart/form-data">
							<input type='hidden' name='_token' value="{{csrf_token() }}" />
							<input type='hidden' name='blogid' value="{{$GetBlogData->blogid}}" />
							<div class="form-group">
                                <label>Blog Title <span class="red-error">*</span></label>
                                <input maxlength="150" type="text" class="form-control" id="title" placeholder="Blog Title" name="title" value="{{ $GetBlogData->title }}">
                            </div>
							<div class="form-group">
                                <label>Blog Image <span class="red-error">* <br>(Format only JPEG, JPG & PNG files are allowed)<br>(Size should be less than or equal 20MB)</span></label>
								<input name="blogimage" type="file" id="exampleInputFile">
								<img width="170" height="120" src="http://blogpost.dev{{ $UploadPath }}/{{ $GetBlogData->blogimage }}" />
								<input type="hidden" name="blogimage_old" value="{{$GetBlogData->blogimage}}">
							<div><br>
							<div class="form-group">
                                <label>Blog Content<span class="red-error">*</span></label>
                                <textarea rows='5' class="form-control" name='content_text'>{{$GetBlogData->content_text}}</textarea>
                            </div>							
                            <div class="form-group">
								<label>Status<span class="red-error">*</span></label>
								<select class="form-control" name="status">
									<option @if($GetBlogData->status==1) selected="selected" @endif value="1">Active</option>
									<option @if($GetBlogData->status==0) selected="selected" @endif value="0">Disabled</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Save</button>
						</form>	
					</div>
				</section>
			</div>
        </div>
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

<script type="text/javascript" src="{{ URL('/') }}/js/admin/jquery.validate.min.js"></script>
<script src="{{ URL('/') }}/js/admin/validation-init.js"></script>

<!--common scripts for all pages-->
<script src="{{ URL('/') }}/js/admin/scripts.js"></script>
@endsection
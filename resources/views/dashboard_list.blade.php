@extends('master')
@section('title', 'Dashboard')
@section('main')


@if(session('warning'))
<div class="alert alert-danger">
    <p>{{ session('warning') }}</p>
</div>
@endif

<h3>Dashboard</h3>
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
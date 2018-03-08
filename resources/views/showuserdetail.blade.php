<!--notification menu start -->
<div class="menu-right">
	<ul class="notification-menu">
		<li>
			@if(Cookie::get('sk') && Cookie::get('sk')!="")
			<a href="javascript:void(0);" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					{{Cookie::get('admin_user_name')}}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-usermenu pull-right" style="min-width:140px;">
				<li><a href="/logoutCMS"><i class="fa fa-sign-out"></i> Log Out</a></li>
			</ul>
			@else
			<a href="/login" class="btn btn-success btn-sm">
				<i class="fa-long-arrow-left"></i> Login
			</a>
			@endif
		</li>

	</ul>
</div>
<!--notification menu end -->
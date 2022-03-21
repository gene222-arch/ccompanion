<nav id="sidebar" class="sidebar-container">
    <div class="custom-menu">
      <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
  </div>
	<div class="p-3">
		<div class="row mb-5 mt-3 justify-content-center align-items-center">
			<div class="col-3">
				<img class="img img-responsive" src="{{ asset("logo.png") }}" width="40" height="40">
			</div>
			<div class="col">
				<h6><strong>{{ Auth::user()->name }}</strong></h6>
				<small>{{ Auth::user()->email }}</small>
			</div>
		</div>
      <ul class="list-unstyled components mb-5">
			<li class="{{ request()->is('/') ? 'active' : '' }}">
				<a href="/"><span class="fa-solid fa-home mr-3 {{ request()->is('/') ? 'text-info' : '' }}"></span> Dashboard</a>
			</li>
			@hasrole('Super Administrator')
				<li class="{{ request()->is('administrators') || request()->is('administrators/*') ? 'active' : '' }}">
					<a href="/administrators">
						<i class="fa-solid fa-user-shield mr-3 {{ request()->is('administrators') || request()->is('administrators/*') ? 'text-info' : '' }}"></i> 
					Administrators</a>
				</li>
			@endhasrole
			@hasanyrole('Super Administrator|Administrator')
				<li class="{{ request()->is('announcements') || request()->is('announcements/*') ? 'active' : '' }}">
					<a href="/announcements">
						<i class="fa-solid fa-newspaper mr-3 {{ request()->is('announcements') || request()->is('announcements/*') ? 'text-info' : '' }}"></i> 
					Announcements</a>
				</li>
			@endhasanyrole
			@hasanyrole('Super Administrator|Administrator|Registrar')
				<li class="{{ request()->is('courses') || request()->is('courses/*') ? 'active' : '' }}">
					<a href="/courses">
						<i class="fa-solid fa-graduation-cap mr-3 {{ request()->is('courses') || request()->is('courses/*') ? 'text-info' : '' }}"></i> 
					Courses</a>
				</li>
				<li class="{{ request()->is('departments') || request()->is('departments/*') ? 'active' : '' }}">
					<a href="/departments">
						<i class="fa-solid fa-building mr-4 {{ request()->is('departments') || request()->is('departments/*') ? 'text-info' : '' }}"></i> 
					Departments</a>
				</li>
				<li class="{{ request()->is('schedules') || request()->is('schedules/*') ? 'active' : '' }}">
					<a href="/schedules">
						<i class="fa-solid fa-calendar-day mr-4 {{ request()->is('schedules') || request()->is('schedules/*') ? 'text-info' : '' }}"></i> 
					Schedules</a>
				</li>
				<li class="{{ request()->is('subjects') || request()->is('subjects/*') ? 'active' : '' }}">
					<a href="/subjects">
						<i class="fa-solid fa-book mr-4 {{ request()->is('subjects') || request()->is('subjects/*') ? 'text-info' : '' }}"></i> 
					Subjects</a>
				</li>
				<li class="{{ request()->is('students') || request()->is('students/*') ? 'active' : '' }}">
					<a href="/students">
						<i class="fa-solid fa-user mr-4 {{ request()->is('students') || request()->is('students/*') ? 'text-info' : '' }}"></i> 
					Students</a>
				</li>
				<li class="{{ request()->is('professors') || request()->is('professors/*') ? 'active' : '' }}">
					<a href="/professors">
						<i class="fa-solid fa-chalkboard-user mr-3 {{ request()->is('professors') || request()->is('professors/*') ? 'text-info' : '' }}"></i> 
					Professors</a>
				</li>
			@endhasanyrole
			@hasanyrole('Super Administrator|Administrator')
				<li class="{{ request()->is('registrars') || request()->is('registrars/*') ? 'active' : '' }}">
					<a href="/registrars">
						<i class="fa-solid fa-user-tie mr-4 {{ request()->is('registrars') || request()->is('registrars/*') ? 'text-info' : '' }}"></i> 
					Registrars</a>
				</li>
				<li class="{{ request()->is('audit-trails') || request()->is('audit-trails/*') ? 'active' : '' }}">
					<a href="/audit-trails">
						<i class="fa-solid fa-book-open mr-4 {{ request()->is('audit-trails') || request()->is('audit-trails/*') ? 'text-info' : '' }}"></i> 
					Audit Trail</a>
				</li>
			@endhasanyrole
			<li>
				<a href="#" class="nav-link" onclick="document.getElementById('logout__form').submit()">
					<p><i class="fa-solid fa-arrow-right-from-bracket mr-4"></i>Logout</p>
					<form action="{{ route('logout') }}" method="POST" id="logout__form">
						@csrf
					</form>
              	</a>
			</li>
      </ul>

      <div class="footer">
		<p>Copyright &copy;
			<script>document.write(new Date().getFullYear());</script> All rights reserved
		</p>
      </div>

  </div>
</nav>
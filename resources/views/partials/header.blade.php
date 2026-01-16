<style>
@media (max-width: 576px) {
    .dropdown-menu {
        min-width: 18rem;
        max-width: calc(100vw - 30px);
        right: -10%;
    }
}
@media (max-width: 768px) {
	.dropdown-menu {
		min-width: 18rem;
		max-width: calc(100vw - 40px);
	}
}


</style>
<div id="content">
    <!-- top-bar -->
    <nav class="navbar navbar-light bg-light mb-xl-5 mb-4">
        <div class="container-fluid position-relative">

            <div class="navbar-header">
                <button type="button" id="sidebarCollapse" class="btn btn-prime navbar-btn float-start" style="background-color: #4463dc;">
                    <i class="fas fa-bars"></i>
                </button>
                
            </div>
            <div class="mx-auto">
                <h4>
                    
                </h4>
            </div>
            <ul class="top-icons-agileits-w3layouts float-end" style="position: relative;">
                <li class="nav-item dropdown" style="position: relative;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu drop-menu-end" style="right: 0;left: auto;min-width: 20rem;max-width: calc(100vw - 40px);padding: 1em;position: absolute;overflow-y: auto;max-height: 90vh;">
                        <div class="profile d-flex me-o">
                            <div class="profile-l align-self-center">
                                <img src="{{ asset('admin/images/logo.jpg') }}" class="img-fluid mb-3" alt="Responsive image">
                            </div>
                            <div class="profile-r align-self-center">
                                <h3 class="sub-title-w3-agileits">{{ Auth::user()->name}}</h3>
                                <a href="mailto:info@example.com">{{ Auth::user()->login}}</a>
                            </div>
                        </div>
                        <a href="{{ route('users.profile', Auth::user()->id) }}" class="dropdown-item mt-3">
                            <h4>
                                <i class="far fa-user me-3"></i>Mon profile</h4>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

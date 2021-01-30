<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('MK Care') }}
     
    </a>
    <span class="nav-link">  {{ Auth::user()->name }}</span>
    
     
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      @if( Auth::user()->hak_akses==0)
    
      <li class="nav-item{{ $activePage == 'pasien' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pasien.index') }}">
          <i class="material-icons">accessibility_new</i>
            <p>{{ __('Pasien') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'rekam' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('rekam.index') }}">
          <i class="material-icons">favorite</i>
            <p>{{ __('Rekam Medis') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
          <i class="material-icons">account_circle</i>
            <p>{{ __('User') }}</p>
        </a>
      </li>
      @elseif (Auth::user()->hak_akses==1)
      <li class="nav-item{{ $activePage == 'rekam' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('rekam.index') }}">
          <i class="material-icons">favorite</i>
            <p>{{ __('Rekam Medis') }}</p>
        </a>
      </li>
      @else 
      <li class="nav-item{{ $activePage == 'pasien' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pasien.index') }}">
          <i class="material-icons">accessibility_new</i>
            <p>{{ __('Pasien') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link text-white bg-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons text-white">exit_to_app</i>
          <p>{{ __('Logout') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>

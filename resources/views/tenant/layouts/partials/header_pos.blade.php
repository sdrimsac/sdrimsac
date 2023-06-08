<ul class="nav-menus">
    <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
    
    <li>
      <div class="mode"><i class="fa fa-lightbulb-o"></i></div>
    </li>
   
    <li class="onhover-dropdown p-0">
    <a class="btn btn-primary-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-power-off"></i> Salir
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
      </form>

    </li>
  </ul>
 
<ul class="nav-menus">
              <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
             
               @if($caja_cerrada===false)
                <li data-toggle="tooltip" data-placement="bottom" title="El Arqueo de Caja esta Pendiente">
                    <span class="text-success m-0 p-0" style="font: size 10px !important;"><b><i class="fas fa-coins"></i> Aperturada</b></span>
                </li>
               @endif
               @if($caja_cerrada===true)
                <li data-toggle="tooltip" data-placement="bottom" title="El Arqueo de Caja esta ya se Realizo">
                    <span class="text-danger"  style="font: size 10px !important;"><b><i class="fas fa-coins"></i> Caja Cerrada {{$vc_arqueo_date}} {{$vc_arqueo_hora}}</b></span>
                </li>
             @endif




              <li class="onhover-dropdown">
                <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span></div>
                <ul class="notification-dropdown onhover-show-div">
                  <li>
                    <p class="f-w-700 mb-0">You have 3 Notifications<span class="pull-right badge badge-primary badge-pill">4</span></p>
                  </li>
                  <li class="noti-primary">
                    <div class="media"><span class="notification-bg bg-light-primary"><i data-feather="activity"> </i></span>
                      <div class="media-body">
                        <p>Delivery processing </p><span>10 minutes ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-secondary">
                    <div class="media"><span class="notification-bg bg-light-secondary"><i data-feather="check-circle"> </i></span>
                      <div class="media-body">
                        <p>Order Complete</p><span>1 hour ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-success">
                    <div class="media"><span class="notification-bg bg-light-success"><i data-feather="file-text"> </i></span>
                      <div class="media-body">
                        <p>Tickets Generated</p><span>3 hour ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-danger">
                    <div class="media"><span class="notification-bg bg-light-danger"><i data-feather="user-check"> </i></span>
                      <div class="media-body">
                        <p>Delivery Complete</p><span>6 hour ago</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
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
 
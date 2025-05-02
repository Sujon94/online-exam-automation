<!-----Visible Only Mobile View---->
<div class="container d-block d-sm-none cus-bg-color p-0">
    <div class="row">
        <div class="col-sm-12">
        {{--<div class=" bg-primary">hide on lg and wider screens</div>--}}
            <div class="header-top-right d-flex justify-content-between">
                <ul>
                    <li><a href="tel:+8801727546514"><i class="fa fa-phone"></i>+880 1727-546514</a></li>
                    <li>
                        <a class="btn btn-sm btn-outline-warning badge rounded-pill blink" href="{{route('event.event-list')}}">Events</a>
                    </li>
                    <li>
                        <a class="btn btn-sm btn-outline-primary badge rounded-pill mt-1" href="{{route('skills.test-exams')}}">Skill Test</a>
                    </li>                    
                    @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::user()->user_role == \App\Enums\Role::STUDENT)
                        <li><a href="{{route('user-home')}}"><i class="fa fa-home"></i>Profile</a></li>
                    @else
                        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Dashboard</a></li>
                    @endif
                    @else
                        <li><a href="{{route('login')}}" {{--data-toggle="modal" data-target="#myModal"--}}><i class="fa fa-user"></i>login</a></li>
                        <li><a href="{{route('register')}}"><i class="fa fa-sign-in"></i>Sign up</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-----Visible Only Mobile View---->

<div class="header-top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-block d-sm-none bg-primary">hide on lg and wider screens</div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="header-top-left hidden-xs">
                    <ul>
                        {{--<li><a href="#"><i class="fa fa-envelope-o"></i><span class="__cf_email__" data-cfemail="046d6a626b446369656d682a676b69">[email&#160;protected]</span></a></li>--}}
                        <li><a href="#"><i class="fa fa-envelope-o"></i><span>info@abadhutit.com</span></a></li>
                        <li><a href="#"><i class="fa fa-phone"></i>+880 1727-546514</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="header-top-right">
                    <ul>
                        <li>
                            <a class="btn btn-sm btn-outline-warning badge rounded-pill blink" href="{{route('event.event-list')}}">Events</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary badge rounded-pill" href="{{route('skills.test-exams')}}">Skill Test</a>
                        </li>
                        @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            @if(\Illuminate\Support\Facades\Auth::user()->user_role == \App\Enums\Role::STUDENT)
                                <li><a href="{{route('user-home')}}"><i class="fa fa-home"></i>Profile</a></li>
                            @else
                                <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Dashboard</a></li>
                            @endif
                        @else
                            <li><a href="{{route('login')}}" {{--data-toggle="modal" data-target="#myModal"--}}><i class="fa fa-user"></i>login</a></li>
                            <li><a href="{{route('register')}}"><i class="fa fa-sign-in"></i>Sign up</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

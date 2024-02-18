@extends('front.layout.index')
@section('title')
<title>HOME | {{App\Models\Information::name()}}</title>
@endsection
@section('contents')
<div id="main" class="alt">
      <section>
        <div class="inner">
            <header class="major">
                <h2>HOME</h2>
            </header>
            <p>{!! App\Models\Information::homeContent() !!}</p>
        </div>
    </section>
    <section>
        <div class="inner">
            <header class="major">
                <h2>OUR SITES</h2>
            </header>
        </div>
    </section>
    <!-- Featured Cars -->
    <section class="tiles">
        @foreach(App\Models\User::site() as $user)
        <article>
            <span class="image">
                <img src="{{asset($user->image ? $user->image : 'front/images/site.jpeg' )}}" alt="" />
            </span>

            <header class="major">
                {{-- <p>
                    <i class="fa fa-dashboard"></i> 130 000km &nbsp;&nbsp;
                    <i class="fa fa-cube"></i> 1800cc&nbsp;&nbsp;
                    <i class="fa fa-cog"></i> Manual
                </p> --}}

                <h3>{{$user->username}}</h3>

                {{-- <p><del>$11199.00</del> <strong> $11179.00</strong></p> --}}

                <p>{!! @$user->description !!}</p>

                

                <div class="major-actions">
                    <a href="{{url('user/login')}}" class="button small next">Sign In</a>
                </div>
            </header>
        </article>
        @endforeach
    </section>
</div>
@endsection
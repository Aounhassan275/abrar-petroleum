@extends('front.layout.index')
@section('title')
<title>HOME | {{App\Models\Information::name()}}</title>
@endsection
@section('contents')
<div id="main" class="alt">
      <section>
        <div class="inner">
            <header class="major">
                <h2>HOME PAGE</h2>
            </header>
            <p>{!! App\Models\Information::homeContent() !!}</p>
        </div>
    </section>
</div>
@endsection
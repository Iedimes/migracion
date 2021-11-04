@extends('brackets/admin-ui::admin.layout.external')
@section('header')
    @include('brackets/admin-ui::admin.partials.header')
@endsection
@section('content')
    <div class="app-body">
        <main class="main">
            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>

                @yield('body')
            </div>
        </main>
    </div>
@endsection
@section('bottom-scripts')
    @parent
@endsection

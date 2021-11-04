@extends('brackets/admin-ui::admin.layout.master')

@section('header')
    @include('brackets/admin-ui::admin.partials.header')
@endsection

@section('content')

    <div class="app-body">

        @if(View::exists('admin.layout.sidebar'))
            @include('admin.layout.sidebar')
        @endif

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

    <footer class="app-footer">
        <div class="container-fluid">
            <div class="container-xl">
            <span class="pull-right">
                Desarrollado por <a href="https://www.muvh.gov.py/" target="_blank" style="color: #002555">DGTIC - MUVH</a>
            </span>
            </div>
        </div>
    </footer>
@endsection

@section('bottom-scripts')
    @parent
@endsection

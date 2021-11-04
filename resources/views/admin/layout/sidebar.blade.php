<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/projects') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.project.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/project-has-expedientes') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.project-has-expediente.title') }}</a></li>
           <!--<li class="nav-item"><a class="nav-link" href="{{ url('admin/project-has-postulantes') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.project-has-postulante.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/postulantes') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.postulante.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/postulante-has-beneficiaries') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.postulante-has-beneficiary.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/parentescos') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.parentesco.title') }}</a></li>-->
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

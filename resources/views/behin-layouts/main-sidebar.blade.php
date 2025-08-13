
<aside class="md-sidebar">
    <div class="md-sidebar-header">
        <img src="{{ url('public/behin/behin-dist/dist/img/avatar5.png') }}" class="md-sidebar-avatar" alt="User Image">
        <span class="md-sidebar-name">{{ auth()->user()->name ?? ''}}</span>
    </div>

    <nav class="md-sidebar-nav">
        <ul>
            @foreach (config('sidebar.menu') as $menu)
                @if ( access('منو >>' .$menu['fa_name']) )
                    <li class="md-sidebar-item">
                        <a href="#" class="md-sidebar-link has-sub">
                            <div class="flex items-center">
                                <i class="md-sidebar-icon @isset($menu['icon']) {{$menu['icon']}} @endisset"></i>
                                <span>{{ $menu['fa_name'] }}</span>
                            </div>
                            <i class="fa fa-chevron-left md-sidebar-chevron"></i>
                        </a>
                        <ul class="md-sidebar-submenu">
                            @foreach ($menu['submenu'] as $submenu)
                                @if ( access('منو >>' .$menu['fa_name'] . '>>' . $submenu['fa_name'] ) )
                                    <li>
                                        <a
                                            @isset($submenu['target']) target="{{ $submenu['target'] }}" @endisset
                                            href="@if(Route::has($submenu['route-name']))
                                                        {{ route($submenu['route-name']) }}
                                                    @elseif(isset($submenu['static-url']))
                                                        {{ $submenu['static-url'] }}
                                                    @else
                                                        {{ url($submenu['route-url']) }}
                                                    @endif"
                                            class="md-sidebar-sublink">
                                            <i class="fa fa-circle md-sidebar-subicon"></i>
                                            <span>{{ $submenu['fa_name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.md-sidebar-link.has-sub').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            link.parentElement.classList.toggle('open');
        });
    });
});
</script>



<ul class="nav nav-tabs nav-fill border-light">
    @foreach (\App\Models\Language::all() as $key => $language)
        @if(!Request::exists('lang'))
            <li class="nav-item">
                <a class="nav-link text-reset @if ($language->code == 'en') active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route($route_name, array_merge($params, ['lang'=> $language->code]) ) }}">
                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                    <span>{{ $language->name }}</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route($route_name, ['district'=>$district->id, 'lang'=> $language->code] ) }}">
                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                    <span>{{ $language->name }}</span>
                </a>
            </li>
        @endif

    @endforeach
</ul>

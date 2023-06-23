<ol class="breadcrumb">
    @foreach($breadcrumbs as $breadcrumb)
        @if ($breadcrumb['active'] ?? false)
            <li class="breadcrumb-item active">
                {{$breadcrumb['text']}}
            </li>
        @else
            <li class="breadcrumb-item">
                <a href="{{$breadcrumb['url']}}">{{$breadcrumb['text']}}</a>
            </li>
        @endif
    @endforeach
</ol>

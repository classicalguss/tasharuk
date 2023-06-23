    @if($user->profile_photo_url)
        <img src="{{ $user->profile_photo_url }}" alt class="{{$class ?? 'rounded-circle'}}">
    @else
        @php
            $colors =  ['success', 'danger', 'secondary', 'warning', 'info', 'dark', 'primary'];
            $colorClass = $colors[$user->id %7];
			$names = explode(' ', $user->name);
            $firstName = $names[0];
            $firstInitial = strtoupper(substr($firstName, 0, 1));
			$initials = $firstInitial;

			if (count($names) > 1) {
                    $lastName = $names[count($names) - 1];
                    $lastInitial = strtoupper(substr($lastName, 0, 1));
                    $initials = $initials . $lastInitial;
			}
        @endphp
        <span class="avatar-initial {{$class ?? 'rounded-circle'}} bg-label-{{$colors[0]}}">{{$initials}}</span>
    @endif
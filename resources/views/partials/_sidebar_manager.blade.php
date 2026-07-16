<div class="overflow-x-auto">
    <div class="scrollbar min-w-max">
        <span class="text-neutral-500 fw-normal text-14 mb-8 d-block">
            Bonjour, {{ auth()->user()->display_name }} 👋
        </span>

        <ul>
            @php
                $navItems = [
                    ['route' => 'manager.dashboard', 'icon' => 'ph-bold ph-house', 'label' => 'Tableau de bord'],
                    ['route' => 'manager.events.index', 'icon' => 'ph ph-calendar', 'label' => 'Événements'],
                    ['route' => 'manager.blogs.index', 'icon' => 'ph ph-newspaper', 'label' => 'Blog'],
                    ['route' => 'manager.contact-messages.index', 'icon' => 'ph ph-chat-dots', 'label' => 'Messages'],
                    ['route' => 'manager.gallery.index', 'icon' => 'ph ph-image', 'label' => 'Albums photo'],
                    ['route' => 'manager.profile', 'icon' => 'ph ph-user-circle', 'label' => 'Mon profil'],
                ];
            @endphp

            @foreach($navItems as $item)
                @if(Route::has($item['route']))
                    <li class="mb-8">
                        <a href="{{ route($item['route']) }}"
                           class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap {{ request()->routeIs($item['route']) ? 'bg-main-600 text-white' : '' }}">
                            <span class="text-16 text-main-600 item-hover__text transition-03">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
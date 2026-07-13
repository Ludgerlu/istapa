<div class="overflow-x-auto">
    <div class="scrollbar min-w-max">
        <span class="text-neutral-500 fw-normal text-14 mb-8 d-block">
            Bonjour, {{ auth()->user()->first_name }} 👋
        </span>

        <ul>
            <li class="mb-8">
                <a href="{{ route('gestionnaire.dashboard') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('gestionnaire.dashboard') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph-bold ph-house"></i>
                    </span>
                    Tableau de bord
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('gestionnaire.blogs.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('gestionnaire.blogs.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-newspaper"></i>
                    </span>
                    Blog
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('gestionnaire.events.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('gestionnaire.events.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-calendar"></i>
                    </span>
                    Événements
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('gestionnaire.contact-messages.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('gestionnaire.contact-messages.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-chat-dots"></i>
                    </span>
                    Messages
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('gestionnaire.profile') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('gestionnaire.profile') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-user-circle"></i>
                    </span>
                    Mon profil
                </a>
            </li>
        </ul>
    </div>
</div>

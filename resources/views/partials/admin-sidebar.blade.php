<div class="overflow-x-auto">
    <div class="scrollbar min-w-max">
        <span class="text-neutral-500 fw-normal text-14 mb-8 d-block">
            Bonjour, {{ auth()->user()->first_name }} 👋
        </span>

        <ul>
            <li class="mb-8">
                <a href="{{ route('admin.dashboard') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.dashboard') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph-bold ph-house"></i>
                    </span>
                    Tableau de bord
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.users.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.users.index', 'admin.users.create', 'admin.users.edit') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-student"></i>
                    </span>
                    Utilisateurs
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.attendance.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.attendance.index', 'admin.attendance.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-chalkboard-teacher"></i>
                    </span>
                    Présence
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.classes.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.classes.index', 'admin.classes.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-books"></i>
                    </span>
                    Classes
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.subjects.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.subjects.index', 'admin.subjects.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-notepad"></i>
                    </span>
                    Matières
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.exams.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.exams.index', 'admin.exams.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-exam"></i>
                    </span>
                    Examens
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.fees.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.fees.index', 'admin.fees.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-money"></i>
                    </span>
                    Frais scolaires
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.events.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.events.index', 'admin.events.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-calendar"></i>
                    </span>
                    Événements
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.blogs.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.blogs.index', 'admin.blogs.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-newspaper"></i>
                    </span>
                    Blog
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.contact-messages.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.contact-messages.index') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-chat-dots"></i>
                    </span>
                    Messages
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.gallery.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.gallery.index', 'admin.gallery.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-image"></i>
                    </span>
                    Albums photo
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.admissions.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.admissions.index', 'admin.admissions.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-user-plus"></i>
                    </span>
                    Admissions
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.leaves.index') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.leaves.index', 'admin.leaves.*') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-door-open"></i>
                    </span>
                    Congés
                </a>
            </li>

            <li class="mb-8">
                <a href="{{ route('admin.profile') }}"
                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                          {{ request()->routeIs('admin.profile') ? 'bg-main-600 text-white' : '' }}">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-user-circle"></i>
                    </span>
                    Mon profil
                </a>
            </li>
        </ul>
    </div>
</div>

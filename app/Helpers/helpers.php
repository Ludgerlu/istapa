<?php

if (! function_exists('getUserDashboardRoute')) {
    /**
     * Get the dashboard URL for a given role.
     *
     * @param  string  $role
     * @return string
     */
    function getUserDashboardRoute(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.dashboard'),
            'gestionnaire' => route('gestionnaire.dashboard'),
            default => '/',
        };
    }
}

if (! function_exists('redirectToUserDashboard')) {
    /**
     * Redirect the user to their dashboard.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    function redirectToUserDashboard($user)
    {
        $role = is_string($user) ? $user : ($user->role ?? $user->usertype ?? null);

        return redirect()->to(getUserDashboardRoute($role ?? ''));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Accept pending team invitation if exists
        $token = session('team_invitation_token');
        if ($token) {
            $invitation = TeamInvitation::where('token', $token)
                ->whereNull('accepted_at')
                ->first();

            if ($invitation) {
                TeamMember::create([
                    'team_id' => $invitation->team_id,
                    'user_id' => $user->id,
                    'role' => $invitation->role,
                ]);
                $invitation->update(['accepted_at' => now()]);
                $user->update(['current_team_id' => $invitation->team_id]);
                session()->forget('team_invitation_token');

                return redirect(route('dashboard', absolute: false))
                    ->with('success', 'Welcome! You have joined ' . $invitation->team->name);
            }
        }

        return redirect(route('dashboard', absolute: false));
    }
}

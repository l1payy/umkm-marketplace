<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo_path = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $types = (array) $request->input('payout_type', []);
        $providers = (array) $request->input('payout_provider', []);
        $accounts = (array) $request->input('payout_account', []);
        $labels = (array) $request->input('payout_label', []);
        $rows = [];
        foreach ($accounts as $i => $acc) {
            $type = isset($types[$i]) ? (string) $types[$i] : '';
            $provider = isset($providers[$i]) ? (string) $providers[$i] : '';
            $acc = trim((string) $acc);
            $label = isset($labels[$i]) ? (string) $labels[$i] : null;
            if ($acc !== '' && in_array($type, ['bank','ewallet','qris']) && $provider !== '') {
                $rows[] = compact('type','provider','acc','label');
            }
        }
        if (empty($rows)) {
            $bankProvider = trim((string) $request->input('bank_provider', ''));
            $bankAcc = trim((string) $request->input('bank_account_number', ''));
            $ewProvider = trim((string) $request->input('ewallet_provider', ''));
            $ewAcc = trim((string) $request->input('ewallet_number', ''));
            if ($bankProvider !== '' && $bankAcc !== '') {
                $rows[] = ['type' => 'bank', 'provider' => $bankProvider, 'acc' => $bankAcc, 'label' => null];
            }
            if ($ewProvider !== '' && $ewAcc !== '') {
                $rows[] = ['type' => 'ewallet', 'provider' => $ewProvider, 'acc' => $ewAcc, 'label' => null];
            }
        }
        if (!empty($rows)) {
            \App\Models\UserPayout::where('user_id', $user->id)->delete();
            foreach ($rows as $idx => $r) {
                \App\Models\UserPayout::create([
                    'user_id' => $user->id,
                    'type' => $r['type'],
                    'provider' => $r['provider'],
                    'account_number' => $r['acc'],
                    'label' => $r['label'],
                    'is_default' => $idx === 0,
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\LinkRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    ) {
    }

    public function show(): View
    {
        return view('registration');
    }

    public function register(Request $request): View
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
        ]);

        $link = $this->linkRepository->createByUserId($user->id);

        return view('success', [
            'access_url' => route('links.show', $link->uid),
            'expired_date' => $link->expired_date,
            'success_text' => 'Registration Successful!',
        ]);
    }
}

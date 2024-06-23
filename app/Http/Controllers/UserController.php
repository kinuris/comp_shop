<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\ProductRestock;
use App\Models\ProductSnapshot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.index')
            ->with('users', $users);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'gender' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'birthdate' => ['required', 'date'],
            'contact_number' => ['required', 'unique:users'],
        ]);

        $validated['password'] = password_hash(strtolower($validated['first_name']) . strtolower($validated['last_name']), PASSWORD_BCRYPT);
        $validated['fk_gender'] = $validated['gender'];
        $validated['fk_role'] = $validated['role'];
        $validated['suspended'] = false;

        while (true) {
            $companyId = 'HP-' . str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);

            if (User::query()->where('company_id', '=', $companyId)->first() === null) {
                $validated['company_id'] = $companyId;
                break;
            }
        }

        User::create($validated);

        return redirect('/employee')->with('message', 'Successfully created user ' . $validated['company_id']);
    }

    public function show(User $user)
    {
        return $user->first_name . " " . $user->last_name;
    }

    public function edit(User $user)
    {
        return view('user.edit')->with('user', $user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['nullable'],
            'gender' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'birthdate' => ['required', 'date'],
            'contact_number' => [
                'required',
                Rule::unique('users')->ignore($user),
            ],
        ]);

        $validated['fk_gender'] = $validated['gender'];
        $validated['fk_role'] = $validated['role'];

        $user->update($validated);

        return redirect('/employee')->with('message', 'Successfully updated user ' . $user->company_id);
    }

    public function suspend(User $user)
    {
        $user->update([
            'suspended' => !$user->suspended,
        ]);

        return redirect('/employee')->with('message', $user->suspended ? 'Suspended user ' . $user->company_id : 'Resumed user ' . $user->company_id);
    }

    // NOTE: Resource methods are above

    public function peek_history(Request $request, User $user)
    {
        if ($user->isManager() || $user->isAdmin()) {
            $productChanges = ProductSnapshot::query()
                ->where('fk_user', '=', $user->user_id)
                ->get();

            $restocks = ProductRestock::query()
                ->where('fk_user', '=', $user->user_id)
                ->get();

            $combined = array();
            foreach ($productChanges as $change) {
                array_push($combined, $change);
            }

            foreach ($restocks as $stock) {
                array_push($combined, $stock);
            }

            uasort($combined, function ($a, $b) {
                return date_create($b->created_at) <=> date_create($a->created_at);
            });

            return view('user.change-log')
                ->with('user', $user)
                ->with('changes', $combined);
        }

        if ($user->isEmployee()) {
            $history = $user->getProcessedOrders() ?? [];

            if ($request->query('search')) {
                $similar = array_filter(array_keys($history), fn ($rec) => str_contains($rec, $request->query('search')));

                $history = array_intersect_key($history, array_flip($similar));
            }

            $daily = array();
            foreach ($history as $tid => $items) {
                if (date_create(PaymentTransaction::query()->find($tid)->created_at) > date_create('yesterday')) {
                    $daily[$tid] = $items;
                }
            }

            $view = view('user.history')
                ->with('peek_user', $user->user_id);

            $tid = $request->query('modal');
            if ($tid) {
                $transaction = PaymentTransaction::find($tid);

                if ($transaction) {
                    $res = app('App\Http\Controllers\PaymentTransactionController')
                        ->html_generate_modal($transaction);

                    $transaction = PaymentTransaction::query()->find($tid);

                    $view = $view
                        ->with('modal', $res->content())
                        ->with('transaction', $transaction);
                }
            }

            return $view
                ->with('history', $daily);
        }
    }

    public function view_change_password(User $user)
    {
        return view('user.password-change')->with('user', $user);
    }

    public function change_password(Request $request, User $user)
    {
        $validated = $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'different:old_password'],
            'new_password_confirmation' => ['required', 'same:new_password']
        ]);

        if (password_verify($validated['old_password'], $user->password)) {
            $validated['password'] = password_hash($validated['new_password'], PASSWORD_BCRYPT);
            $user->update($validated);

            return redirect('/')->with('message', 'Successfully changed password');
        }

        return back()->with('error', 'Wrong password');
    }

    public function login_view()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        // NOTE To Self: Php can have implicit returns
        $validated = $request->validate(
            [
                'company_id' => ['required', 'exists:users'],
                'password' => ['required'],
            ]
        );

        $user = User::query()->where('company_id', '=', $validated['company_id'])->first();
        if ($user->suspended) {
            return back()->with('error', 'Account Suspended');
        }

        if (!auth()->attempt($validated)) {
            return back()->with('error', 'Wrong company ID or password');
        }

        $request->session()->regenerate();

        return redirect()->to('/');
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/login');
    }

    public function history(Request $request)
    {
        $history = auth()
            ->user()
            ->getProcessedOrders() ?? [];

        if ($request->query('search')) {
            $similar = array_filter(array_keys($history), fn ($rec) => str_contains($rec, $request->query('search')));

            $history = array_intersect_key($history, array_flip($similar));
        }

        $daily = array();
        foreach ($history as $tid => $items) {
            if (date_create(PaymentTransaction::query()->find($tid)->created_at) > date_create('yesterday')) {
                $daily[$tid] = $items;
            }
        }

        $view = view('user.history');

        $tid = $request->query('modal');
        if ($tid) {
            $transaction = PaymentTransaction::find($tid);

            if ($transaction) {
                $res = app('App\Http\Controllers\PaymentTransactionController')
                    ->html_generate_modal($transaction);

                $transaction = PaymentTransaction::query()->find($tid);

                $view = $view
                    ->with('modal', $res->content())
                    ->with('transaction', $transaction);
            }
        }

        return $view
            ->with('history', $daily);
    }
}

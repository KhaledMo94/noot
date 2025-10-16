<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Laravolt\Avatar\Facade as Avatar;
use App\Http\Controllers\Controller;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashiers = User::with(['serviceProviderBranch.serviceProvider'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'cashier');
            })->get();

        return view('admin.cashiers.index', compact('cashiers'));
    }


    public function create()
    {
        return view('admin.cashiers.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'                                  => 'required|string|max:255',
            'email'                                 => 'nullable|required_without:phone_number|email|unique:users,email',
            'status'                                => 'required|in:active,inactive',
            'provider_cashier_id'                   => 'nullable|exists:service_providers,id',
//            'service_provider_branch_id'            => 'required|exists:service_provider_branches,id',
            'password'                              => ['required', Password::min(8)],
            're_password'                           => 'required|same:password',
            'image'                                 => 'nullable|image|max:2048',
        ]);

//        if (! DB::table('service_provider_branches')
//            ->where('id', $request->service_provider_branch_id)
//            ->where('service_provider_id', $request->provider_cashier_id)
//            ->exists()) {
//            return redirect()->back()->with('error', __('Branch Not belong To Service Provider'));
//        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('users', 'public');
        } else {
//            $avatar = Avatar::create($request->name)->toBase64();
//            $image_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $avatar));
//            $filename = 'users/' . uniqid() . '.png';
//            Storage::disk('public')->put($filename, $image_content);
//            $image_path = $filename;
        }

        $user = User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'status'                => $request->status,
            'phone_verified_at'     => now(),
            'email_verified_at'     => now(),
            'image'                 => $image_path,
            'service_provider_branch_id' => $request->service_provider_branch_id,
            'password'              => Hash::make($request->password),
        ]);

        $user->assignRole('cashier');

        return redirect()->route('admins.cashiers.index')
            ->with('success', __('Cashier Added Successfully'));
    }


    public function edit(string $id)
    {
        $cashier = User::with(['serviceProviderBranch'])->findOrFail($id);
        return view('admin.cashiers.edit', compact('cashier'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'                                  => 'required|string|max:255',
            'email' => 'nullable|required_without:phone_number|email|unique:users,email,' . $id,
            'country_code'                          => 'nullable|required_without:email|required_with:phone_number|string|max:5',
            'phone_number'                          => 'nullable|required_without:email|required_with:country_code|string|max:15',
            'status'                                => 'required|in:active,inactive',
            'service_provider_id'                   => 'required|exists:service_providers,id',
            'service_provider_branch_id'            => 'required|exists:service_provider_branches,id',
            'password'                              => ['nullable', 'required_with:re_password', Password::min(8)],
            're_password'                           => 'nullable|required_with:password|same:password',
            'image'                                 => 'nullable|image|max:2048',
            'gender'                                => 'required|in:f,m',
        ]);

        if (! DB::table('service_provider_branches')
            ->where('id', $request->service_provider_branch_id)
            ->where('service_provider_id', $request->service_provider_id)
            ->exists()) {
            return redirect()->back()->with('error', __('Branch Not belong To Service Provider'));
        }

        $cashier = User::findOrFail($id);
        if ($request->hasFile('image')) {
            Controller::deleteFile($cashier->image);
            $image = $request->file('image');
            $image_path = $image->store('users', 'public');
        } elseif ($request->has('remove_image')) {
            if ($cashier->image) {
                Controller::deleteFile($cashier->image);
            }
            $avatar = Avatar::create($request->name)->toBase64();
            $image_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $avatar));
            $filename = 'users/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $image_content);
            $image_path = $filename;
        } else {
            $avatar = Avatar::create($request->name)->toBase64();
            $image_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $avatar));
            $filename = 'users/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $image_content);
            $image_path = $filename;
        }

        $cashier->update([
            'email'                 => $request->email,
            'country_code'          => $request->country_code ?? '+20',
            'phone_verified_at'     => now(),
            'email_verified_at'     => now(),
            'sex'                   => $request->gender ?? 'm',
            'service_provider_branch_id'    => $request->service_provider_branch_id,
            'name'                  => $request->name,
            'phone_number'          => $request->phone_number,
            'status'                => $request->status,
            'image'                 => $image_path,
            'password'              => $request->has('password') ? Hash::make($request->password) : $cashier->password,
        ]);

        return redirect()->route('admins.cashiers.index')
            ->with('success', __('Cashier Updated Successfully'));
    }


    public function destroy(string $id)
    {
        $cashier = User::findOrFail($id);
        if ($cashier->image) {
            Controller::deleteFile($cashier->image);
        }
        $cashier->delete();
        return redirect()->route('admins.cashiers.index')
            ->with('success', __('Cashier Deleted Successfully'));
    }

    private function isAvatarImage(string $imagePath): bool
    {
        return preg_match('/users\/[a-f0-9]{13,}\.png$/', $imagePath);
    }
}

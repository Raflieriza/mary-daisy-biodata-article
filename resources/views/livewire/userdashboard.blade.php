<?php

use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public function assignAdminRole()
    {
        $user = Auth::user();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }

    public function removeAdminRole()
    {
        $user = Auth::user();
        if ($user && $user->hasRole('admin')) {
            $user->removeRole('admin');
        }
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
};
<?
n

<
<div >
    <h1 class = "text-xl font-bold" > User Dashboard </h1 >

    <p class = "mt-4" >
@if(auth()->user()->hasRole('admin'))
    Anda adalah seorang Admin.
@else
    Anda bukan Admin.
    @endif
    </p>

    <button wire:click="assignAdminRole" class="bg-blue-500 text-white px-4 py-2 mt-2">Jadikan Admin</button>
    <button wire:click="removeAdminRole" class="bg-red-500 text-white px-4 py-2 mt-2">Hapus Role Admin</button>
    </div>


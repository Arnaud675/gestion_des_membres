<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembersCheckRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all(); // récupère tous les membres
        return view('members.index', compact('members'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas ajouter de membres.');
        }
        return view('members.create');
    }

    public function store(MembersCheckRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas ajouter de membres.');
        }

        $data = $request->except('photo');

        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', config('filesystems.default'));
        }

        Member::create($data);

        return redirect()->route('members.index')
            ->with('success', 'Membre ajouté avec succès !');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }


    public function edit($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas modifier les membres.');
        }
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas modifier les membres.');
        }

        $member = Member::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', config('filesystems.default'));
        }
        $member->update($data);
        return redirect()->route('members.show', $member->id)->with('success', 'Membre mis à jour.');
    }

    public function destroy($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas supprimer les membres.');
        }

        $member = Member::findOrFail($id);

        // Supprimer la photo si elle existe
        $disk = config('filesystems.default');
        if ($member->photo && Storage::disk($disk)->exists($member->photo)) {
            Storage::disk($disk)->delete($member->photo);
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Membre supprimé avec succès !');
    }
}

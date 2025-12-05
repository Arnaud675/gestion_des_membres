<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembersCheckRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(MembersCheckRequest $request)
    {
        // $request->validate([
        //     'name'   => 'required|string|max:255',
        //     'email'  => 'required|email|unique:members',
        //     'phone'  => 'nullable|string',
        //     'photo'  => 'nullable|image|max:2048',
        // ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Membre ajouté avec succès !');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(MembersCheckRequest $request, $id)
    {
        $member = Member::findOrFail($id);

        // $request->validate([
        //     'name'   => 'required',
        //     'email'  => 'required|email|unique:members,email,' .$id,
        //     'phone'  => 'nullable',
        //     'photo'  => 'nullable|image|max:2048',
        // ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Membre modifié avec succès !');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Membre supprimé avec succès !');
    }
}

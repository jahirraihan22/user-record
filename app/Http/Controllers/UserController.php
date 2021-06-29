<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'User List';
        $data['users'] = User::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'User Regitration';
        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users',
            'address' => 'required',
            'image' => 'required|mimes:jpeg,png'
        ]);
        try {
            $imageName = '';
            if ($request->hasFile('image')) {
                $imageName = $this->imageUpload($request, Str::slug($request->f_name . '-' . $request->l_name));
            }

            User::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'image' => $imageName,
            ]);
            return redirect()->route('user.index')->with('success', 'user created successfully!');
        } catch (Exception $e) {
            Log::channel('developersLog')->info('|====> user insertion => ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::findOrFail($id);
        return view('admin.user.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Information';
        $data['user'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'address' => 'required',
            'image' => 'mimes:jpeg,png'
        ]);
        try {
            $imageName = '';

            if ($request->hasFile('image')) {
                $imageName = $this->imageUpload($request, Str::slug($request->f_name . '-' . $request->l_name));
            }
            $user = User::findOrFail($id);
            $user->f_name = $request->f_name;
            $user->l_name = $request->l_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;

            if ($request->hasFile('image')) {
                Storage::delete(str_replace('storage', 'public', $user->image));
                $user->image = $imageName;
            }

            $user->update();
            return redirect()->route('user.index')->with('success', 'user Updated successfully!');
        } catch (Exception $e) {
            Log::channel('developersLog')->info('|====> user insertion => ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return redirect()->back()->with('success', 'User removed succesfully!');
        } catch (Exception $e) {
            Log::channel('developersLog')->info('|====> User Delete => ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! please try again');
        }
    }

    public function imageUpload(Request $request, $slug)
    {
        // php artisan storage:link
        $imageName = strtotime('now') . '_' . $slug . '.' . $request->file('image')->getClientOriginalExtension();
        $imageNameWithPath = 'users/' . $imageName;
        $request->file('image')->storeAs('public/', $imageNameWithPath);
        return 'storage/' . $imageNameWithPath;
    }
}

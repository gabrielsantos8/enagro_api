<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $path = 'perfil_images';
        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($path . '/' . $fileName, $file->getContent());
            $url = env('APP_URL') . '/storage/' . $path . '/' . $fileName;
            $user = User::find($request->user_id);
            $user->update(['image_url' => $url]);
            return response()->json(['success' => true], 200);
        }
        return response()->json(['success'=> false, 'message' => 'Nenhuma imagem enviada']);
    }

    public function uploadAnimal(Request $request)
    {
        $path = 'animal_images';
        if ($request->hasFile('foto_animal')) {
            $file = $request->file('foto_animal');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($path . '/' . $fileName, $file->getContent());
            $url = env('APP_URL') . '/storage/' . $path . '/' . $fileName;
            $user = Animal::find($request->animal_id);
            $user->update(['img_url' => $url]);
            return response()->json(['success' => true], 200);
        }
        return response()->json(['success'=> false, 'message' => 'Nenhuma imagem enviada']);
    }
}

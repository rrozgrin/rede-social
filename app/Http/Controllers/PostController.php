<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        // dd($data);
        DB::beginTransaction();
        try {
            // Verifique se os anexos existem
            if ($request->hasFile('attachments')) {
                $post = Post::create($data);

                /** @var \Illuminate\Http\UploadedFile[] $files */
                $files = $request->file('attachments');

                foreach ($files as $file) {
                    $filePath = $file->store('attachments/' . $post->id, 'public');
                    PostAttachment::create([
                        'post_id' => $post->id,
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'mime' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'created_by' => $user->id,
                    ]);
                }
            } else {
                // Se não houver anexos, apenas crie o post
                $post = Post::create($data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Retorna um redirecionamento com mensagem de erro
            return back()->withErrors(['error' => 'Falha ao armazenar o post. Por favor, tente novamente.']);
        }

        // Retorna um redirecionamento com mensagem de sucesso
        return back()->with('success', 'Post salvo com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //TODO
        $id = Auth::id();
        if ($post->user_id !== $id) {
            return "Sem acesso para excluir esse post";
        }

        $post->delete();
        return back();
    }
}

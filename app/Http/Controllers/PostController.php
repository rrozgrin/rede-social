<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Http\Enums\ReactionEnum;
use App\Models\PostReaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                        'mime' => $file->getClientMimeType(),
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
        $user = $request->user();

        DB::beginTransaction();
        $allFilePaths = [];
        try {
            $data = $request->validated();
            $post->update($data);

            $deleted_ids = $data['deleted_file_ids'] ?? []; // 1, 2, 3, 4

            $attachments = PostAttachment::query()
                ->where('post_id', $post->id)
                ->whereIn('id', $deleted_ids)
                ->get();

            foreach ($attachments as $attachment) {
                $attachment->delete();
            }

            /** @var \Illuminate\Http\UploadedFile[] $files */
            $files = $data['attachments'] ?? [];
            foreach ($files as $file) {
                $path = $file->store('attachments/' . $post->id, 'public');
                $allFilePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            foreach ($allFilePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }

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

    public function postReaction(Request $request, Post $post)
    {
        $data = $request->validate([
            'reaction' => [Rule::enum(ReactionEnum::class)]
        ]);

        $userId =Auth::id();
        $reaction = PostReaction::where('user_id', $userId)->where('post_id', $post->id)->first();

        if ($reaction){
            $hasReaction = false;
            $reaction->delete();
        }else {
            $hasReaction = true;
            PostReaction::create([
                'post_id' => $post->id,
                'user_id' => $userId,
                'type' => $data['reaction']
            ]);
        }
                
        $reactions = PostReaction::where('post_id', $post->id)->count();

        return response([
            'num_reactions' => $reactions,
            'current_user_has_reation' => $hasReaction
        ]);
    }
}

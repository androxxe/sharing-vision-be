<?php

namespace App\Http\Controllers\Api;

use App\Enums\PostStatusEnum;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use BenSampo\Enum\Rules\EnumValue;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Exception;
use Throwable;

class PostController extends Controller
{
    function index(int $limit, int $offset)
    {
        try {
            $post = Post::query()->limit($limit)->offset($offset)->get();

            return ResponseFormatter::success('Post list retrieved successfully', $post);
        } catch (Exception $error) {
            return ResponseFormatter::internalServerError($error);
        }
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:200',
                'content' => 'required|string',
                'category' => 'required|string|min:3|max:100',
                'status' => ['required', new EnumValue(PostStatusEnum::class)],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::validationError($validator->errors());
            }

            $validated = $validator->validated();

            $post =  Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category' => $validated['category'],
                'status' => $validated['status'],
            ]);

            return ResponseFormatter::success('Post created successfully', $post, 201);
        } catch (\Exception $error) {
            return ResponseFormatter::internalServerError($error);
        }
    }

    function show($post_id)
    {
        $post = Post::query()->find($post_id);
        if (!$post) {
            return ResponseFormatter::notFound();
        }

        try {
            return ResponseFormatter::success('Post retrieved successfully', $post);
        } catch (NotFoundHttpException |  NotFoundResourceException | Exception | Throwable $error) {
            return ResponseFormatter::internalServerError($error);
        }
    }

    function update(Request $request, $post_id)
    {
        $post = Post::query()->find($post_id);
        if (!$post) {
            return ResponseFormatter::notFound();
        }

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:200',
                'content' => 'nullable|string',
                'category' => 'nullable|string|min:3|max:100',
                'status' => ['nullable', new EnumValue(PostStatusEnum::class)],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::validationError($validator->errors());
            }

            $validated = $validator->validated();

            $post->update([
                'title' => $validated['title'] ?? $post->title,
                'content' => $validated['content'] ?? $post->content,
                'category' => $validated['category'] ?? $post->category,
                'status' => $validated['status'] ?? $post->status,
            ]);

            return ResponseFormatter::success('Post updated successfully', $post, 202);
        } catch (Exception $error) {
            return ResponseFormatter::internalServerError($error);
        }
    }

    function destroy($post_id)
    {
        $post = Post::query()->find($post_id);
        if (!$post) {
            return ResponseFormatter::notFound();
        }
        
        try {
            $post->delete();
            return ResponseFormatter::success('Post deleted successfully', null);
        } catch (Exception $error) {
            return ResponseFormatter::internalServerError($error);
        }
    }
}

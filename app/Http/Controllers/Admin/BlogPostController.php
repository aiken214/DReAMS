<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBlogPostRequest;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogPost;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogPostController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('blog_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogPosts = BlogPost::all();

        return view('admin.blogPosts.index', compact('blogPosts'));
    }

    public function create()
    {
        abort_if(Gate::denies('blog_post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blogPosts.create');
    }

    public function store(StoreBlogPostRequest $request)
    {
        $blogPost = BlogPost::create($request->all());

        return redirect()->route('admin.blog-posts.index');
    }

    public function edit(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blogPosts.edit', compact('blogPost'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {
        $blogPost->update($request->all());

        return redirect()->route('admin.blog-posts.index');
    }

    public function show(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blogPosts.show', compact('blogPost'));
    }

    public function destroy(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogPost->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlogPostRequest $request)
    {
        $blogPosts = BlogPost::find(request('ids'));

        foreach ($blogPosts as $blogPost) {
            $blogPost->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

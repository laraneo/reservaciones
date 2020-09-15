<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminCategoriesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Categories Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking categories views
    | to admin, to show all categories, provide ability to edit and delete
    | specific category.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;
        }

        Category::create($input);

        //set session message
        Session::flash('category_created', __('backend.category_created'));

        //redirect back to categories.index
        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $input = $request->all();

        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;

            //find category
            $category = Category::findOrFail($id);

            //unlink old photo if set
            if($category->photo != NULL)
            {
                unlink(public_path().$category->photo->file);
            }

            //delete data from photos table
            Photo::destroy($category->photo_id);
        }

        //update data into categories table
        Category::findOrFail($id)->update($input);

        //set session message and redirect back categories.index
        Session::flash('category_updated', __('backend.category_updated'));
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific category
        $category = Category::findOrFail($id);

        if($category->photo)
        {
            //unlink image
            unlink(public_path().$category->photo->file);

            //delete from photo table
            Photo::destroy($category->photo_id);
        }

        //delete category
        Category::destroy($category->id);

        //set session message and redirect back to categories.index
        Session::flash('category_deleted', __('backend.category_deleted'));
        return redirect('/categories');
    }
}

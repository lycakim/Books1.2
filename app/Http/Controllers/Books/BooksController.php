<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    //
    public function UserBookTable(){
        $id = Auth::user()->id;
        $books = Books::where('userID', $id)->latest()->get();
        // $books = Books::latest()->get();
        return view('user.user_bookupload', compact('books'));
        // return view('admin.admin_dashboard');
    } // End Method

    public function EditBook($id){
        $booksData = Books::where('id', $id)->latest()->get();
        // $profileData = User::find($id);
        return view('user.user_add_book', compact('booksData'));
    } // End Method

    public function UserBookAdd(){
        $booksData = [];
        return view('user.user_add_book', compact('booksData'));
    } // End Method

    public function UserUploadBook(Request $request){
        $valid = $request->validate([
            'book_name' => 'required',
            'book_desc' => 'required'
        ],['book_desc.required' => 'The book description field is required.']);

            $notification = array(
                'message' => $request->message,
                'alert-type' => 'warning'
            );
            $book = Books::create([
                'book_name' => $request->book_name,
                'book_desc' => $request->book_desc,
                'userID' => auth()->user()->id
            ]);

            $notification = array(
                'message' => 'Book Successfully Uploaded',
                'alert-type' => 'success'
            );
            return redirect()->intended('/user/book/table')->with($notification);
            // return redirect()->back()->with($notification);

    } // End Method

    public function BookSaveChanges(Request $request){
        $id = $request->id;
        $data = Books::find($id); 
        $data->allowed_users = (array)$request->allowed_users;
        // foreach($allowed_users as $key => $item){
        //     $data->allowed_users = $item;
        // }
        $data->book_name = $request->book_name;
        $data->book_desc = $request->book_desc;

        if ($request->file('cover_image')){
            $file = $request->file('cover_image');
            @unlink(public_path('upload/cover_images/'.$data->cover_image));
            $filename = date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('upload/cover_images'),$filename);
            $data->cover_image = $filename;
            echo $filename;
        }
        $data->save();
        // Books::where('id', $request->id)->update([
        //     'book_name' => $request->book_name,
        //     'book_desc' => $request->book_desc,
        // ]);

        $notification = array(
            'message' => 'Book Successfully Updated',
            'alert-type' => 'success'
        );
        return redirect()->intended('/user/book/table')->with($notification);
    } // End Method

    public function DeleteBook($id){
        Books::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Book Successfully Deleted',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }



}
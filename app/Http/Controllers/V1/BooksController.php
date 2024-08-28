<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Repositories\AuthorsRepository;
use App\Repositories\BooksRepository;
use App\Validations\BooksValidation;
use Illuminate\Http\Request;

use stdClass;

class BooksController extends Controller
{
    private $authorsRepo;
    private $booksRepo;
    private $output;

    public function __construct()
    {
        $this->authorsRepo  = new AuthorsRepository();
        $this->booksRepo    = new BooksRepository();

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function store(Request $request)
    {
        BooksValidation::createBooksValidation($request);

        $getAuthors = $this->authorsRepo->getAuthors(['id' => $request->author_id]);
        
        if(empty($getAuthors->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }

        $dataBooks = new Books();
        $dataBooks->title           = $request->title;
        $dataBooks->description     = empty($request->description) ? null : $request->description;
        $dataBooks->publish_date    = $request->publish_date;
        $dataBooks->author_id       = $request->author_id;

        $createBooks = $this->booksRepo->createBooks($dataBooks);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Simpan data buku berhasil.';

        return response()->json($this->output);
    }

    public function index() 
    {
        $getListBooks = $this->booksRepo->getListBooks([]);
        
        if(empty($getListBooks->toArray())){
            throw new DataNotFoundException("Data buku tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry data list buku berhasil.';
        $this->output->responseData = $getListBooks;

        return response()->json($this->output);
    }

    public function show($id = null){
        $request = new Request();
        $request->merge(['id' => $id]);

        BooksValidation::inquiryBooksValidation($request);

        $filterBooks = [
            'id' => $request->id,
        ];

        $getBooks = $this->booksRepo->getBooks($filterBooks);
        
        if(empty($getBooks->toArray())){
            throw new DataNotFoundException("Data buku tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry data buku berhasil.';
        $this->output->responseData = $getBooks;

        return response()->json($this->output);
    }

    public function update(Request $request)
    {
        BooksValidation::updateBooksValidation($request);

        $filterAuthors = [
            'id' => $request->id,
        ];

        $getBooks = $this->booksRepo->getBooks($filterAuthors);
        
        if(empty($getBooks->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }

        $getBooks->title = empty($request->title) ? $getBooks->title : $request->title;
        $getBooks->description = empty($request->description) ? $getBooks->description : $request->description;
        $getBooks->publish_date = empty($request->publish_date) ? $getBooks->publish_date : $request->publish_date;
        
        if(!empty($request->author_id)){
            $getAuthors = $this->authorsRepo->getAuthors(['id' => $request->author_id]);
            
            if(empty($getAuthors->toArray())){
                throw new DataNotFoundException("Data authors tidak ditemukan.");
            }

            $getBooks->publish_date = $request->author_id;
        }

        $updateBooks = $this->booksRepo->updateBooks($getBooks);

        if($updateBooks === FALSE){
            throw new InvalidRuleException("Update data buku gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data buku berhasil.';

        return response()->json($this->output);
    }

    public function delete($id = null)
    {
        $request = new Request();
        $request->merge(['id' => $id]);

        BooksValidation::idBooksValidation($request);

        $deleteBooks = $this->booksRepo->deleteBooks(['id' => $request->id]);

        if($deleteBooks === FALSE){
            throw new InvalidRuleException("Delete data buku gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data buku berhasil.';

        return response()->json($this->output);
    }

    public function showAssociation($id = null, $flag = null)
    {
        $request = new Request();

        $arrExtend = [
            'id' => $id,
            'flag' => $flag
        ];

        $request->merge($arrExtend);

        BooksValidation::inquiryBooksValidation($request);
    }
}

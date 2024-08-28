<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Http\Controllers\Controller;
use App\Models\Authors;
use App\Repositories\AuthorsRepository;
use App\Repositories\BooksRepository;
use App\Validations\AuthorsValidation;
use Illuminate\Http\Request;
use stdClass;
use DB;

class AuthorsController extends Controller
{
    private $authorsRepo;
    private $booksRepo;
    private $output;

    public function __construct(AuthorsRepository $authorsRepo, BooksRepository $booksRepo)
    {
        $this->authorsRepo  = $authorsRepo;
        $this->booksRepo    = $booksRepo;

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function index() 
    {
        $getListAuthors = $this->authorsRepo->getListAuthors([]);
        
        if(empty($getListAuthors->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry data list author berhasil.';
        $this->output->responseData = $getListAuthors;

        return response()->json($this->output);
    }

    public function show($id = null, $flag = null){
        $request = new Request();

        $arrExtend = [
            'id' => $id,
            'flag' => $flag
        ];

        $request->merge($arrExtend);

        AuthorsValidation::inquiryAuthorsValidation($request);

        $filterAuthors = [
            'id' => $request->id,
        ];

        if(empty($request->flag)){
            $getAuthors = $this->authorsRepo->getAuthors($filterAuthors);
        }else{
            $getAuthors = $this->authorsRepo->associate();
        }
        
        if(empty($getAuthors->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry data author berhasil.';
        $this->output->responseData = $getAuthors;

        return response()->json($this->output);
    }

    public function store(Request $request)
    {
        AuthorsValidation::createAuthorValidation($request);

        $authors = new Authors();
        $authors->name = $request->nama;
        $authors->bio = empty($request->bio) ? null : $request->bio;
        $authors->birth_date = $request->tgl_lahir;

        $createAuthors = $this->authorsRepo->createAuthors($authors);

        if($createAuthors === FALSE){
            throw new InvalidRuleException("Simpan data author gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Simpan data author berhasil.';

        return response()->json($this->output);
    }
    
    public function update(Request $request)
    {
        AuthorsValidation::updateAuthorValidation($request);

        $filterAuthors = [
            'id' => $request->id,
        ];

        $getAuthors = $this->authorsRepo->getAuthors($filterAuthors);
        
        if(empty($getAuthors->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }
 
        $getAuthors->name = empty($request->nama) ? $getAuthors->name : $request->nama;
        $getAuthors->bio = empty($request->bio) ? $getAuthors->bio : $request->bio;
        $getAuthors->birth_date = empty($request->tgl_lahir) ? $getAuthors->birth_date : $request->tgl_lahir;

        $updateAuthors = $this->authorsRepo->updateAuthors($getAuthors);

        if($updateAuthors === FALSE){
            throw new InvalidRuleException("Update data author gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data author berhasil.';

        return response()->json($this->output);
    }

    public function delete($id = null)
    {
        $request = new Request();
        $request->merge(['id' => $id]);

        AuthorsValidation::idAuthorValidation($request);

        $filterAuthors = [
            'id' => $request->id,
        ];

        $getAuthors = $this->authorsRepo->getAuthors($filterAuthors);
        
        if(empty($getAuthors->toArray())){
            throw new DataNotFoundException("Data authors tidak ditemukan.");
        }

        DB::transaction(function () use ($getAuthors){
            $deleteAuthor = $this->authorsRepo->deleteAuthors(['id' => $getAuthors->id]);
            
            if($deleteAuthor === FALSE){
                throw new InvalidRuleException("Delete data author gagal.");
            }
            
            $deleteBooks = $this->booksRepo->deleteBooks(['author_id' => $getAuthors->id]);
            
            if($deleteBooks === FALSE){
                throw new InvalidRuleException("Delete data buku gagal.");
            }
        });


        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data author berhasil.';

        return response()->json($this->output);
    }
}

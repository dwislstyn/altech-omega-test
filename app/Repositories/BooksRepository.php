<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Books;
use DB;

class BooksRepository{

    public function getListBooks(array $filter)
    {
        $query = DB::table('mst_books');
        
        if(!empty($filter['id'])){
            $query->where('id', $filter['id']);
        }

        $result = $query->get();
        return $result;
    }

    public function getBooks(array $data)
    {
        $query = DB::table('mst_books');
        $query->where('id', $data['id']);

        $dataResult = (array) $query->first();

        $result = new books($dataResult);
        return $result;
    }

    public function createBooks(Books $data)
    {
        $databooks = $data->toArray();
        
        try {
            DB::table('mst_books')->insert($databooks);
            
            return TRUE;
        } catch (\Throwable $th) {
            return TRUE;
        }
    }

    public function updateBooks(books $data)
    {
        $databooks = $data->toArray();
        
        try {
            DB::table('mst_books')->where('id', $databooks['id'])->update($databooks);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

    public function deleteBooks(array $data): bool
    {
        $query = DB::table('mst_books');

        if(!empty($data['id'])){
            $query->where('id', $data['id']);
        }
        
        if(!empty($data['author_id'])){
            $query->where('author_id', $data['author_id']);
        }

        try {
            $query->delete();
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }
}
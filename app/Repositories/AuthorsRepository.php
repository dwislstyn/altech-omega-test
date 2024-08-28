<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Authors;
use DB;

class AuthorsRepository{

    public function getListAuthors(array $filter)
    {
        $query = DB::table('mst_authors');
        
        if(!empty($filter['id'])){
            $query->where('id', $filter['id']);
        }

        $result = $query->get();
        return $result;
    }

    public function getAuthors(array $data)
    {
        $query = DB::table('mst_authors');
        $query->where('id', $data['id']);

        $dataResult = (array) $query->first();

        $result = new Authors($dataResult);
        return $result;
    }

    public function createAuthors(Authors $data)
    {
        $dataAuthors = $data->toArray();
        
        try {
            DB::table('mst_authors')->insert($dataAuthors);
            
            return TRUE;
        } catch (\Throwable $th) {
            return TRUE;
        }
    }

    public function updateAuthors(Authors $data)
    {
        $dataAuthors = $data->toArray();
        
        try {
            DB::table('mst_authors')->where('id', $dataAuthors['id'])->update($dataAuthors);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

    public function deleteAuthors(array $data): bool
    {
        $query = DB::table('mst_authors')->where('id', $data['id']);

        try {
            $query->delete();
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

    public function associate()
    {
        $query = DB::table('mst_books');
        $query->leftJoin('mst_authors', 'mst_books.author_id', '=', 'mst_authors.id');
        $query->select('mst_books.title', 'mst_books.description', 'mst_books.publish_date', 'mst_authors.name as name_author');
        
        return $query->get();
    }
}
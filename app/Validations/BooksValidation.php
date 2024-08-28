<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BooksValidation{
    
    public static function inquiryBooksValidation(Request $request)
    {
        $rules = [
            'id'    => 'nullable|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function idBooksValidation(Request $request)
    {
        $rules = [
            'id'  => 'required|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }

    public static function createBooksValidation(Request $request)
    {
        $rules = [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'publish_date'  => 'required|date_format:Y-m-d',
            'author_id'     => 'required|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function updateBooksValidation(Request $request)
    {
        $rules = [
            'id'            => 'required|numeric',
            'title'         => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
            'publish_date'  => 'nullable|date_format:Y-m-d',
            'author_id'     => 'nullable|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}
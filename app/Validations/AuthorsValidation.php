<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthorsValidation{
    
    public static function inquiryAuthorsValidation(Request $request)
    {
        $rules = [
            'id'   => 'nullable|numeric',
            'flag'  => 'nullable|in:books'
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function idAuthorValidation(Request $request)
    {
        $rules = [
            'id'  => 'required|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }

    public static function createAuthorValidation(Request $request)
    {
        $rules = [
            'nama'      => 'required|string|max:255',
            'bio'       => 'nullable|string|max:255',
            'tgl_lahir' => 'required|date_format:Y-m-d',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function updateAuthorValidation(Request $request)
    {
        $rules = [
            'id'        => 'required|numeric',
            'nama'      => 'nullable|string|max:255',
            'bio'       => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date_format:Y-m-d',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}
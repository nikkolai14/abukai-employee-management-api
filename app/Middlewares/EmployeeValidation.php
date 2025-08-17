<?php

namespace App\Middlewares;

use App\Core\Validator;
use App\Core\Response;

class EmployeeValidation {
    public function handle($request, $next) {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|string',
            'position' => 'required|string',
            'salary' => 'required|positive_number'
        ];

        $data = $request->getAllPostData();

        $validator = new Validator();
        $validator->validate($data, $rules);

        if (! $validator->passes()) {
            return (new Response())->errors($validator->errors(), 422);
        }

        return $next($request);
    }
}